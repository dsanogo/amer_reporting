<?php

namespace App\Exports\ExcelExports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoicesPerMonthlyProcessTime implements FromView
{
    public $monthlyInvoices;
    public $offices;

    public function __construct(object $monthlyInvoices, object $offices) {
        $this->monthlyInvoices = $monthlyInvoices;
        $this->offices = $offices;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.exports.print.invoicesPerMonthlyProcessTime', [
            'invoices' => $this->monthlyInvoices,
            'offices' => $this->offices,
            'export' => true
        ]);
    }
}
