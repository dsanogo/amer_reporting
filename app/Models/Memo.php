<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    protected $primaryKey = 'Id';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Memos';

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
    protected $fillable = ['Origin', 'Number', 'Brief', 'MemoTypeId', 'Time', 'SuperVisingOrgId'];

    /**
     * Get the type of tha memo.
     */
    public function memoType()
    {
        return $this->belongsTo('App\Models\MemoType', 'MemoTypeId', 'Id');
    }

    /**
     * Get the Organization that owns the memo.
     */
    public function org()
    {
        return $this->belongsTo('App\Models\SupervisingOrg', 'SuperVisingOrgId', 'Id');
    }

    /**
     * Get the Attachment of the memo.
     */
    public function attachment()
    {
        return $this->hasOne('App\Models\File', 'Id', 'PhotoId');
    }

    public function getMemosFilter($orderBy, $dir, $skip, $take, $search)
    {
        $memos = $this->select(
            'Memos.*',
            'MemoTypes.Id as MemoTypesId',
            'MemoTypes.Description as MemoTypesDescription',
            'SupervisingOrgs.Id as SupervisingOrgsId',
            'SupervisingOrgs.Description as SupervisingOrgsDescription'
        );
        $memos->leftJoin('MemoTypes', 'MemoTypes.Id', 'Memos.MemoTypeId');
        $memos->leftJoin('SupervisingOrgs', 'SupervisingOrgs.Id', 'Memos.SuperVisingOrgId');

        if (is_numeric($search)) $memos->where('Number', 'like', '%' . $search . '%');
        else {
            $memos->where('MemoTypes.Description', 'like', '%' . $search . '%');
            $memos->orWhere('SupervisingOrgs.Description', 'like', '%' . $search . '%');
            $memos->orWhere('Memos.Brief', 'like', '%' . $search . '%');
        }

        $this->count = $memos->count();

        $memos->orderBy($orderBy, $dir);
        $memos->skip($skip)->take($take);

        return $memos->get();
    }

    public function getTotal()
    {
        return $this->count;
    }
}
