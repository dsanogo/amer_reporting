<?php

namespace App\Exports\ExcelExports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class CategoryServices implements FromView
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
        return view('admin.exports.print.categoryServices', [
            'invoices' => $this->invoices,
            'total' => $this->total,
            'export' => true
        ]);
    }
}
