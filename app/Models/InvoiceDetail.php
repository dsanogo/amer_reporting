<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    /**
    * The table associated with the model.
    *
    */
    protected $table = 'InvoiceDetails';

    /**
    * Get the Category to which the service belons to
    *
    */
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'InvoiceId', 'Id');
    }
}
