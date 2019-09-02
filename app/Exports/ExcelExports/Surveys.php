<?php

namespace App\Exports\ExcelExports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class Surveys implements FromView
{

    public $surveys;

    public function __construct(array $surveys) {
        $this->surveys = $surveys;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.exports.print.surveys', [
            'surveys' => $this->surveys,
            'export' => true
        ]);
    }
}
