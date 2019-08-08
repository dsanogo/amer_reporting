<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\Employee;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
    * Display the Admin Welcome page.
    *
    */

    public function index()
    {
        $data = [];
        $data['employees'] = Employee::count();
        $data['numberOfInvoices'] = Invoice::count();
        $data['totalFees'] = DB::table('Invoices')->sum('TotalFees');
        $data['totalFeesPerMonth'] = DB::table('Invoices')->select(DB::raw('SUM(TotalFees) as total_fees'), DB::raw('MONTH(Time) as month'))
                                    ->groupBy(DB::raw('MONTH(TIME)'))->get();

        return view('admin.index')->withData($data);
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
        $categories = ServiceCategory::select('Id', 'Name')->get();
        return view('admin.invoicesReport.categoryServices')->withCategories($categories);
    }
}
