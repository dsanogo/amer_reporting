<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    /**
    * The table associated with the model.
    *
    */
    protected $table = 'Offices';

    public function employees()
    {
        return $this->hasMany('App\Models\Employee', 'OfficeId', 'Id');
    }

    public function getUserIds($officeId)
    {
        $employees = Employee::where('OfficeId', $officeId)->pluck('Id')->toArray();

        $userIds = User::whereIn('EmployeeId', $employees)->pluck('Id')->toArray();

        return $userIds;
    }

    public function getOfficesDetails($request)
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
            $offices = $offices = Office::select('Id', 'Name')->where('DistrictId', $district->Id)->get();
            
            foreach ($offices as $key => $office) {
                $userIds = $office->getUserIds($office->Id);
                $officeInvoices = Invoice::select('Id')->whereIn('UserId', $userIds)
                ->where(function($query) use ($from, $to) {
                    if($from !== '' && $to !== '') {
                        $query->whereDate('Time','>=', $from)->whereDate('Time', '<=', $to);
                    }
                })->pluck('Id')->toArray();

                $countOfOfficeInvoices = InvoiceDetail::whereIn('InvoiceId', $officeInvoices)->count();

                $invoiceDetailed[$key]['office_name'] = $office->Name;
                $invoiceDetailed[$key]['nb_employee'] = count($userIds);
                $invoiceDetailed[$key]['nb_invoices'] = $countOfOfficeInvoices;
            }

            $invoices = array();
            foreach ($invoiceDetailed as $key => $row)
            {
                $invoices[$key] = $row['nb_invoices'];
            }
            array_multisort($invoices, SORT_DESC, $invoiceDetailed);

            $sumOfInvoices = 0;
            $empCount = 0;
            foreach ($invoiceDetailed as $key => $office) {
                $sumOfInvoices += $office['nb_invoices'];
            }

            foreach ($invoiceDetailed as $key => $office) {
                $empCount += $office['nb_employee'];
            }

            $topFiveOffices = [];

            foreach ($invoiceDetailed as $key => $office) {
                if(count($topFiveOffices) < 5 ){
                    array_push($topFiveOffices, $office);
                }
            }
    
            $total = (object)[
                'totalInvoices' => $sumOfInvoices,
                'totalEmp' => $empCount
            ];

            return [
                'invoices' => $invoiceDetailed,
                'total' => $total,
                'topOffices' => $topFiveOffices,
                'district' => $district
            ];

            return view('admin.offices.detailedOffices')->withInvoices($invoiceDetailed)->withTotal($total)->withtopOffices($topFiveOffices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function getOfficesDetailsWithAverage($request)
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
                $officeAvgProcTime = Invoice::selectRaw('AVG(ProcessingTime) as proc_time')->whereIn('UserId', $userIds)
                ->where(function($query) use ($from, $to) {
                    if($from !== '' && $to !== '') {
                        $query->whereDate('Time','>=', $from)->whereDate('Time', '<=', $to);
                    }
                })->pluck('proc_time')->toArray()[0];

                $invoiceDetailed[$key]['office'] = $office->Name;
                $invoiceDetailed[$key]['nb_employee'] = count($userIds);
                $invoiceDetailed[$key]['proc_time'] = $officeAvgProcTime == null ? 0 : $officeAvgProcTime;
            }

            $invoices = array();
            foreach ($invoiceDetailed as $key => $row)
            {
                $invoices[$key] = $row['proc_time'];
            }
            array_multisort($invoices, SORT_DESC, $invoiceDetailed);

            $topFiveOffices = [];

            foreach ($invoiceDetailed as $key => $office) {
                if(count($topFiveOffices) < 5 ){
                    array_push($topFiveOffices, $office);
                }
            }

             return [
                    'invoices' => $invoiceDetailed,
                    'topOffices' => $topFiveOffices,
                    'district' => $district
             ];
            
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function getOfficesWithAverage()
    {
        try {
            $invoiceDetailed = [];
            $offices = $offices = Office::select('Id', 'Name')->get();
            
            foreach ($offices as $key => $office) {
                $userIds = $office->getUserIds($office->Id);
                $officeAvgProcTime = Invoice::selectRaw('AVG(ProcessingTime) as proc_time')->whereIn('UserId', $userIds)
                                    ->pluck('proc_time')->toArray()[0];

                $invoiceDetailed[$key]['office'] = $office->Name;
                $invoiceDetailed[$key]['nb_employee'] = count($userIds);
                $invoiceDetailed[$key]['proc_time'] = $officeAvgProcTime == null ? 0 : $officeAvgProcTime;
            }

            $invoices = array();
            foreach ($invoiceDetailed as $key => $row)
            {
                $invoices[$key] = $row['proc_time'];
            }
            array_multisort($invoices, SORT_DESC, $invoiceDetailed);

            $topFiveOffices = [];

            foreach ($invoiceDetailed as $key => $office) {
                if(count($topFiveOffices) < 5 ){
                    array_push($topFiveOffices, $office);
                }
            }

             return [
                    'invoices' => $invoiceDetailed,
                    'topOffices' => $topFiveOffices
             ];
            
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }
}
