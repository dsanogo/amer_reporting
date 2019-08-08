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

class InvoiceController extends Controller
{
    /**
    * Get all the invoices for the Category Services.
    *
    */
    public function getInvoicesByServiceCategory(Request $request)
    {
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
                    $serviceInvoice = Invoice::select('TotalFees')->findOrFail($serviceDetail->InvoiceId);
                    $serviceTotalFees += $serviceInvoice->TotalFees;
                    $sumOfTotalFees += $serviceInvoice->TotalFees;
                    $serviceName = 'service' . $service->Id;
                    $sumOfInvoices += 1;
                    
                    $invoiceDetailed['services'][$serviceName] = $service;
                    $invoiceDetailed['services'][$serviceName]['invoiceCount'] = count($serviceInvoiceDetails);
                    $invoiceDetailed['services'][$serviceName]['invoicetotalFees'] = $serviceTotalFees;
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
            $offices = Office::select('Id', 'Name')->get();
            $invoicesFromOffice = Invoice::select('TotalFees', 'MobileRequestId')->where('Origin', 1)->get();
            $invoicesFromMobile = Invoice::select('TotalFees', 'MobileRequestId')->where('Origin', 2)->get();

            /**
            * Get all the invoices done from Mobile
            *
            */
            foreach ($offices as $office) {
                $mobileTotalFees = 0;
                $invoiceCount = 0;
                foreach ($invoicesFromMobile as $mobileInvoice) {
                    
                    // Get the office Id of the Invoice
                    $officeId = MobileRequest::select('OfficeId')->where('Id', $mobileInvoice->MobileRequestId)->first();
                    if($officeId) {
                        $officeName = 'office' . $office->Id;

                    
                        if($office->Id == $officeId->OfficeId){
                            $mobileTotalFees += $mobileInvoice->TotalFees;
                            $invoiceCount += 1;
                        }                
                        $invoiceDetailed['mobile'][$officeName]['totalFees'] = $mobileTotalFees;
                        $invoiceDetailed['mobile'][$officeName]['count'] = $invoiceCount;
                    }
                    
                }
            }

            /**
            * Get all the invoices done from Office
            *
            */
            foreach ($offices as $office) {
                $mobileTotalFees = 0;
                $invoiceCount = 0;
                foreach ($invoicesFromOffice as $officeInvoice) {
                    
                    // Get the office Id of the Invoice

                    $officeId = MobileRequest::select('OfficeId')->where('Id', $officeInvoice->MobileRequestId)->first();
                    $officeName = 'office' . $office->Id;

                    if($officeId) {
                        if($office->Id == $officeId->OfficeId){
                            $mobileTotalFees += $officeInvoice->TotalFees;
                            $invoiceCount += 1;
                        }                
                        $invoiceDetailed['offices'][$officeName]['totalFees'] = $mobileTotalFees;
                        $invoiceDetailed['offices'][$officeName]['count'] = $invoiceCount;
                    }
                }
            }        

            return view('admin.invoicesReport.mobileAndOffice')->withInvoices($invoiceDetailed);
            // return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }


    public function getInvoicesPerMonth()
    {
        $data['totalFeesPerMonth'] = DB::table('Invoices')->select(DB::raw('SUM(TotalFees) as total_fees'), DB::raw('MONTH(Time) as month'))
                                    ->groupBy(DB::raw('MONTH(TIME)'))->get();
        $data['totalInvoicesPerMonth'] = DB::table('Invoices')->select(DB::raw('COUNT(Id) as total_invoices'), DB::raw('MONTH(Time) as month'))
                                    ->groupBy(DB::raw('MONTH(TIME)'))->get();
        $data['maxInvoices'] = DB::table('Invoices')->select(DB::raw('COUNT(Id) as max_invoices'))->first();
        $data['maxFees'] = DB::table('Invoices')->select(DB::raw('MAX(TotalFees) as max_fees'))->first();

        return response()->json($data);
    }
}
