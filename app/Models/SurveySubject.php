<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveySubject extends Model
{
    /**
    * The table associated with the model.
    *
    */
    protected $table = 'SurveySubjects';

    public function evaluations()
    {
        return $this->hasMany('App\Models\SurveyEvaluation', 'SurveySubjectId', 'Id');
    }

    public function userSurveys()
    {
        return $this->hasMany('App\Models\UserSurvey', 'SubjectId', 'Id');
    }
}
