<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupervisingOrg extends Model
{
    protected $primaryKey = 'Id';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'SupervisingOrgs';

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
    protected $fillable = ['Org_Desc'];

    /**
     * Get the memos of that type.
     */
    public function memos()
    {
        return $this->hasMany('App\Models\Memo', 'SuperVisingOrgId', 'Id');
    }
}
