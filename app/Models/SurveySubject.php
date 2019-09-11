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
            
            $allSubjects = SurveySubject::all();
            
            $surveySubjects = SurveySubject::where(function($query) use ($from, $to) 
                {
                    if($from !== '' && $to !== '') {
                        $query->whereDate('CreationTime','>=', $from)->whereDate('CreationTime', '<=', $to);
                    }
                })->get();

            $surveys = [];

            if(count($surveySubjects)  !== 0) {
                foreach ($surveySubjects as $key => $survey) {
                    if(count($survey->userSurveys) !== 0){
                        $data[$key]['description'] = $survey->Description;
                        $data[$key]['excellents'] = 0;
                        $data[$key]['veryGoods'] = 0;
                        $data[$key]['mediums'] = 0;
                        $data[$key]['bads'] = 0;
                        $data[$key]['veryBads'] = 0;
    
                        if(isset($survey->userSurveys));
                        foreach ($survey->userSurveys as $userSurvey) {
                            
                            $evaluation = SurveyEvaluation::select('SortIndex')->findOrFail($userSurvey->EvaluationId); 
                            
                            switch ($evaluation->SortIndex) {
                                case 1:
                                    $data[$key]['excellents'] += 1;
                                    break;
    
                                case 2:
                                    $data[$key]['veryGoods'] += 1;
                                    break;
    
                                case 3:
                                    $data[$key]['mediums'] += 1;
                                    break;
                                
                                case 4:
                                    $data[$key]['bads'] += 1;
                                    break;
    
                                case 5:
                                    $data[$key]['veryBads'] += 1;
                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }
                        }
                        $data[$key]['excellents'] = ceil($data[$key]['excellents'] / count($survey->userSurveys) * 100);
                        $data[$key]['veryGoods'] = ceil($data[$key]['veryGoods'] / count($survey->userSurveys) * 100);
                        $data[$key]['mediums'] = ceil($data[$key]['mediums'] / count($survey->userSurveys) * 100);
                        $data[$key]['bads'] = ceil($data[$key]['bads'] / count($survey->userSurveys) * 100);
                        $data[$key]['veryBads'] = ceil($data[$key]['veryBads'] / count($survey->userSurveys) * 100);
                        $data[$key]['numberOfSurveys'] =  count($survey->userSurveys);
                    }
                }
                
                $surveys['surveys'] = $data;
    
                return [
                    'surveys' => $surveys,
                    'allSubjects' => $allSubjects
                ];
            } else {
                return ['surveys' => [],
                        'allSubjects' => $allSubjects
                        ];
            }
            
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }
}
