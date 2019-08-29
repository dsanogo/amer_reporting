<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    /**
    * The table associated with the model.
    *
    */
    protected $table = 'Districts';

    public function offices()
    {
        return $this->hasMany('App\Models\District', 'DistrictId', 'Id');
    }
}
