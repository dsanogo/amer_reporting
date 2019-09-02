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
use App\Models\District;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\MobileRequest;
use App\Models\Office;
use App\Models\OfficeService;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\SurveyEvaluation;
use App\Models\SurveySubject;
use App\User;
use Illuminate\Support\Facades\DB;
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

    public function exportInvoicesForOffices()
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
            
            return Excel::download(new Offices($invoiceDetailed, $total), 'officesInvoices.xlsx');
            // return view('admin.invoicesReport.offices')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function exportInvoicesByMobileRequestByOffice()
    {
        try {
            $invoiceDetailed = [];
            $offices = Office::select('Id', 'Name')->get();
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


            return Excel::download(new MobileAndOffice($invoiceDetailed, $total), 'mobileAndOfficesInvoices.xlsx');
            // return view('admin.exports.print.mobileAndOffice')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function exportSurveysReport()
    {
        try {
            $surveySubjects = SurveySubject::all();
            $surveys = [];
            foreach ($surveySubjects as $key => $survey) {
                if(count($survey->userSurveys) !== 0){
                    $data[$key]['description'] = $survey->Description;
                    $data[$key]['excellents'] = 0;
                    $data[$key]['veryGoods'] = 0;
                    $data[$key]['mediums'] = 0;
                    $data[$key]['bads'] = 0;
                    $data[$key]['veryBads'] = 0;

                    if(isset($survey->userSurveys));
                    foreach ($survey->userSurveys as $userSurvey) {
                        
                        $evaluation = SurveyEvaluation::select('SortIndex')->findOrFail($userSurvey->EvaluationId); 
                        
                        switch ($evaluation->SortIndex) {
                            case 1:
                                $data[$key]['excellents'] += 1;
                                break;

                            case 2:
                                $data[$key]['veryGoods'] += 1;
                                break;

                            case 3:
                                $data[$key]['mediums'] += 1;
                                break;
                            
                            case 4:
                                $data[$key]['bads'] += 1;
                                break;

                            case 5:
                                $data[$key]['veryBads'] += 1;
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                    }
                    $data[$key]['excellents'] = ceil($data[$key]['excellents'] / count($survey->userSurveys) * 100);
                    $data[$key]['veryGoods'] = ceil($data[$key]['veryGoods'] / count($survey->userSurveys) * 100);
                    $data[$key]['mediums'] = ceil($data[$key]['mediums'] / count($survey->userSurveys) * 100);
                    $data[$key]['bads'] = ceil($data[$key]['bads'] / count($survey->userSurveys) * 100);
                    $data[$key]['veryBads'] = ceil($data[$key]['veryBads'] / count($survey->userSurveys) * 100);
                    $data[$key]['numberOfSurveys'] =  count($survey->userSurveys);
                }
            }
            
            $surveys['surveys'] = $data;

            return Excel::download(new Surveys($surveys), 'surveys.xlsx');
            // return view('admin.exports.print.surveys')->withSurveys($surveys);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }

    public function exportOfficesDetails()
    {
        try {
            $data['offices'] = Office::with('employees')->get();
            $invoiceDetailed = [];
            $offices = Office::select('Id', 'Name')->get();
            $invoices = Invoice::select('TotalFees', 'MobileRequestId')->get();
            $sumOfInvoices = 0;
            
            foreach ($offices as $key => $office) {
                $invoiceCount = 0;
                $processTime = 0;

                foreach ($invoices as $invoice) {
                    
                    // Get the office Id of the Invoice
                    $officeId = MobileRequest::select('OfficeId')->where('Id', $invoice->MobileRequestId)->first();

                    if($officeId){

                        if($office->Id == $officeId->OfficeId){
                            $invoiceCount += 1;
                            $sumOfInvoices += 1;
                            $processTime += $invoice->ProcessingTime;
                        }                
                        
                        $invoiceDetailed[$key] = (object)[
                            'office' => $office->Name,
                            'count' => $invoiceCount,
                        ];
                    }
                    
                }
            }
            
            $topOffices = [];
            $test = (array)$invoiceDetailed;

            foreach ($test as $key => $invoice) {

                if (count($topOffices) < 5 && ($key < count($test)-1)) {
                    if($invoice->count > $test[$key+1]->count || $invoice->count == $test[$key+1]->count){
                        array_push($topOffices, $invoice);
                    }
                }
            };
           
            $total = (object)[
                'totalInvoices' => $sumOfInvoices,
                'totalEmp' => Employee::count()
            ];

            return Excel::download(new DetailedOffices($invoiceDetailed, $total, $data), 'detailedOffices.xlsx');
            // return view('admin.exports.print.detailedOffices')->withData($data)->withInvoices($invoiceDetailed)->withTotal($total)->withtopOffices($topOffices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }
    
    public function exportInvoiceMonthly()
    {
        try {
            $monthlyInvoices = DB::table('Invoices')->select(DB::raw('COUNT(Id) as total_invoices'),DB::raw("MONTH(Time) as m"), DB::raw("DATENAME(mm, Time) as month"), DB::raw('YEAR(Time) as year'))
                                    ->groupBy(DB::raw('MONTH(Time)'), DB::raw("DATENAME(mm, Time)"),DB::raw('YEAR(Time)'))->get();
            $totalInvoices = Invoice::count();

            return Excel::download(new InvoicesPerMonth((object)$monthlyInvoices, $totalInvoices), 'invoicesPerMonth.xlsx');
            // return view('admin.invoicesReport.invoicesPerMonth')->withInvoices($monthlyInvoices)->withTotalInvoices($totalInvoices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function exportOfficesDetailsWithAverage()
    {
        try {
            $data['offices'] = Office::with('employees')->get();

            $invoiceDetailed = [];
            $offices = Office::select('Id', 'Name')->get();
            $invoices = Invoice::select('MobileRequestId', 'ProcessingTime')->get();
            $districts = District::select('Id', 'Name')->get();
            $sumOfInvoices = 0;
            
            foreach ($offices as $key => $office) {
                $invoiceCount = 0;
                $processTime = 0;

                foreach ($invoices as $invoice) {
                    
                    // Get the office Id of the Invoice
                    $officeId = MobileRequest::select('OfficeId')->where('Id', $invoice->MobileRequestId)->first();

                    if($officeId){

                        if($office->Id == $officeId->OfficeId){
                            $invoiceCount += 1;
                            $sumOfInvoices += 1;
                            $processTime += intval($invoice->ProcessingTime);
                        }                
                        
                        $invoiceDetailed[$key] = (object)[
                            'officeId' => $office->Id,
                            'office' => $office->Name,
                            'countInvoice' => $invoiceCount,
                            'totalTime' => $processTime,
                            'processTime' => $invoiceCount == 0 ? 0 : ceil($processTime/$invoiceCount)
                        ];
                    }
                }
            }

            $procTimes = [];

            foreach ($invoiceDetailed as $key => $invoice) {
                array_push($procTimes, $invoice->processTime);
            }

            rsort($procTimes);

            $topOfficesIndex = [];
            foreach ($procTimes as $p_time) {
                if(count($topOfficesIndex) !== 5){
                    $key = array_search($p_time, array_column($invoiceDetailed, 'processTime'));
                    array_push($topOfficesIndex, $key);
                }
            }
            
            $topOffices = [];
            foreach ($topOfficesIndex as $oIndex) {
                array_push($topOffices, (object)[
                    'office_id' => $invoiceDetailed[$oIndex]->officeId,
                    'office' => $invoiceDetailed[$oIndex]->office,
                    'proccess_time' => $invoiceDetailed[$oIndex]->processTime
                ]);
            }

            $areas = [];
            
             foreach ($districts as $key => $district) {
                $distritCount = 0;
                foreach ($topOffices as $office) {
                    $districtId = Office::select('DistrictId')->where('Id', $office->office_id)->first()->toArray()['DistrictId'];
                    if($district->Id == $districtId){
                        $distritCount+=1;
                    }
                }

                $areas[$key] = (object)[
                    'disctict' => $district->Name,
                    'count' => $distritCount,
                ];
             }
            
            return Excel::download(new DetailedOfficesWithAvgProcTime($data, $invoiceDetailed), 'detailedOfficesWithAvgProcTime.xlsx');
            // return view('admin.exports.print.detailedOfficesWithAvgProcTime')->withData($data)->withInvoices($invoiceDetailed)->withtopOffices($topOffices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function exportInvoiceMonthlyProcessTime(Request $request)
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

            return Excel::download(new InvoicesPerMonthlyProcessTime($monthlyInvoices, $offices), 'invoicesPerMonthlyProcessTime.xlsx');
            // return view('admin.exports.print.invoicesPerMonthlyProcessTime')->withInvoices($monthlyInvoices)->withOffices($offices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function exportQuarterInvoicesByMobileRequestByOffice()
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
            
            return Excel::download(new QuarterlyMobileAndOffice($invoiceDetailed, $offices, $total, $topServices), 'quarterlyMobileAndOffice.xlsx');
            // return view('admin.exports.print.quarterlyMobileAndOffice')->withInvoices($invoiceDetailed)->withOffices($offices)->withTotal($total)->withTopServices($topServices);
            // return response()->json(['status' => 'success', 'data' => $invoiceDetailed], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function exportLastThreeYearsInvoices()
    {
        try {
            $data = [];
            // Get the last 3 years
            $years = [];

            for ($i=0; $i < 3; $i++) { 
                array_push($years, date("Y",strtotime(" -" .$i." year")));
            }

            // Get all the months
            $months = [];

            for ($m=1; $m<=12; $m++) {
                array_push($months, [
                    'id' => $m,
                    'name' => date('F', mktime(0,0,0,$m, 1, date('Y')))
                ]);
            }

            foreach ($months as $month) {

                foreach ($years as $year) {
                    $data[$month['name']][$year]['invoice'] = $this->getInvoicesPerMonthInYear($month['id'], $year);
                }
            }

            $yearsCount = [];
            foreach ($years as $year) {
                array_push($yearsCount, $this->getTotalInvicePerYear($year));
            }

            return Excel::download(new LastThreeYearsInvoices($data, $years, $yearsCount), 'lastThreeYearsInvoices.xlsx');
            // return view('admin.exports.print.lastThreeYearsInvoices')->withData($data)->withYears($years)->withYearsCount($yearsCount);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }

    public function getInvoicesPerMonthInYear($month, $year)
    {
        $invoices = intVal(Invoice::selectRaw('COUNT(id) as number_of_invoice')
                            ->WhereRaw('MONTH(Time) = ' . $month . ' AND YEAR(Time) = ' . $year)
                            ->pluck('number_of_invoice')->toArray()[0]);

        return $invoices;
    }

    public function getTotalInvicePerYear($year)
    {
        $number_of_invoice = intVal(Invoice::selectRaw('COUNT(id) as number_of_invoice')
                ->WhereRaw('YEAR(Time) = ' . $year)
                ->pluck('number_of_invoice')->toArray()[0]);

        return $number_of_invoice;
    }
}
