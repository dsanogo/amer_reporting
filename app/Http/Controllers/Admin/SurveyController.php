<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SurveySubject;
use App\Models\UserSurvey;
use App\Models\SurveyEvaluation;

class SurveyController extends Controller
{
    public $surveyModel;
    public function __construct(SurveySubject $survey) {
        $this->surveyModel = $survey;
    }
    public function getSurveysReport()
    {
        try {
            $surveys = $this->surveyModel->getSurveysReport()['surveys'];

            return view('admin.surveys.index')->withSurveys($surveys);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
        
    }

    public function printSurveysReport()
    {
        try {
            $surveys = $this->surveyModel->getSurveysReport()['surveys'];
            return view('admin.exports.print.surveys')->withSurveys($surveys);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }
}
