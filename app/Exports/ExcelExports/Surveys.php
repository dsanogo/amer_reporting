<?php

namespace App\Exports\ExcelExports;

use Maatwebsite\Excel\Concerns\FromCollection;

class Surveys implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
