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
    public function getSurveysReport(Request $request)
    {
        try {
            $report = $this->surveyModel->getSurveysReport($request);
            $surveySubjects = $report['allSubjects'];
            $surveys = $report['surveys'];
            $subject = $report['subject'];
            $totalSurveys = $report['totalSurveys'];
        
            return view('admin.surveys.index')->withSurveys($surveys)->withSurveySubjects($surveySubjects)->withSubject($subject)->withTotalSurveys($totalSurveys);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
        
    }

    public function printSurveysReport(Request $request)
    {
        try {
            $report = $this->surveyModel->getSurveysReport($request);
            $surveys = $report['surveys'];
            $subject = $report['subject'];
            $totalSurveys = $report['totalSurveys'];      
            $daterange = $report['daterange'];

            return view('admin.exports.print.surveys')->withSurveys($surveys)->withSubject($subject)->withTotalSurveys($totalSurveys)->withDaterange($daterange);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()], 200);
        }
    }
}
