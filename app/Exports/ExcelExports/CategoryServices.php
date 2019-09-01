<?php

namespace App\Exports\ExcelExports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryServices implements FromView, WithHeadings
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

    public function headings(): array
    {
        return [
            'نوع المعاملة',
            'إجمالى أعداد المعاملات',
            'إجمالى الرسوم',
        ];
    }
}
