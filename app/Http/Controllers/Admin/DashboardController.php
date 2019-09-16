<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\ServiceCategory;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\DB;
use App\Models\Office;
use App\Models\MobileRequest;
use App\Models\SurveySubject;

class DashboardController extends Controller
{
    public $officeModel;
    public $invoiceModel;

    public function __construct(Office $officeModel, Invoice $invoiceModel) {
        $this->officeModel = $officeModel;
        $this->invoiceModel = $invoiceModel;
    }
    /**
    * Display the Admin Welcome page.
    *
    */

    public function index()
    {
        $data = [];
        $data['employees'] = Employee::count();
        $data['numberOfInvoices'] = InvoiceDetail::count();
        $data['totalFees'] = DB::table('Invoices')->sum('TotalFees');
        $data['offices'] = Office::with('employees')->get();

        $officesDetails = $this->invoiceModel->getOfficesReport();
        
        $report = $this->officeModel->getOfficesWithAverage();
        
        $invoiceDetailed = $officesDetails['invoices'];
        $topOffices = $report['topOffices'];
        $topOffices = array_reverse($topOffices);

        return view('admin.index')->withData($data)->withInvoices($invoiceDetailed)->withTopOffices($topOffices);
    }

    public function showInvoicesByCategory()
    {
        $categories = ServiceCategory::select('Id', 'Name')->get();
        return view('admin.invoicesReport.categoryServices')->withCategories($categories);
    }

    public function showInvoicesByOffices()
    {
        $categories = ServiceCategory::select('Id', 'Name')->get();
        return view('admin.invoicesReport.categoryServices')->withCategories($categories);
    }

    public function showInvoicesByMobileAndOffices()
    {
        $categories = ServiceCategory::select('Id', 'Name')->get();
        return view('admin.invoicesReport.categoryServices')->withCategories($categories);
    }

    public function showSurveys()
    {
        $surveySubjects = SurveySubject::all();
        return view('admin.surveys.index')->withSurveySubjects($surveySubjects);
    }

    public function showOfficesDetails()
    {
        $districts = $this->allDistricts();
        return view('admin.offices.detailedOffices')->withDistricts($districts);
    }

    public function showInvoicesByDistrict()
    {
        $districts = $this->allDistricts();

        return view('admin.invoicesReport.offices')->withDistricts($districts);
    }

    public function showMobileAndOfficesInvices()
    {
        $districts = $this->allDistricts();
        return view('admin.invoicesReport.mobileAndOffice')->withDistricts($districts);
    }

    public function showInvoiceMonthly()
    {
        return view('admin.invoicesReport.invoicesPerMonth');
    }

    public function showOfficesDetailsWithAverage()
    {
        $districts = $this->allDistricts();
        return view('admin.offices.detailedOfficesWithAvgProcTime')->withDistricts($districts);
    }

    public function showInvoiceMonthlyProcessTime()
    {
        $districts = $this->allDistricts();
        return view('admin.invoicesReport.invoicesPerMonthlyProcessTime')->withDistricts($districts);
    }

    public function allDistricts()
    {
        return District::all();
    }
}
