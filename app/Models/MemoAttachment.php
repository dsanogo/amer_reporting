<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemoAttachment extends Model
{
    protected $primaryKey = 'Id';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'MemoAttachment';

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
    protected $fillable = ['Name', 'Path', 'MemoId'];
}
