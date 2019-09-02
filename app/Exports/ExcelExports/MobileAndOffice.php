<?php

namespace App\Exports\ExcelExports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MobileAndOffice implements FromView
{
    public $invoices;
    public $total;

    public function __construct(array $invoices, object $total) {
        $this->invoices = $invoices;
        $this->total = $total;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.exports.print.mobileAndOffice', [
            'invoices' => $this->invoices,
            'total' => $this->total,
            'export' => true
        ]);
    }
}
