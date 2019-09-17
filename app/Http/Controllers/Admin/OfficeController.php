<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public $officeModel;

    public function __construct(Office $office) {
        $this->officeModel = $office;
    }

    public function getOffices()
    {
        try {
            $offices = Office::select('Id', 'Name')->get();
            return response()->json(['status' => 'success', 'data' => $offices], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }

    public function getOfficesDetails(Request $request)
    {
        try {
            $report = $this->officeModel->getOfficesDetails($request);
            $invoiceDetailed = $report['invoices'];
            $total = $report['total'];
            $topOffices = $report['topOffices'];
            $districts = District::all();

            return view('admin.offices.detailedOffices')->withInvoices($invoiceDetailed)->withTotal($total)->withtopOffices($topOffices)->withDistricts($districts);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function getOfficesDetailsWithAverage(Request $request)
    {
        try {
            
            $report = $this->officeModel->getOfficesDetailsWithAverage($request);
            $invoiceDetailed = $report['invoices'];
            $topOffices = $report['topOffices'];
            $districts = District::all();

            return view('admin.offices.detailedOfficesWithAvgProcTime')->withInvoices($invoiceDetailed)->withtopOffices($topOffices)->withDistricts($districts);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function printOfficesDetailsWithAverage(Request $request)
    {
        try {
            $report = $this->officeModel->getOfficesDetailsWithAverage($request);
            $invoiceDetailed = $report['invoices'];
            $topOffices = $report['topOffices'];
            $district = $report['district'];
            $daterange = $report['daterange'];
            
            return view('admin.exports.print.detailedOfficesWithAvgProcTime')->withInvoices($invoiceDetailed)->withtopOffices($topOffices)->withDistrict($district)->withDaterange($daterange);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }

    public function printOfficesDetails(Request $request)
    {
        try {
            $report = $this->officeModel->getOfficesDetails($request);

            $invoiceDetailed = $report['invoices'];
            $total = $report['total'];
            $topOffices = $report['topOffices'];
            $district = $report['district'];
            $daterange = $report['daterange'];

            return view('admin.exports.print.detailedOffices')->withInvoices($invoiceDetailed)->withTotal($total)->withtopOffices($topOffices)->withDistrict($district)->withDaterange($daterange);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 200);
        }
    }
}
