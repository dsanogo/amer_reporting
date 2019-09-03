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
use DateTime;

class InvoiceController extends Controller
{
    public $invoiceModel;
    public function __construct(Invoice $invoice) {
        $this->invoiceModel = $invoice;
    }
    
    /**
    * Get all the invoices for the Category Services.
    *
    */
    public function getInvoicesByServiceCategory(Request $request)
    {
       try {
            $data = $this->invoiceModel->getInvoicesByServiceCategory($request);

            $invoiceDetailed = $data['invoices'];
            $categories = $data['categories'];
            $total = $data['total'];
            
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
            
            $data = $this->invoiceModel->getInvoicesForOffices();
            $invoiceDetailed = $data['invoices'];
            $offices = $data['offices'];
            $total = $data['total'];
            
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
            $data = $this->invoiceModel->getInvoicesByMobileRequestByOffice();
            $invoiceDetailed = $data['invoices'];
            $offices = $data['offices'];
            $total = $data['total'];
            
            return view('admin.invoicesReport.mobileAndOffice')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total);
            // return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function getInvoicesPerMonth()
    {
        try {
            $data = $this->invoiceModel->getInvoicesPerMonth();
            return $data;
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function getQuarterInvoicesByMobileRequestByOffice()
    {
        try {

            $data = $this->invoiceModel->getQuarterInvoicesByMobileRequestByOffice();
            
            $invoiceDetailed= $data['invoices'];
            $offices= $data['offices'];
            $total= $data['total'];
            $topServices= $data['topServices'];
            
            return view('admin.invoicesReport.quarterlyMobileAndOffice')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total)->withTopServices($topServices);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function printQuarterInvoicesByMobileRequestByOffice()
    {
        try {

           $data = $this->invoiceModel->getQuarterInvoicesByMobileRequestByOffice();
           $invoiceDetailed= $data['invoices'];
           $offices= $data['offices'];
           $total= $data['total'];
           $topServices= $data['topServices'];
           
            return view('admin.exports.print.quarterlyMobileAndOffice')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total)->withTopServices($topServices);
            // return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }
    
    public function getInvoiceMonthly()
    {
        try {
           
            $data = $this->invoiceModel->getInvoiceMonthly();
            $monthlyInvoices = $data['monthlyInvoices'];
            $totalInvoices = $data['totalInvoices'];

            return view('admin.invoicesReport.invoicesPerMonth')->withInvoices($monthlyInvoices)->withTotalInvoices($totalInvoices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function getInvoiceMonthlyProcessTime(Request $request)
    {
        try {
            $data = $this->invoiceModel->getInvoiceMonthlyProcessTime($request);
            $monthlyInvoices = $data['monthlyInvoices'];
            $offices = $data['offices'];

            return view('admin.invoicesReport.invoicesPerMonthlyProcessTime')->withInvoices($monthlyInvoices)->withOffices($offices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function printInvoiceMonthlyProcessTime(Request $request)
    {
        try {
            $data = $this->invoiceModel->getInvoiceMonthlyProcessTime($request);
            $monthlyInvoices = $data['monthlyInvoices'];
            $offices = $data['offices'];

            return view('admin.exports.print.invoicesPerMonthlyProcessTime')->withInvoices($monthlyInvoices)->withOffices($offices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }


    public function getInvoiceQuarterlyProcessTime()
    {
        try {
            $data = $this->invoiceModel->getInvoiceQuarterlyProcessTime();
            
            // Not done yet
            return $data;
            $invoiceDetailed = $data['invoices'];
            $offices = $data['offices'];
            $total = $data['total'];
            $topServices = $data['topServices'];

            return view('admin.invoicesReport.quarterlyMobileAndOffice')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total)->withTopServices($topServices);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function getLastThreeYearsInvoices()
    {
        try {
            $report = $this->invoiceModel->getLastThreeYearsInvoices();
            $data = $report['data'];
            $years = $report['years'];
            $yearsCount = $report['yearsCount'];
            return view('admin.invoicesReport.lastThreeYearsInvoices')->withData($data)->withYears($years)->withYearsCount($yearsCount);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }

    public function printLastThreeYearsInvoices()
    {
        try {
            
            $report = $this->invoiceModel->getLastThreeYearsInvoices();
            $data = $report['data'];
            $years = $report['years'];
            $yearsCount = $report['yearsCount'];
            
            return view('admin.exports.print.lastThreeYearsInvoices')->withData($data)->withYears($years)->withYearsCount($yearsCount);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }
     

    public function printInvoicesByServiceCategory(Request $request)
    {
        try{
            $data = $this->invoiceModel->getInvoicesByServiceCategory($request);
            
            $invoiceDetailed = $data['invoices'];
            $total = $data['total'];

            return view('admin.exports.print.categoryServices')->withInvoices($invoiceDetailed)->withTotal($total);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function printInvoicesForOffices()
    {
        try {
            $data = $this->invoiceModel->getInvoicesForOffices();
            $invoiceDetailed = $data['invoices'];
            $offices = $data['offices'];
            $total = $data['total'];
            
            return view('admin.exports.print.offices')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total);
            // return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function printInvoicesByMobileRequestByOffice()
    {
        try {
            $data = $this->invoiceModel->getInvoicesByMobileRequestByOffice();
            $invoiceDetailed = $data['invoices'];
            $offices = $data['offices'];
            $total = $data['total'];
            
            return view('admin.exports.print.mobileAndOffice')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function printInvoiceMonthly()
    {
        try {
            $data = $this->invoiceModel->getInvoiceMonthly();
            $monthlyInvoices = $data['monthlyInvoices'];
            $totalInvoices = $data['totalInvoices'];
            
            return view('admin.exports.print.invoicesPerMonth')->withInvoices($monthlyInvoices)->withTotalInvoices($totalInvoices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }
}
