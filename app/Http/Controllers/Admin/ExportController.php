<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExcelExports\CategoryServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\ServiceCategory;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportInvoicesByServiceCategory(Request $request)
    {
        $date = explode(' - ', $request->daterange);
        $from = $date[0];
        $to = $date[1];

        $category = ServiceCategory::findOrFail($request->category_id);
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

            return Excel::download(new CategoryServices($invoiceDetailed, $total), 'invoicesPerCategory.xlsx');
            
            // return view('admin.exports.print.categoryServices')->withInvoices($invoiceDetailed)->withCategories($categories)->withTotal($total)->withCategory($category)->withDaterange($daterange);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }    
    }
}
