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

            return view('admin.surveys.index')->withSurveys($surveys);

        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }

    public function printSurveysReport()
    {
        try {
            $surveySubjects = SurveySubject::all();
            $surveys = [];




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

            return view('admin.exports.print.surveys')->withSurveys($surveys);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }
}
