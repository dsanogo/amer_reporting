<?php

namespace App\Exports\ExcelExports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class QuarterlyMobileAndOffice implements FromView
{
    public $invoiceDetailed;
    public $offices;
    public $total;
    public $topServices;

    public function __construct(array $invoiceDetailed, object $offices,object $total ,object $topServices) {
        $this->invoiceDetailed = $invoiceDetailed;
        $this->offices = $offices;
        $this->total = $total;
        $this->topServices = $topServices;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.exports.print.quarterlyMobileAndOffice', [
            'invoices' => $this->invoiceDetailed,
            'offices' => $this->offices,
            'total'=>$this->total,
            'topServices' => $this->topServices,
            'export' => true
        ]);
    }
}
