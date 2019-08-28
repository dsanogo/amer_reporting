<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    /**
    * The table associated with the model.
    *
    */
    protected $table = 'Offices';

    public function employees()
    {
        return $this->hasMany('App\Models\Employee', 'OfficeId', 'Id');
    }
}
