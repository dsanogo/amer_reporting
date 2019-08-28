<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\InvoiceDetail;
use App\Models\Invoice;
use App\Models\Office;
use App\Models\MobileRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\User;
use App\Models\Employee;
use App\Models\OfficeService;

class InvoiceController extends Controller
{
    /**
    * Get all the invoices for the Category Services.
    *
    */
    public function getInvoicesByServiceCategory(Request $request)
    {
        $date = explode(' - ', $request->daterange);
        $from = $date[0];
        $to = $date[1];

        $category = ServiceCategory::findOrFail($request->category_id);
        $categories = ServiceCategory::select('Id', 'Name')->get();
        $sumOfTotalFees = 0;
        $sumOfInvoices = 0;
        try {
            $invoiceDetailed = [];
        
            // Get all the services for this category
            $categoryServices = $category->services;

            foreach ($categoryServices as $service) {
                $serviceTotalFees = 0;
                //Get the service Invoice
                $serviceInvoiceDetails = InvoiceDetail::select('ServiceId', 'InvoiceId')->where('ServiceId', $service->Id)->get();

                // Get Total Fees for the service
                foreach ($serviceInvoiceDetails as $serviceDetail) {
                    $serviceInvoice = Invoice::select('TotalFees')->whereDate('Time','>=', $from)->whereDate('Time', '<=', $to)->where('Id', $serviceDetail->InvoiceId)->first();
                    
                    if($serviceInvoice){
                        $serviceTotalFees += $serviceInvoice->TotalFees;
                        $sumOfTotalFees += $serviceInvoice->TotalFees;
                        $serviceName = 'service' . $service->Id;
                        $sumOfInvoices += 1;
                        
                        $invoiceDetailed['services'][$serviceName] = $service;
                        $invoiceDetailed['services'][$serviceName]['invoiceCount'] = count($serviceInvoiceDetails);
                        $invoiceDetailed['services'][$serviceName]['invoicetotalFees'] = $serviceTotalFees;
                    }                    
                }
            }

            $invoiceDetailed['services'] = $category->services;
            $total = (object)[
                'totalFees' => $sumOfTotalFees,
                'totalInvoices' => $sumOfInvoices
            ];
            
            return view('admin.invoicesReport.categoryServices')->withInvoices($invoiceDetailed)->withCategories($categories)->withTotal($total);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    /**
    * Get all the invoices for the Category Services.
    *
    */
    public function getInvoicesForOffices()
    {
        try {
            $invoiceDetailed = [];
            $offices = $offices = Office::select('Id', 'Name')->get();
            $invoices = Invoice::select('TotalFees', 'MobileRequestId')->get();
            $sumOfTotalFees = 0;
            $sumOfInvoices = 0;
            
            
            foreach ($offices as $office) {
                $officeTotalFees = 0;
                $invoiceCount = 0;

                foreach ($invoices as $invoice) {
                    
                    // Get the office Id of the Invoice
                    $officeId = MobileRequest::select('OfficeId')->where('Id', $invoice->MobileRequestId)->first();

                    if($officeId){
                        $officeName = 'office' . $office->Id;

                        if($office->Id == $officeId->OfficeId){
                            $officeTotalFees += $invoice->TotalFees;
                            $invoiceCount += 1;
                            $sumOfTotalFees += $invoice->TotalFees;
                            $sumOfInvoices += 1;
                        }                
                        
                        $invoiceDetailed[$officeName] = (object)[
                            'office' => $office->Name,
                            'totalFees' => $officeTotalFees,
                            'count' => $invoiceCount
                        ];
                    }
                    
                }

            }

            $total = (object)[
                'totalFees' => $sumOfTotalFees,
                'totalInvoices' => $sumOfInvoices
            ];
            

            
            return view('admin.invoicesReport.offices')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total);
            // return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    /**
    * Get all the invoices done from Mobile and those from Offices.
    *
    */
    public function getInvoicesByMobileRequestByOffice()
    {
        try {
            $invoiceDetailed = [];
            $offices = $offices = Office::select('Id', 'Name')->get();
            $invoices = Invoice::select('TotalFees', 'MobileRequestId', 'Origin')->get();
            $sumOfInvoices = 0;
            $sumMobileInvoices = 0;
            $sumOfficeInvoices = 0;
            
            foreach ($offices as $office) {
                $mobileInvoices = 0;
                $officeInvoices = 0;

                foreach ($invoices as $invoice) {
                    
                    // Get the office Id of the Invoice
                    $officeId = MobileRequest::select('OfficeId')->where('Id', $invoice->MobileRequestId)->first();

                    if($officeId){
                        $officeName = 'office' . $office->Id;

                        if($office->Id == $officeId->OfficeId && $invoice->Origin == 1){
                            $sumOfInvoices += 1;
                            $sumOfficeInvoices += 1;
                            $officeInvoices += 1;
                        }else if($office->Id == $officeId->OfficeId && $invoice->Origin == 2){
                            $sumOfInvoices += 1;
                            $sumMobileInvoices += 1;
                            $mobileInvoices += 1;
                        }         
                        
                        $invoiceDetailed[$officeName] = (object)[
                            'office' => $office->Name,
                            'mobileInvoices' => $mobileInvoices,
                            'officeInvoices' => $officeInvoices
                        ];
                    }
                }
            }

            $total = (object)[
                'totalInvoices' => $sumOfInvoices,
                'sumMobileInvoices' => $sumMobileInvoices,
                'sumOfficeInvoices' => $sumOfficeInvoices
            ];
            
            return view('admin.invoicesReport.mobileAndOffice')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total);
            // return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
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

    public function getQuarterInvoicesByMobileRequestByOffice()
    {
        try {

            $now = now()->startOfMonth();
            $quarterAhead = now()->addMonths(-3)->firstOfMonth();

            $invoiceDetailed = [];
            $offices = $offices = Office::select('Id', 'Name')->get();
            $invoices = Invoice::select('TotalFees', 'MobileRequestId', 'Origin', 'UserId')->whereDate('Time', '>=', $quarterAhead)->whereDate('Time', '<', $now)->get();
            $sumOfInvoices = 0;
            $sumMobileInvoices = 0;
            $sumOfficeInvoices = 0;
            $mobileServicesArray = [];
            $officeServicesArray = [];

            foreach ($offices as $office) {
                $mobileInvoices = 0;
                $officeInvoices = 0;
                
                foreach ($invoices as $invoice) {
                    
                    // Get the office Id of the Invoice
                    $officeId = MobileRequest::select('OfficeId', 'ServiceId')->where('Id', $invoice->MobileRequestId)->first();

                    if($officeId == null) {
                        $user = User::select('EmployeeId')->findOrFail($invoice->UserId);
                        $emp = Employee::select('OfficeId')->findOrFail($user->EmployeeId);
                        $officeId = OfficeService::select('OfficeId', 'ServiceId')->where('OfficeId', $emp->OfficeId)->first();
                    }

                    
                    if($officeId){
                        $officeName = 'office' . $office->Id;

                        if($office->Id == $officeId->OfficeId && $invoice->Origin == 1){
                            array_push($officeServicesArray, $officeId->ServiceId);
                            $sumOfInvoices += 1;
                            $sumOfficeInvoices += 1;
                            $officeInvoices += 1;
                        }else if($office->Id == $officeId->OfficeId && $invoice->Origin == 2){
                            array_push($mobileServicesArray, $officeId->ServiceId);
                            $sumOfInvoices += 1;
                            $sumMobileInvoices += 1;
                            $mobileInvoices += 1;
                        }         
                        
                        $invoiceDetailed[$officeName] = (object)[
                            'office' => $office->Name,
                            'mobileInvoices' => $mobileInvoices,
                            'officeInvoices' => $officeInvoices
                        ];
                    }
                }
            }

            
            // Get array count of mobileServiceArray and officeServiceArray
            $countMobileServices = array_count_values($mobileServicesArray);
            $countOfficeeServices = array_count_values($officeServicesArray);

            // Get the Id with max count of both arrays
            if(count($countMobileServices)){
                $topMobileServiceId = array_search(max($countMobileServices), $countMobileServices);
            }else {
                $topMobileServiceId = '';
            }
            
            if(count($countOfficeeServices)){
                $topOfficeServiceId = array_search(max($countOfficeeServices), $countOfficeeServices);
            }else {
                $topOfficeServiceId = '';
            }

            // Get the name of the top services
            if($topMobileServiceId !== ''){
                $topMobileServiceName = Service::select('Name')->where('Id', $topMobileServiceId)->first()->Name;
            }else {
                $topMobileServiceName = '';
            }

            if($topOfficeServiceId !== ''){
                $topOfficeServiceName = Service::select('Name')->where('Id', $topOfficeServiceId)->first()->Name;
            }else {
                $topOfficeServiceName = '';
            }
            

            $topServices = (object) [
                'fromMobile' => $topMobileServiceName,
                'fromOffice' => $topOfficeServiceName
            ];

            $total = (object)[
                'totalInvoices' => $sumOfInvoices,
                'sumMobileInvoices' => $sumMobileInvoices,
                'sumOfficeInvoices' => $sumOfficeInvoices
            ];
            
            return view('admin.invoicesReport.quarterlyMobileAndOffice')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total)->withTopServices($topServices);
            // return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function getInvoiceMonthly()
    {
        try {
            $monthlyInvoices = DB::table('Invoices')->select(DB::raw('COUNT(Id) as total_invoices'),DB::raw("MONTH(Time) as m"), DB::raw("DATENAME(mm, Time) as month"), DB::raw('YEAR(Time) as year'))
                                    ->groupBy(DB::raw('MONTH(Time)'), DB::raw("DATENAME(mm, Time)"),DB::raw('YEAR(Time)'))->get();
            $totalInvoices = Invoice::count();

            return view('admin.invoicesReport.invoicesPerMonth')->withInvoices($monthlyInvoices)->withTotalInvoices($totalInvoices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function getInvoiceMonthlyProcessTime(Request $request)
    {
        try {
            
            if(isset($request->office_id)){
                $mobileRequestId = $this->getMobileRequestIdsFromInvoices($request->office_id);
            }else {
                $mobileRequestId = '';
            }

            $offices = Office::select('Id', 'Name')->get();
            $monthlyInvoices = DB::table('Invoices')->select(
                DB::raw('COUNT(Id) as total_invoices'),
                DB::raw("MONTH(Time) as m"), 
                DB::raw("DATENAME(mm, Time) as month"),
                DB::raw("SUM(ProcessingTime) as total_process_time"),
                DB::raw('AVG(ProcessingTime) as process_time'), 
                DB::raw('YEAR(Time) as year'))
                ->where(function($query) use ($mobileRequestId) {
                    if($mobileRequestId !== ''){
                        $query->whereIn('MobileRequestId', $mobileRequestId);
                    }
                })
                ->groupBy(DB::raw('MONTH(Time)'), 
                            DB::raw("DATENAME(mm, Time)"),
                            DB::raw('YEAR(Time)'))->get();

            return view('admin.invoicesReport.invoicesPerMonthlyProcessTime')->withInvoices($monthlyInvoices)->withOffices($offices);
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

            $now = now()->startOfMonth();
            $quarterAhead = now()->addMonths(-3)->firstOfMonth();

            $invoiceDetailed = [];
            $offices = $offices = Office::select('Id', 'Name')->get();

            // $invoices = DB::select("SELECT MobileRequestId, 
            //                                 COUNT(Id) as total_invoices, 
            //                                 MONTH(Time) as m, 
            //                                 DATENAME(mm, Time) as month, 
            //                                 SUM(ProcessingTime) as total_process_time,
            //                                 AVG(ProcessingTime) as avg_process_time,
            //                                 YEAR(Time) as year
            //                         FROM Invoices
            //                         WHERE 'Time' >= " .$quarterAhead . " AND Time <= ".$now."
            //                         GROUP BY MONTH(Time), YEAR(Time)
            //                         ");

            // return $invoices;
            $invoices = Invoice::selectRaw('
                COUNT(Id) as total_invoices,
                MONTH(Time) as m, 
                DATENAME(mm, Time) as month,
                SUM(ProcessingTime) as total_process_time,
                AVG(ProcessingTime) as process_time,
                YEAR(Time) as year')
                ->whereDate('Time', '>=', $quarterAhead)->whereDate('Time', '<', $now)
                ->groupBy(DB::raw('MONTH(Time)'), 
                            DB::raw("DATENAME(mm, Time)"),
                            DB::raw('YEAR(Time)'))->get();

            return $invoices;
            $officesArray = [];

            foreach ($offices as $office) {
                $mobileInvoices = 0;
                $officeInvoices = 0;
                
                foreach ($invoices as $invoice) {
                    
                    // Get the office Id of the Invoice
                    $officeId = MobileRequest::select('OfficeId')->where('Id', $invoice->MobileRequestId)->first();

                    dd($officeId);

                    if($officeId == null) {
                        $user = User::select('EmployeeId')->findOrFail($invoice->UserId);
                        $emp = Employee::select('OfficeId')->findOrFail($user->EmployeeId);
                        $officeId = OfficeService::select('OfficeId', 'ServiceId')->where('OfficeId', $emp->OfficeId)->first();
                    }

                    
                    if($officeId){
                        $officeName = 'office' . $office->Id;

                        if($office->Id == $officeId->OfficeId && $invoice->Origin == 1){
                            
                        }     
                        
                        $invoiceDetailed[$officeName] = (object)[
                            'office' => $office->Name,
                            'mobileInvoices' => $mobileInvoices,
                            'officeInvoices' => $officeInvoices
                        ];
                    }
                }
            }

            
            // Get array count of mobileServiceArray and officeServiceArray
            $countMobileServices = array_count_values($mobileServicesArray);
            $countOfficeeServices = array_count_values($officeServicesArray);

            // Get the Id with max count of both arrays
            if(count($countMobileServices)){
                $topMobileServiceId = array_search(max($countMobileServices), $countMobileServices);
            }else {
                $topMobileServiceId = '';
            }
            
            if(count($countOfficeeServices)){
                $topOfficeServiceId = array_search(max($countOfficeeServices), $countOfficeeServices);
            }else {
                $topOfficeServiceId = '';
            }

            // Get the name of the top services
            if($topMobileServiceId !== ''){
                $topMobileServiceName = Service::select('Name')->where('Id', $topMobileServiceId)->first()->Name;
            }else {
                $topMobileServiceName = '';
            }

            if($topOfficeServiceId !== ''){
                $topOfficeServiceName = Service::select('Name')->where('Id', $topOfficeServiceId)->first()->Name;
            }else {
                $topOfficeServiceName = '';
            }
            

            $topServices = (object) [
                'fromMobile' => $topMobileServiceName,
                'fromOffice' => $topOfficeServiceName
            ];

            $total = (object)[
                'totalInvoices' => $sumOfInvoices,
                'sumMobileInvoices' => $sumMobileInvoices,
                'sumOfficeInvoices' => $sumOfficeInvoices
            ];
            
            return view('admin.invoicesReport.quarterlyMobileAndOffice')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total)->withTopServices($topServices);
            // return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function getLastThreeYearsInvoices()
    {
        try {
            $now = now()->startOfMonth();
            $lastThreeYears = now()->addYear(-2)->firstOfYear();

            $invoices = Invoice::selectRaw('
                    count(Id) as total_invoices, MONTH(Time) as mth, DATENAME(mm, Time) as month, YEAR(Time) as year
                ')->whereDate('Time', '>=', $lastThreeYears)->whereDate('Time', '<', $now)
                ->groupBy(DB::raw('MONTH(Time)'), DB::raw('YEAR(Time)'), DB::raw('DATENAME(mm, Time)'))
                ->get();

            $years  = [];

            foreach ($invoices as $key => $invoice) {

                if(!in_array($invoice->year, $years)){
                    array_push($years, $invoice->year);
                }
            }

            return view('admin.invoicesReport.lastThreeYearsInvoices')->withYears($years)->withInvoices($invoices);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }
}
