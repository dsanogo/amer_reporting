<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
    * The table associated with the model.
    *
    */
    protected $table = 'Services';

    /**
    * Get the Category to which the service belons to
    *
    */
    public function category()
    {
        return $this->belongsTo('App\Models\ServiceCategory', 'ServicesCategoryId', 'Id');
    }
}
