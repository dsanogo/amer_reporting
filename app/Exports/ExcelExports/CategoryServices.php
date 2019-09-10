<?php

namespace App\Exports\ExcelExports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class CategoryServices implements FromView
{
    public $invoices;
    public $total;
    public $category;
    public $daterange;

    public function __construct(array $invoices, object $total, object $category, string $daterange) {
        $this->invoices = $invoices;
        $this->total = $total;
        $this->category = $category;
        $this->daterange = $daterange;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.exports.print.categoryServices', [
            'invoices' => $this->invoices,
            'total' => $this->total,
            'category' => $this->category,
            'daterange' => $this->daterange,
            'export' => true
        ]);
    }
}
