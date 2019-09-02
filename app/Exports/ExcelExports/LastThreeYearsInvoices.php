<?php

namespace App\Exports\ExcelExports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LastThreeYearsInvoices implements FromView
{
    public $data;
    public $years;
    public $yearsCount;

    public function __construct(array $data, array $years, array $yearsCount) {
        $this->data = $data;
        $this->years = $years;
        $this->yearsCount = $yearsCount;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.exports.print.lastThreeYearsInvoices', [
            'data' => $this->data,
            'years' => $this->years,
            'yearsCount' => $this->yearsCount,
            'export' => true
        ]);
    }
}
