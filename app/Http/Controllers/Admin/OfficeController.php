<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Invoice;
use App\Models\MobileRequest;
use App\Models\Employee;

class OfficeController extends Controller
{
    public function getOffices()
    {
        try {
            $offices = Office::select('Id', 'Name')->get();
            return response()->json(['status' => 'success', 'data' => $offices], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function getOfficesDetails()
    {
        $data['offices'] = Office::with('employees')->get();

        $invoiceDetailed = [];
            $offices = $offices = Office::select('Id', 'Name')->get();
            $invoices = Invoice::select('TotalFees', 'MobileRequestId')->get();
            $sumOfInvoices = 0;
            
            foreach ($offices as $key => $office) {
                $invoiceCount = 0;

                foreach ($invoices as $invoice) {
                    
                    // Get the office Id of the Invoice
                    $officeId = MobileRequest::select('OfficeId')->where('Id', $invoice->MobileRequestId)->first();

                    if($officeId){

                        if($office->Id == $officeId->OfficeId){
                            $invoiceCount += 1;
                            $sumOfInvoices += 1;
                        }                
                        
                        $invoiceDetailed[$key] = (object)[
                            'office' => $office->Name,
                            'count' => $invoiceCount
                        ];
                    }
                    
                }

            }
            
            $total = (object)[
                'totalInvoices' => $sumOfInvoices,
                'totalEmp' => Employee::count()
            ];

            return view('admin.offices.detailedOffices')->withData($data)->withInvoices($invoiceDetailed)->withTotal($total);

    }
}
