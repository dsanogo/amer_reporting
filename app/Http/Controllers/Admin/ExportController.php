<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExcelExports\CategoryServices;
use App\Exports\ExcelExports\DetailedOffices;
use App\Exports\ExcelExports\DetailedOfficesWithAvgProcTime;
use App\Exports\ExcelExports\InvoicesPerMonth;
use App\Exports\ExcelExports\InvoicesPerMonthlyProcessTime;
use App\Exports\ExcelExports\LastThreeYearsInvoices;
use App\Exports\ExcelExports\MobileAndOffice;
use App\Exports\ExcelExports\Offices;
use App\Exports\ExcelExports\QuarterlyMobileAndOffice;
use App\Exports\ExcelExports\Surveys;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\SendPDF;
use App\Models\Invoice;
use App\Models\Office;
use App\Models\SurveySubject;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ExportController extends Controller
{
    public $invoiceModel;
    public $surveyModel;
    public $officeModel;

    public function __construct(Invoice $invoice, SurveySubject $survey, Office $office) {
        $this->invoiceModel = $invoice;
        $this->surveyModel = $survey;
        $this->officeModel = $office;
    }

    public function exportInvoicesByServiceCategory(Request $request)
    {
        try{
            $data = $this->invoiceModel->getInvoicesByServiceCategory($request);
            $invoiceDetailed = $data['invoices'];
            $total = $data['total'];
            $category = $data['category'];
            $daterange = $data['daterange'];
            return Excel::download(new CategoryServices($invoiceDetailed, $total, $category, $daterange), 'invoicesPerCategory.xlsx');
            
            // return view('admin.exports.print.categoryServices')->withInvoices($invoiceDetailed)->withCategories($categories)->withTotal($total)->withCategory($category)->withDaterange($daterange);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }    
    }

    public function exportInvoicesForOffices(Request $request)
    {
        try {
            $data = $this->invoiceModel->getInvoicesForOffices($request);
            $invoiceDetailed = $data['invoices'];
            $total = $data['total'];
            
            return Excel::download(new Offices($invoiceDetailed, $total), 'officesInvoices.xlsx');
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function exportInvoicesByMobileRequestByOffice(Request $request)
    {
        try {
            $data = $this->invoiceModel->getInvoicesByMobileRequestByOffice($request);
            
            $invoiceDetailed = $data['invoices'];
            $total = $data['total'];

            return Excel::download(new MobileAndOffice($invoiceDetailed, $total), 'mobileAndOfficesInvoices.xlsx');
            // return view('admin.exports.print.mobileAndOffice')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function exportSurveysReport(Request $request)
    {
        try {
            $surveys = $this->surveyModel->getSurveysReport($request)['surveys'];

            return Excel::download(new Surveys($surveys), 'surveys.xlsx');
            // return view('admin.exports.print.surveys')->withSurveys($surveys);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }

    public function exportOfficesDetails(Request $request)
    {
        try {
            $report = $this->officeModel->getOfficesDetails($request);
            $data = $report['data'];
            $invoiceDetailed = $report['invoices'];
            $total = $report['total'];

            return Excel::download(new DetailedOffices($invoiceDetailed, $total, $data), 'detailedOffices.xlsx');
            // return view('admin.exports.print.detailedOffices')->withData($data)->withInvoices($invoiceDetailed)->withTotal($total)->withtopOffices($topOffices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }
    
    public function exportInvoiceMonthly(Request $request)
    {
        try {
            $data = $this->invoiceModel->getInvoiceMonthly($request);
            $monthlyInvoices = $data['monthlyInvoices'];
            $totalInvoices = $data['totalInvoices'];

            return Excel::download(new InvoicesPerMonth((object)$monthlyInvoices, $totalInvoices), 'invoicesPerMonth.xlsx');
            // return view('admin.invoicesReport.invoicesPerMonth')->withInvoices($monthlyInvoices)->withTotalInvoices($totalInvoices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function exportOfficesDetailsWithAverage(Request $request)
    {
        try {
            $report = $this->officeModel->getOfficesDetailsWithAverage($request);
            $data = $report['data'];
            $invoiceDetailed = $report['invoices'];
            
            return Excel::download(new DetailedOfficesWithAvgProcTime($data, $invoiceDetailed), 'detailedOfficesWithAvgProcTime.xlsx');
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function exportInvoiceMonthlyProcessTime(Request $request)
    {
        try {
            
            $data = $this->invoiceModel->getInvoiceMonthlyProcessTime($request);
            $monthlyInvoices = $data['monthlyInvoices'];
            $offices = $data['offices'];

            return Excel::download(new InvoicesPerMonthlyProcessTime($monthlyInvoices, $offices), 'invoicesPerMonthlyProcessTime.xlsx');
            // return view('admin.exports.print.invoicesPerMonthlyProcessTime')->withInvoices($monthlyInvoices)->withOffices($offices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function exportQuarterInvoicesByMobileRequestByOffice()
    {
        try {

            $data = $this->invoiceModel->getQuarterInvoicesByMobileRequestByOffice();
            $invoiceDetailed = $data['invoices'];
            $offices = $data['offices'];
            $total = $data['total'];
            
            return Excel::download(new QuarterlyMobileAndOffice($invoiceDetailed, $offices, $total, $topServices), 'quarterlyMobileAndOffice.xlsx');
            
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function exportLastThreeYearsInvoices()
    {
        try {
            $report = $this->invoiceModel->getLastThreeYearsInvoices();
            $data = $report['data'];
            $years = $report['years'];
            $yearsCount = $report['yearsCount'];

            return Excel::download(new LastThreeYearsInvoices($data, $years, $yearsCount), 'lastThreeYearsInvoices.xlsx');
        

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }

    // PDF GENERATION 

    public function genPdfInvoicesByServiceCategory(Request $request)
    {
        try{
            $data = $this->invoiceModel->getInvoicesByServiceCategory($request);

            $dataToSend = ['invoices' => $data['services'], 
                            'total' => $data['total'],
                            'category' => $data['category'],
                            'daterange' => $data['daterange']
                        ];

            $pdf = Pdf::loadView('admin.exports.print.categoryServices', $dataToSend, [], ['useOTL' => 0xFF, 'format' => 'A4',]);

            if(isset($request->byMail)){
                $userEmail = $request->email; 
                Mail::send(new SendPDF($pdf->output(), $userEmail));
                return redirect()->back()->with('success', 'Email successfully sent with attachment');
            }
            
            return $pdf->stream('invoicesPerCategory.pdf');

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }   
    }

    public function pdfInvoicesForOffices(Request $request)
    {
        try {
            $data = $this->invoiceModel->getInvoicesForOffices($request);
            
            $dataToSend = [
                        'invoices' => $data['invoices'], 
                        'total' => $data['total']
                        ];
            
            $pdf = Pdf::loadView('admin.exports.print.offices', $dataToSend, [], ['useOTL' => 0xFF, 'format' => 'A4',]);

            if(isset($request->byMail)){
                $userEmail = $request->email; 
                Mail::send(new SendPDF($pdf->output(), $userEmail));
                return redirect()->back()->with('success', 'Email successfully sent with attachment');;
            }

            return $pdf->stream('offices.pdf');
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function pdfInvoicesByMobileRequestByOffice(Request $request)
    {
        try {
            $data = $this->invoiceModel->getInvoicesByMobileRequestByOffice($request);     
            
            $dataToSend = [
                'invoices' => $data['invoices'],
                'offices' =>  $data['offices'], 
                'total' => $data['total']
                ];
    
            $pdf = Pdf::loadView('admin.exports.print.mobileAndOffice', $dataToSend, [], ['useOTL' => 0xFF, 'format' => 'A4',]);

            if(isset($request->byMail)){
                $userEmail = $request->email; 
                Mail::send(new SendPDF($pdf->output(), $userEmail));
                return redirect()->back()->with('success', 'Email successfully sent with attachment');;
            }
            
            return $pdf->stream('mobileAndOffice.pdf');
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function pdfSurveysReport(Request $request)
    {
        try {
            $report = $this->surveyModel->getSurveysReport($request);

            $surveys = $report['surveys']; 

            $dataToSend = [
                'surveys' => $surveys,
                'subject' => $report['subject'],
                'totalSurveys' => $report['totalSurveys']
                ];
    
            $pdf = Pdf::loadView('admin.exports.print.surveys', $dataToSend, [], ['useOTL' => 0xFF, 'format' => 'A4',]);

            if(isset($request->byMail)){
                $userEmail = $request->email; 
                Mail::send(new SendPDF($pdf->output(), $userEmail));
                return redirect()->back()->with('success', 'Email successfully sent with attachment');;
            }

            return $pdf->stream('surveys.pdf');

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }

    public function pdfOfficesDetails(Request $request)
    {
        try {
            $report = $this->officeModel->getOfficesDetails($request);

            $dataToSend = [
                'invoices' => $report['invoices'],
                'total' => $report['total'],
                'topOffices' => $report['topOffices']
                ];

            $pdf = Pdf::loadView('admin.exports.print.detailedOffices', $dataToSend, [], ['useOTL' => 0xFF, 'format' => 'A4',]);

            if(isset($request->byMail)){
                $userEmail = $request->email; 
                Mail::send(new SendPDF($pdf->output(), $userEmail));
                return redirect()->back()->with('success', 'Email successfully sent with attachment');;
            }

            return $pdf->stream('detailedOffices.pdf');

        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function pdfInvoiceMonthly(Request $request)
    {
        try {
            $data = $this->invoiceModel->getInvoiceMonthly($request);
            
            $dataToSend = [
                'invoices' => $data['monthlyInvoices'],
                'totalInvoices' => $data['totalInvoices']
                ];
    
            $pdf = Pdf::loadView('admin.exports.print.invoicesPerMonth', $dataToSend, [], ['useOTL' => 0xFF, 'format' => 'A4',]);

            if(isset($request->byMail)){
                $userEmail = $request->email; 
                Mail::send(new SendPDF($pdf->output(), $userEmail));
                return redirect()->back()->with('success', 'Email successfully sent with attachment');;
            }

            return $pdf->stream('invoicesPerMonth.pdf');
            
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function pdfOfficesDetailsWithAverage(Request $request)
    {
        try {
            $report = $this->officeModel->getOfficesDetailsWithAverage($request);

            $dataToSend = [
                'invoices' => $report['invoices'],
                'topOffices' => $report['topOffices']
                ];
    
            $pdf = Pdf::loadView('admin.exports.print.detailedOfficesWithAvgProcTime', $dataToSend, [], ['useOTL' => 0xFF, 'format' => 'A4',]);

            if(isset($request->byMail)){
                $userEmail = $request->email; 
                Mail::send(new SendPDF($pdf->output(), $userEmail));
                return redirect()->back()->with('success', 'Email successfully sent with attachment');;
            }

            return $pdf->stream('detailedOfficesWithAvgProcTime.pdf');
            
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function pdfInvoiceMonthlyProcessTime(Request $request)
    {
        try {
            $data = $this->invoiceModel->getInvoiceMonthlyProcessTime($request);

            $dataToSend = [
                'invoices' => $data['monthlyInvoices'],
                'offices' => $data['offices']
                ];
    
            $pdf = Pdf::loadView('admin.exports.print.invoicesPerMonthlyProcessTime', $dataToSend, [], ['useOTL' => 0xFF, 'format' => 'A4',]);

            if(isset($request->byMail)){
                $userEmail = $request->email; 
                Mail::send(new SendPDF($pdf->output(), $userEmail));
                return redirect()->back()->with('success', 'Email successfully sent with attachment');;
            }

            return $pdf->stream('invoicesPerMonthlyProcessTime.pdf');
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function pdfQuarterInvoicesByMobileRequestByOffice(Request $request)
    {
        try {

           $data = $this->invoiceModel->getQuarterInvoicesByMobileRequestByOffice();

           $dataToSend = [
            'invoices' => $data['invoices'],
            'offices' => $data['offices'],
            'total' => $data['total'],
            ];

            $pdf = Pdf::loadView('admin.exports.print.quarterlyMobileAndOffice', $dataToSend, [], ['useOTL' => 0xFF, 'format' => 'A4',]);

            if(isset($request->byMail)){
                $userEmail = $request->email; 
                Mail::send(new SendPDF($pdf->output(), $userEmail));
                return redirect()->back()->with('success', 'Email successfully sent with attachment');;
            }

            return $pdf->stream('quarterlyMobileAndOffice.pdf');
            
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function pdfLastThreeYearsInvoices(Request $request)
    {
        try {
            
            $report = $this->invoiceModel->getLastThreeYearsInvoices();

            $dataToSend = [
                'data' => $report['data'],
                'years' => $report['years'],
                'yearsCount' => $report['yearsCount'],
                ];
   
            $pdf = Pdf::loadView('admin.exports.print.lastThreeYearsInvoices', $dataToSend, [], ['useOTL' => 0xFF, 'format' => 'A4',]);

            if(isset($request->byMail)){
                $userEmail = $request->email; 
                Mail::send(new SendPDF($pdf->output(), $userEmail));
                return redirect()->back()->with('success', 'Email successfully sent with attachment');;
            }

            return $pdf->stream('lastThreeYearsInvoices.pdf');

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }

}
