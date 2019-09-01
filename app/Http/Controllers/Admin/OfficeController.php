<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
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
        try {
            $data['offices'] = Office::with('employees')->get();

            $invoiceDetailed = [];
            $offices = $offices = Office::select('Id', 'Name')->get();
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

            return view('admin.offices.detailedOffices')->withData($data)->withInvoices($invoiceDetailed)->withTotal($total)->withtopOffices($topOffices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function getOfficesDetailsWithAverage()
    {
        try {
            $data['offices'] = Office::with('employees')->get();

            $invoiceDetailed = [];
            $offices = $offices = Office::select('Id', 'Name')->get();
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
            
            return view('admin.offices.detailedOfficesWithAvgProcTime')->withData($data)->withInvoices($invoiceDetailed)->withtopOffices($topOffices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function printOfficesDetailsWithAverage()
    {
        try {
            $data['offices'] = Office::with('employees')->get();

            $invoiceDetailed = [];
            $offices = $offices = Office::select('Id', 'Name')->get();
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
            
            return view('admin.exports.print.detailedOfficesWithAvgProcTime')->withData($data)->withInvoices($invoiceDetailed)->withtopOffices($topOffices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function printOfficesDetails()
    {
        try {
            $data['offices'] = Office::with('employees')->get();

            $invoiceDetailed = [];
            $offices = $offices = Office::select('Id', 'Name')->get();
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

            return view('admin.exports.print.detailedOffices')->withData($data)->withInvoices($invoiceDetailed)->withTotal($total)->withtopOffices($topOffices);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }
}
