<?php

namespace App\Exports\ExcelExports;

use Maatwebsite\Excel\Concerns\FromCollection;

class LastThreeYearsInvoices implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
