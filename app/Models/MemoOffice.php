<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemoOffice extends Model
{
    protected $primaryKey = 'Id';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'MemoOffices';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['OfficeId', 'MemoId'];
}
