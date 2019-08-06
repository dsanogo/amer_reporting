<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\InvoiceDetail;
use App\Models\Invoice;
use App\Models\Office;
use App\Models\MobileRequest;

class InvoiceController extends Controller
{
    /**
    * Get all the invoices for the Category Services.
    *
    */
    public function getInvoicesByServiceCategory(ServiceCategory $category, Request $request)
    {
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

                    $serviceName = 'service' . $service->Id;
                    
                    $invoiceDetailed['services'][$serviceName] = $service;
                    $invoiceDetailed['services'][$serviceName]['invoice' . $service->Id . 'Count'] = count($serviceInvoiceDetails);
                    $invoiceDetailed['services'][$serviceName]['invoice' . $service->Id . 'totalFees'] = $serviceTotalFees;
                }
            }
            $invoiceDetailed['services'] = $category->services;
            
            return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    /**
    * Get all the invoices for the Category Services.
    *
    */
    public function getInvoicesByOffice(Request $request)
    {
        try {
            $offices = $offices = Office::select('Id', 'Name')->get();
            $invoices = Invoice::select('TotalFees', 'MobileRequestId')->get();

            foreach ($offices as $office) {
                $mobileTotalFees = 0;
                $invoiceCount = 0;
                foreach ($invoices as $invoice) {
                    
                    // Get the office Id of the Invoice
                    $officeId = MobileRequest::select('OfficeId')->where('Id', $invoice->MobileRequestId)->first();
                    $officeName = 'office' . $office->Id;

                    
                    if($office->Id == $officeId->OfficeId){
                        $mobileTotalFees += $invoice->TotalFees;
                        $invoiceCount += 1;
                    }                
                    $invoiceDetailed[$officeName]['invoice' . $office->Id . 'totalFees'] = $mobileTotalFees;
                    $invoiceDetailed[$officeName]['invoice' . $office->Id . 'count'] = $invoiceCount;
                }
            }
            
            return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
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
                    $officeName = 'office' . $office->Id;

                    
                    if($office->Id == $officeId->OfficeId){
                        $mobileTotalFees += $mobileInvoice->TotalFees;
                        $invoiceCount += 1;
                    }                
                    $invoiceDetailed['mobile'][$officeName]['invoice' . $office->Id . 'totalFees'] = $mobileTotalFees;
                    $invoiceDetailed['mobile'][$officeName]['invoice' . $office->Id . 'count'] = $invoiceCount;
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

                    
                    if($office->Id == $officeId->OfficeId){
                        $mobileTotalFees += $officeInvoice->TotalFees;
                        $invoiceCount += 1;
                    }                
                    $invoiceDetailed['office'][$officeName]['invoice' . $office->Id . 'totalFees'] = $mobileTotalFees;
                    $invoiceDetailed['office'][$officeName]['invoice' . $office->Id . 'count'] = $invoiceCount;
                }
            }        
            return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }
}
