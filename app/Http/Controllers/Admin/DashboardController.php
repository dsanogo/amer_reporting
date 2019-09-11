<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    public function __construct(Office $officeModel) {
        $this->officeModel = $officeModel;
    }
    /**
    * Display the Admin Welcome page.
    *
    */

    public function index(Request $request)
    {
        $data = [];
        $data['employees'] = Employee::count();
        $data['numberOfInvoices'] = InvoiceDetail::count();
        $data['totalFees'] = DB::table('Invoices')->sum('TotalFees');
        $data['offices'] = Office::with('employees')->paginate(10);

        $invoiceDetailed = [];
            $offices = Office::select('Id', 'Name')->get();
            $invoices = Invoice::select('TotalFees', 'MobileRequestId')->get();
            $sumOfTotalFees = 0;
            $sumOfInvoices = 0;
            
            
            foreach ($offices as $key => $office) {
                $officeTotalFees = 0;
                $invoiceCount = 0;

                foreach ($invoices as $invoice) {
                    
                    // Get the office Id of the Invoice
                    $officeId = MobileRequest::select('OfficeId')->where('Id', $invoice->MobileRequestId)->first();

                    if($officeId){

                        if($office->Id == $officeId->OfficeId){
                            $officeTotalFees += $invoice->TotalFees;
                            $invoiceCount += 1;
                            $sumOfTotalFees += $invoice->TotalFees;
                            $sumOfInvoices += 1;
                        }                
                        
                        $invoiceDetailed[$key] = (object)[
                            'office' => $office->Name,
                            'totalFees' => $officeTotalFees,
                            'count' => $invoiceCount
                        ];
                    }
                    
                }

            }

            $report = $this->officeModel->getOfficesDetailsWithAverage($request);
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
}
