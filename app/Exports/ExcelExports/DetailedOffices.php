<?php

namespace App\Exports\ExcelExports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DetailedOffices implements FromView
{
    public $invoices;
    public $total;
    public $data;

    public function __construct(array $invoices, object $total, array $data) {
        $this->invoices = $invoices;
        $this->total = $total;
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.exports.print.detailedOffices', [
            'invoices' => $this->invoices,
            'total' => $this->total,
            'data' => $this->data,
            'export' => true
        ]);
    }
}
