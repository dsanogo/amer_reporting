<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $primaryKey = 'Id';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Files';

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
    protected $fillable = ['File'];

    public function setFileAttribute($value)
    {
        $this->attributes['File'] = DB::raw("CONVERT(VARBINARY(MAX), '". $value ."')");
    }
}
