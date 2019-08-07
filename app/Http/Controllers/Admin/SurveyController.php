<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SurveySubject;
use App\Models\UserSurvey;
use App\Models\SurveyEvaluation;

class SurveyController extends Controller
{
    public function getSurveysReport()
    {
        try {
            $surveySubjects = SurveySubject::all();
            $surveys = [];

            foreach ($surveySubjects as $key => $survey) {


                $data[$key]['description'] = $survey->Description;
                $data[$key]['excellents'] = 0;
                $data[$key]['veryGoods'] = 0;
                $data[$key]['mediums'] = 0;
                $data[$key]['bads'] = 0;
                $data[$key]['veryBads'] = 0;

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
                $data[$key]['excellents'] = $data[$key]['excellents'] / count($survey->userSurveys) * 100;
                $data[$key]['veryGoods'] = $data[$key]['veryGoods'] / count($survey->userSurveys) * 100;
                $data[$key]['mediums'] = $data[$key]['mediums'] / count($survey->userSurveys) * 100;
                $data[$key]['bads'] = $data[$key]['bads'] / count($survey->userSurveys) * 100;
                $data[$key]['veryBads'] = $data[$key]['veryBads'] / count($survey->userSurveys) * 100;
                $data[$key]['numberOfSurveys'] =  count($survey->userSurveys);
            }
            
            $surveys['surveys'] = $data;
            return view('admin.surveys.index')->withSurveys($surveys);

        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }
}
