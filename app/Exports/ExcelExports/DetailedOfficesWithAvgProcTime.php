<?php

namespace App\Exports\ExcelExports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class DetailedOfficesWithAvgProcTime implements FromView
{
    public $data;
    public $invoiceDetailed;

    public function __construct(array $data, array $invoiceDetailed) {
        $this->data = $data;
        $this->invoiceDetailed = $invoiceDetailed;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.exports.print.detailedOfficesWithAvgProcTime', [
            'data' => $this->data,
            'invoices' => $this->invoiceDetailed,
            'export' => true
        ]);
    }
}
