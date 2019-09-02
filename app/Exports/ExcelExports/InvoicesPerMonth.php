<?php

namespace App\Exports\ExcelExports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoicesPerMonth implements FromView
{
    public $monthlyInvoices;
    public $totalInvoices;

    public function __construct(object $monthlyInvoices, string $totalInvoices) {
        $this->monthlyInvoices = $monthlyInvoices;
        $this->totalInvoices = $totalInvoices;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.exports.print.invoicesPerMonth', [
            'invoices' => $this->monthlyInvoices,
            'totalInvoices' => $this->totalInvoices,
            'export' => true
        ]);
    }
}
