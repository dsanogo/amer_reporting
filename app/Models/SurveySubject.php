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

    public function getSurveysReport($request)
    {

        try {

            if(isset($request->daterange) && $request->daterange !== ''){
                $date = explode(' - ', $request->daterange);
                $from = $date[0];
                $to = $date[1];
            }else {
                $from = '';
                $to = '';
            }

            $subjectSurveys = [];

            $survey_id = $request->survey_id;

            // get total Surveys for the subject
            $totalSurveys = UserSurvey::where('SubjectId', $survey_id)->count();

            if($totalSurveys > 0) {
                $surveys = UserSurvey::selectRaw('
                    EvaluationId, COUNT(EvaluationId) as n_evals
                ')
                ->where('SubjectId', $survey_id)
                ->whereDate('CreationTime','>=', $from)->whereDate('CreationTime', '<=', $to)
                ->groupBy('EvaluationId')->get();

                foreach ($surveys as $key => $survey) {
                    $evalName = SurveyEvaluation::select('Description')->where('Id', $survey->EvaluationId)->pluck('Description')->toArray()[0];
                    $subjectSurveys[$key]['evalName'] = $evalName;
                    $subjectSurveys[$key]['percentage'] = number_format(($survey->n_evals / $totalSurveys)*100, 3, '.', '');
                }
            }

            return [
                'surveys' => $subjectSurveys,
                'allSubjects' => SurveySubject::all(),
                'subject' => SurveySubject::findOrFail($survey_id),
                'totalSurveys' => $totalSurveys
            ];            
            
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }
}
