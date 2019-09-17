<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    /**
    * The table associated with the model.
    *
    */
    protected $table = 'Invoices';

    public function getInvoicesByServiceCategory($request)
    {
        $date = explode(' - ', $request->daterange);
        $from = $date[0];
        $to = $date[1];

        $category = ServiceCategory::findOrFail($request->category_id);
        $categories = ServiceCategory::select('Id', 'Name')->get();
        
        try {
            $invoiceDetailed = [];
        
            // Get all the services for this category
            $categoryServices = $category->services;
            $catInvoiceIds = [];

            foreach ($categoryServices as $key => $service) {
                $actualServiceIds = [];
                $serviceInvoiceIds = InvoiceDetail::select('InvoiceId')->whereIn('ServiceId', [$service->Id])->pluck('InvoiceId')->toArray();

                if(count($serviceInvoiceIds) > 0) {

                    foreach ($serviceInvoiceIds as $s_id) {
                        if(!in_array($s_id, $catInvoiceIds)){
                            array_push($catInvoiceIds, $s_id);
                        }

                        if(!in_array($s_id, $actualServiceIds)){
                            $invoiceID = Invoice::whereDate('Time','>=', $from)->whereDate('Time', '<=', $to)->where('Id', $s_id)->first();
                            
                            if($invoiceID){
                                array_push($actualServiceIds, $s_id);
                            }
                        }

                    }

                    $servicetotalFees = Invoice::selectRaw('SUM(TotalFees) as total_fees')->whereIn('Id', $serviceInvoiceIds)
                                        ->whereDate('Time','>=', $from)->whereDate('Time', '<=', $to)
                                        ->pluck('total_fees')->toArray()[0];
                }else {
                    $servicetotalFees = 0;
                }
                
                
                $invoiceDetailed[$key]['service_name'] = $service->Name;
                $invoiceDetailed[$key]['count_invoices'] = intVal(count($actualServiceIds));
                $invoiceDetailed[$key]['totalFees'] = $servicetotalFees == null ? 0 : intVal($servicetotalFees);
               
            }

            $totalFees = array();
            foreach ($invoiceDetailed as $key => $row)
            {
                $totalFees[$key] = $row['totalFees'];
            }
            array_multisort($totalFees, SORT_DESC, $invoiceDetailed);

            $cateTotalFees = 0;
            foreach ($invoiceDetailed as $key => $value) {
                $cateTotalFees += $value['totalFees'];
            }
            $catServiceDetailsCount = 0;
            foreach ($invoiceDetailed as $key => $value) {
                $catServiceDetailsCount += $value['count_invoices'];
            }

            $total = (object)[
                'totalFees' => $cateTotalFees == null ? 0 : $cateTotalFees,
                'totalInvoices' => $catServiceDetailsCount == null ? 0 : $catServiceDetailsCount
            ];

            return [
                    'services' => $invoiceDetailed, 
                    'categories' => $categories, 
                    'total' => $total,
                    'category' => $category,
                    'daterange' => $request->daterange
                ];
            
            // return view('admin.invoicesReport.categoryServices')->withInvoices($invoiceDetailed)->withCategories($categories)->withTotal($total);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function getInvoicesForOffices($request)
    {
        try {
            
            if(isset($request->daterange)){
                $date = explode(' - ', $request->daterange);
                $from = $date[0];
                $to = $date[1];
            }else {
                $from = '';
                $to = '';
            }

            $district = District::select('Id', 'Name')->where('Id', $request->district_id)->first();

            $oficeDetails = [];

            $offices = Office::select('Id', 'Name', 'Latitude', 'Longitude')->where('DistrictId', $district->Id)->get();

            foreach ($offices as $key => $office) {
                $userIds = $office->getUserIds($office->Id);
                $officeEmployees = Employee::where('OfficeId', $office->Id)->count();
                $totalFees = Invoice::selectRaw('SUM(TotalFees) as total_fees')->whereIn('UserId', $userIds)
                    ->where(function($query) use ($from, $to) {
                        if($from !== '' && $to !== '') {
                            $query->whereDate('Time','>=', $from)->whereDate('Time', '<=', $to);
                        }
                    })
                    ->orderBy('total_fees')
                    ->pluck('total_fees')
                    ->toArray()[0];
                
                $officeInvoices = Invoice::selectRaw('Id, TotalFees')->whereIn('UserId', $userIds)
                    ->where(function($query) use ($from, $to) {
                        if($from !== '' && $to !== '') {
                            $query->whereDate('Time','>=', $from)->whereDate('Time', '<=', $to);
                        }
                    })
                    ->pluck('Id')->toArray();

                    
                $serviceCount = InvoiceDetail::whereIn('InvoiceId', $officeInvoices)->count();

                $oficeDetails[$key]['office_name'] = $office->Name;
                $oficeDetails[$key]['total_fees'] = $totalFees == null ? 0 : $totalFees;
                $oficeDetails[$key]['n_invoices'] = count($officeInvoices);
                $oficeDetails[$key]['n_serviceCount'] = $serviceCount;
                $oficeDetails[$key]['n_employees'] = $officeEmployees;
                $oficeDetails[$key]['lat'] = $office->Latitude;
                $oficeDetails[$key]['long'] = $office->Longitude;
            }

            $totalFees = array();
            foreach ($oficeDetails as $key => $row)
            {
                $totalFees[$key] = $row['total_fees'];
            }
            array_multisort($totalFees, SORT_DESC, $oficeDetails);

            $countOfTotalFees = 0;
            foreach ($oficeDetails as $office) {
                $countOfTotalFees += $office['total_fees'];
            }

            $countOfInvoices = 0;
            foreach ($oficeDetails as $office) {
                $countOfInvoices += $office['n_invoices'];
            }

            $countInvoiceServices = 0;
            foreach ($oficeDetails as $office) {
                $countInvoiceServices += $office['n_serviceCount'];
            }

            $total = (object)[
                'totalFees' => $countOfTotalFees,
                'totalInvoices' => $countOfInvoices,
                'totalInvoiceDatails' => $countInvoiceServices
            ];

            
            return [
                'invoices' => $oficeDetails,
                'offices' => $offices,
                'total' => $total,
                'district' => $district,
                'daterange' => $request->daterange
            ];
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function getInvoicesByMobileRequestByOffice($request)
    {
        try {
            
            if(isset($request->daterange)){
                $date = explode(' - ', $request->daterange);
                $from = $date[0];
                $to = $date[1];
            }else {
                $from = '';
                $to = '';
            }

            $invoiceDetailed = [];
            $district = District::select('Id', 'Name')->where('Id', $request->district_id)->first();
            $offices = Office::select('Id', 'Name')->where('DistrictId', $district->Id)->get();
           
            foreach ($offices as $key => $office) {
                $userIds = $office->getUserIds($office->Id);
                $office_MobileInvoices = Invoice::select('Id')->where('Origin', 2)->whereIn('UserId', $userIds)
                        ->where(function($query) use ($from, $to) {
                            if($from !== '' && $to !== '') {
                                $query->whereDate('Time','>=', $from)->whereDate('Time', '<=', $to);
                            }
                        })->pluck('Id')->toArray();

                $office_OfficeInvoices =  Invoice::select('Id')->where('Origin', 1)->whereIn('UserId', $userIds)
                                        ->where(function($query) use ($from, $to) {
                                            if($from !== '' && $to !== '') {
                                                $query->whereDate('Time','>=', $from)->whereDate('Time', '<=', $to);
                                            }
                                        })->pluck('Id')->toArray();
                
                $office_MobileInvoicesCount = InvoiceDetail::whereIn('InvoiceId', $office_MobileInvoices)->count();
                $office_OfficeInvoicesCount = InvoiceDetail::whereIn('InvoiceId', $office_OfficeInvoices)->count();

                $invoiceDetailed[$key]['office_name'] = $office->Name;
                $invoiceDetailed[$key]['nb_mobile_invoices'] = $office_MobileInvoicesCount;
                $invoiceDetailed[$key]['nb_office_invoices'] = $office_OfficeInvoicesCount;
            }

            $invoices = array();
            foreach ($invoiceDetailed as $key => $row)
            {
                if ($row['nb_mobile_invoices'] > $row['nb_office_invoices']) {
                    $invoices[$key] = $row['nb_mobile_invoices'];
                }else {
                    $invoices[$key] = $row['nb_office_invoices'];
                }
            }
            array_multisort($invoices, SORT_DESC, $invoiceDetailed);

            $sumMobileInvoices = 0;
            $sumOfficeInvoices = 0;

            foreach ($invoiceDetailed as $key => $office) {
                $sumMobileInvoices += $office['nb_mobile_invoices'];
            }

            foreach ($invoiceDetailed as $key => $office) {
                $sumOfficeInvoices += $office['nb_office_invoices'];
            }

            $total = (object)[
                'sumMobileInvoices' => $sumMobileInvoices,
                'sumOfficeInvoices' => $sumOfficeInvoices
            ];
            
            return [
                'invoices' => $invoiceDetailed,
                'offices' => $offices,
                'total' => $total,
                'district' => $district,
                'daterange' => $request->daterange
            ];
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }
    
    public function getQuarterInvoicesByMobileRequestByOffice()
    {
        try {

            $now = now()->startOfMonth();
            $quarterAhead = now()->addMonths(-3)->firstOfMonth();

            $invoiceDetailed = [];
            $offices = Office::select('Id', 'Name')->get();
           
            foreach ($offices as $key => $office) {
                $userIds = $office->getUserIds($office->Id);
                $office_MobileInvoices = Invoice::select('Id')->where('Origin', 2)->whereIn('UserId', $userIds)
                        ->where(function($query) use ($now, $quarterAhead) {
                            if($now !== '' && $quarterAhead !== '') {
                                $query->whereDate('Time','>=', $quarterAhead)->whereDate('Time', '<=', $now);
                            }
                        })->pluck('Id')->toArray();

                $office_OfficeInvoices =  Invoice::select('Id')->where('Origin', 1)->whereIn('UserId', $userIds)
                                        ->where(function($query) use ($quarterAhead, $now) {
                                            if($quarterAhead !== '' && $now !== '') {
                                                $query->whereDate('Time','>=', $quarterAhead)->whereDate('Time', '<=', $now);
                                            }
                                        })->pluck('Id')->toArray();
                
                $office_MobileInvoicesCount = InvoiceDetail::whereIn('InvoiceId', $office_MobileInvoices)->count();
                $office_OfficeInvoicesCount = InvoiceDetail::whereIn('InvoiceId', $office_OfficeInvoices)->count();

                $invoiceDetailed[$key]['office_name'] = $office->Name;
                $invoiceDetailed[$key]['nb_mobile_invoices'] = $office_MobileInvoicesCount;
                $invoiceDetailed[$key]['nb_office_invoices'] = $office_OfficeInvoicesCount;
            }

            $invoices = array();
            foreach ($invoiceDetailed as $key => $row)
            {
                if ($row['nb_mobile_invoices'] > $row['nb_office_invoices']) {
                    $invoices[$key] = $row['nb_mobile_invoices'];
                }else {
                    $invoices[$key] = $row['nb_office_invoices'];
                }
            }
            array_multisort($invoices, SORT_DESC, $invoiceDetailed);

            $sumMobileInvoices = 0;
            $sumOfficeInvoices = 0;

            foreach ($invoiceDetailed as $key => $office) {
                $sumMobileInvoices += $office['nb_mobile_invoices'];
            }

            foreach ($invoiceDetailed as $key => $office) {
                $sumOfficeInvoices += $office['nb_office_invoices'];
            }

            $total = (object)[
                'sumMobileInvoices' => $sumMobileInvoices,
                'sumOfficeInvoices' => $sumOfficeInvoices
            ];
            
            return [
                'invoices' => $invoiceDetailed,
                'offices' => $offices,
                'total' => $total
            ];

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function getInvoicesPerMonth()
    {
        try {
            $data['totalFeesPerMonth'] = DB::table('Invoices')->select(DB::raw('SUM(TotalFees) as total_fees'), DB::raw('MONTH(Time) as month'))
                                    ->groupBy(DB::raw('MONTH(TIME)'))->get();
            $data['totalInvoicesPerMonth'] = DB::table('Invoices')->select(DB::raw('COUNT(Id) as total_invoices'), DB::raw('MONTH(Time) as month'))
                                        ->groupBy(DB::raw('MONTH(TIME)'))->get();
            $data['maxInvoices'] = DB::table('Invoices')->select(DB::raw('COUNT(Id) as max_invoices'))->first();

            $data['maxFees'] = DB::table('Invoices')->fromSub(
                                    DB::table('Invoices')->select(DB::raw('SUM(TotalFees) as total_fees'), DB::raw('MONTH(Time) as month'))
                                    ->groupBy(DB::raw('MONTH(TIME)')), 'TotalFees', function($query) {
                                        $query->select(DB::raw('MAX(TotalFees) as max_fees'));
                                    })->max('total_fees');
        
            return response()->json($data);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function getInvoiceMonthly($request)
    {
        try {

            if(isset($request->daterange)){
                $date = explode(' - ', $request->daterange);
                $from = $date[0];
                $to = $date[1];
            }else {
                $from = '';
                $to = '';
            }

            $monthlyInvoices = [];
            $district = District::select('Id', 'Name')->where('Id', $request->district_id)->first();
            $districtOffices = Office::select('Id', 'Name')->where('DistrictId', $district->Id)->get();
            $districtUserIds = [];
            foreach ($districtOffices as $office) {
                $userIds = $office->getUserIds($office->Id);
                foreach ($userIds as $userId) {
                    array_push($districtUserIds, $userId);    
                }
            }

           // Get all the months
           $months = [];

           for ($m=1; $m<=12; $m++) {
               array_push($months, [
                   'id' => $m,
                   'name' => date('F', mktime(0,0,0,$m, 1, date('Y')))
               ]);
           }
           
           foreach ($months as $key => $month) {
                $monthInvoicesIds = [];
                $monthInvoices = Invoice::selectRaw('Id')->WhereRaw('MONTH(Time) = ' . $month['id'])
                                    ->whereIn('UserId', $districtUserIds)
                                    ->where(function($query) use ($from, $to) {
                                        if($from !== '' && $to !== '') {
                                            $query->whereDate('Time','>=', $from)->whereDate('Time', '<=', $to);
                                        }
                                    })
                                    ->get()->toArray();

                foreach ($monthInvoices as $invoice) {
                    array_push($monthInvoicesIds, $invoice['Id']);
                }

                if(count($monthInvoicesIds) > 0){
                    $monthInvoiceCount = InvoiceDetail::whereIn('InvoiceId', $monthInvoicesIds)->count();

                    $monthlyInvoices[$key]['month'] = $month['name'];
                    $monthlyInvoices[$key]['nb_invoices'] = $monthInvoiceCount == null ? 0 : $monthInvoiceCount;
                }
                
           }

           
        //    $totalFees = array();
        //    foreach ($monthlyInvoices as $key => $row)
        //    {
        //        $totalFees[$key] = $row['nb_invoices'];
        //    }
        //    array_multisort($totalFees, SORT_DESC, $monthlyInvoices);

           $totalInvoices = 0;
           foreach ($monthlyInvoices as $key => $month)
           {
                $totalInvoices += $month['nb_invoices'];
           }

            return [
                'monthlyInvoices' => $monthlyInvoices,   
                'totalInvoices' => $totalInvoices,
                'district' => $district,
                'daterange' => $request->daterange
            ];

        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function getInvoiceMonthlyProcessTime($request)
    {
        try {

            if(isset($request->daterange)){
                $date = explode(' - ', $request->daterange);
                $from = $date[0];
                $to = $date[1];
            }else {
                $from = '';
                $to = '';
            }
            
           $districtUserIds = [];

            $district = District::select('Id', 'Name')->where('Id', $request->district_id)->first();
            $offices = Office::select('Id', 'Name')->where('DistrictId', $district->Id)->get();

            foreach ($offices as $office) {
                $userIds = $office->getUserIds($office->Id);
                foreach ($userIds as $userId) {
                    array_push($districtUserIds, $userId);    
                }
            }

            $monthlyInvoices = DB::table('Invoices')->select(
                DB::raw('COUNT(Id) as total_invoices'),
                DB::raw("MONTH(Time) as m"), 
                DB::raw("DATENAME(mm, Time) as month"),
                DB::raw("SUM(ProcessingTime) as total_process_time"),
                DB::raw('AVG(ProcessingTime) as process_time'), 
                DB::raw('YEAR(Time) as year'))
                ->whereIn('UserId', $districtUserIds)
                ->where(function($query) use ($from, $to) {
                    if($from !== '' && $to !== '') {
                        $query->whereDate('Time','>=', $from)->whereDate('Time', '<=', $to);
                    }
                })
                ->groupBy(DB::raw('MONTH(Time)'), 
                            DB::raw("DATENAME(mm, Time)"),
                            DB::raw('YEAR(Time)'))->get();

            return [
                'monthlyInvoices' => $monthlyInvoices,
                'offices' => $offices,
                'district' => $district,
                'daterange' => $request->daterange
            ];

        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function getMobileRequestIdsFromInvoices($officeId)
    {
        $mobileRequestIds = [];
        $invoices = Invoice::select('TotalFees', 'MobileRequestId', 'Origin')->get();
        foreach ($invoices as $invoice) {

            // Get Mobile Req for each invoice and get it's office ID
            $mobileRequest = MobileRequest::select('Id', 'OfficeId')->where('Id', $invoice->MobileRequestId)->first();

            // Check if the OfficeID matched the requested Office ID
            if(isset($mobileRequest->OfficeId) && $officeId == $mobileRequest->OfficeId){
                if(!in_array($mobileRequest->Id, $mobileRequestIds)){
                    array_push($mobileRequestIds, $mobileRequest->Id);    
                }
            }
        }
        return $mobileRequestIds;
    }

    public function getInvoiceQuarterlyProcessTime()
    {
        try {

            $offices = Office::all();
            $quarterlyInvoicesPerOffice = [];

            // Get all the months
            $months = [];

            for ($m=1; $m<=3; $m++) {
                array_push($months, [
                    'id' => date('n', strtotime(-$m . ' month')),
                    'name' => date('M', strtotime(-$m . ' month'))
                ]);
            }

            $months = array_reverse($months);
            foreach ($months as $mkey => $month) {
                foreach ($offices as $key => $office) {
                    $procTime = $this->getProccTimeForOfficePerMonth($office->Id, $month['id'])['process_time'];
                    $quarterlyInvoicesPerOffice[$key][$mkey]['office_name'] = $office->Name;
                    $quarterlyInvoicesPerOffice[$key][$mkey]['procTime'] = $procTime == null ? 0 : $procTime;
                    
                }
            }


            foreach ($quarterlyInvoicesPerOffice as $key => $office) {
                $index1 = $quarterlyInvoicesPerOffice[$key][0]['procTime'];
                $index2 = $quarterlyInvoicesPerOffice[$key][1]['procTime'];
                $index3 = $quarterlyInvoicesPerOffice[$key][2]['procTime'];
                $firstCheck = $index3 > $index2;
                $secCheck = $index2 > $index1;
                
                if($firstCheck && $secCheck){
                    $quarterlyInvoicesPerOffice[$key]['flag'] = 'red';
                }else {
                    $quarterlyInvoicesPerOffice[$key]['flag'] = 'green';
                }
                
            }

            return [
                'months' => $months,
                'invoices' => $quarterlyInvoicesPerOffice
            ];
            
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function getLastThreeYearsInvoices()
    {
        try {
            $data = [];
            // Get the last 3 years
            $years = [];

            for ($i=0; $i < 3; $i++) { 
                array_push($years, date("Y",strtotime(" -" .$i." year")));
            }

            // Get all the months
            $months = [];

            for ($m=1; $m<=12; $m++) {
                array_push($months, [
                    'id' => $m,
                    'name' => date('F', mktime(0,0,0,$m, 1, date('Y')))
                ]);
            }

            foreach ($months as $mk => $month) {

                foreach ($years as $yk => $year) {
                    $data[$mk][$yk]['invoice'] = $this->getInvoicesPerMonthInYear($month['id'], $year);
                    $data[$mk][$yk]['month'] = $month['name'];
                }
            }

            $yearsCount = [];
            $avgYCount=  [];
            foreach ($years as $year) {
                array_push($avgYCount, ceil($this->getTotalInvicePerYear($year)/12));
                array_push($yearsCount, $this->getTotalInvicePerYear($year));
            }
           
            foreach ($data as $key => $year) {

                $index1 = $data[$key][0]['invoice'];
                $index2 = $data[$key][1]['invoice'];
                $index3 = $data[$key][2]['invoice'];

                $firstCheck = $index1 >= $avgYCount[0];
                $secCheck = $index2 >= $avgYCount[1];
                $thirdCheck = $index3 >= $avgYCount[2];
                
                if($firstCheck && $secCheck && $thirdCheck){
                    $data[$key]['flag'] = 'green';
                }else {
                    $data[$key]['flag'] = 'red';
                }
                
            }

            $trendMonths = [];

            foreach ($data as $key => $month) {
                if($month['flag'] == 'green'){
                    array_push($trendMonths, $data[$key][0]['month']);
                }
            }

            return [
                'data' => $data,
                'years' => $years,
                'yearsCount' => $yearsCount,
                'trendMonths' => $trendMonths
            ];

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }

    public function getInvoicesPerMonthInYear($month, $year)
    {
        $invoiceIds = Invoice::select('Id')
                            ->WhereRaw('MONTH(Time) = ' . $month . ' AND YEAR(Time) = ' . $year)
                            ->pluck('Id')->toArray();

        $invoices = InvoiceDetail::whereIn('InvoiceId', $invoiceIds)->count();

        return $invoices;
    }

    public function getTotalInvicePerYear($year)
    {
        $number_of_invoiceIds = Invoice::select('Id')
                ->WhereRaw('YEAR(Time) = ' . $year)
                ->pluck('Id')->toArray();

        $number_of_invoice = InvoiceDetail::whereIn('InvoiceId', $number_of_invoiceIds)->count();
        return $number_of_invoice;
    }

    public function getProccTimeForOfficePerMonth($officeId, $month)
    {
        try {
            $office = new Office();
            $userIds = $office->getUserIds($officeId);
            $year = now()->year;

            $proccTime = Invoice::selectRaw('AVG(ProcessingTime) as process_time')->whereRaw(
                'MONTH(Time) = ' . $month)
            ->whereIn('UserId', $userIds)->pluck('process_time')->toArray()[0];

            // Start get Service with high proc time
            $now = now()->startOfMonth();
            $quarterAhead = now()->addMonths(-3)->firstOfMonth();
            
            $invoiceIds = Invoice::select('Id')->WhereRaw('YEAR(Time) = ' . $year)
            ->whereDate('Time','>=', $quarterAhead)->whereDate('Time', '<=', $now)
            ->whereIn('UserId', $userIds)->pluck('Id')->toArray();
            
            $serviceIds = InvoiceDetail::selectRaw('ServiceId as service, COUNT(ServiceId) as scount')->whereIn('InvoiceId', $invoiceIds)
                ->groupBy('ServiceId')->get()->toArray();

            $servicesIDS = [];
            
            if(count($serviceIds)){
                foreach ($serviceIds as $s_id) {
                    array_push($servicesIDS, $s_id['scount']);
                }

                $maxServiceIndex = array_search(max($servicesIDS), $servicesIDS);
                $topServiceArray = $serviceIds[$maxServiceIndex];
                $highService = Service::select('Name')->Where('Id', $topServiceArray['service'])->pluck('Name')->toArray()[0];
            }else {
                $highService = '';
            }
        

            // End get Service with high proc time
            
            return [
                    'process_time' => $proccTime == null ? 0 : $proccTime, 
                    'topService' => $highService == '' ? '-' : $highService];
            
        } catch (\Exception $ex) {
            return response()->json(['result' => 'error', 'message' => $ex->getMessage()], 200);
        }
        
    }

    public function getOfficesReport()
    {
        try {
            
            $officesDetails = [];

            $offices = Office::select('Id', 'Name', 'Latitude', 'Longitude')->get();

            foreach ($offices as $key => $office) {
                $userIds = $office->getUserIds($office->Id);
                $officeEmployees = Employee::where('OfficeId', $office->Id)->count();
                $totalFees = Invoice::selectRaw('SUM(TotalFees) as total_fees')->whereIn('UserId', $userIds)
                    ->orderBy('total_fees')
                    ->pluck('total_fees')
                    ->toArray()[0];
                
                $officeInvoices = Invoice::selectRaw('Id, TotalFees')->whereIn('UserId', $userIds)
                    ->pluck('Id')->toArray();

                $serviceCount = InvoiceDetail::whereIn('InvoiceId', $officeInvoices)->count();

                $officesDetails[$key]['office_name'] = $office->Name;
                $officesDetails[$key]['total_fees'] = $totalFees == null ? 0 : $totalFees;
                $officesDetails[$key]['n_invoices'] = count($officeInvoices);
                $officesDetails[$key]['n_serviceCount'] = $serviceCount;
                $officesDetails[$key]['n_employees'] = $officeEmployees;
                $officesDetails[$key]['lat'] = $office->Latitude;
                $officesDetails[$key]['long'] = $office->Longitude;
            }

            $totalFees = array();
            foreach ($officesDetails as $key => $row)
            {
                $totalFees[$key] = $row['total_fees'];
            }
            array_multisort($totalFees, SORT_DESC, $officesDetails);

            $countOfTotalFees = 0;
            foreach ($officesDetails as $office) {
                $countOfTotalFees += $office['total_fees'];
            }

            $countOfInvoices = 0;
            foreach ($officesDetails as $office) {
                $countOfInvoices += $office['n_invoices'];
            }

            $countInvoiceServices = 0;
            foreach ($officesDetails as $office) {
                $countInvoiceServices += $office['n_serviceCount'];
            }

            $total = (object)[
                'totalFees' => $countOfTotalFees,
                'totalInvoices' => $countOfInvoices,
                'totalInvoiceDatails' => $countInvoiceServices
            ];
            
            return [
                'invoices' => $officesDetails,
                'offices' => $offices,
                'total' => $total
            ];
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }
}
