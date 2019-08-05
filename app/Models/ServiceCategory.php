<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    /**
    * The table associated with the model.
    *
    */
    protected $table = 'ServiceCategories';

    /**
    * Get all the Category services 
    *
    */
    public function services()
    {
        return $this->hasMany('App\Models\Service', 'ServicesCategoryId', 'Id');
    }
}
