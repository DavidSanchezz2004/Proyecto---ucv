<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Verificar si ya respondió todas las preguntas
        $totalQuestions = SurveyQuestion::active()->count();
        $answered       = SurveyResponse::where('respondent_id', $user->id)->count();

        if ($answered >= $totalQuestions && $totalQuestions > 0) {
            return redirect()->route('survey.thanks');
        }

        $questions = SurveyQuestion::active()->get()->groupBy('dimension');

        return view('survey.index', compact('questions'));
    }

    public function store(Request $request)
    {
        $user       = auth()->user();
        $questionIds = SurveyQuestion::active()->pluck('id');

        // Validar que se respondan todas las preguntas activas
        $rules = [];
        foreach ($questionIds as $id) {
            $rules["responses.$id"] = ['required', 'integer', 'min:1', 'max:5'];
        }
        $data = $request->validate($rules);

        // Verificar que no haya respondido ya
        $alreadyAnswered = SurveyResponse::where('respondent_id', $user->id)->exists();
        if ($alreadyAnswered) {
            return redirect()->route('survey.thanks');
        }

        DB::transaction(function () use ($data, $user) {
            foreach ($data['responses'] as $questionId => $score) {
                SurveyResponse::create([
                    'respondent_id' => $user->id,
                    'question_id'   => $questionId,
                    'score'         => $score,
                    'responded_at'  => now(),
                ]);
            }
        });

        ActivityLog::record('survey_submitted', "Encuesta completada por: {$user->email}");

        return redirect()->route('survey.thanks');
    }

    public function thanks()
    {
        return view('survey.thanks');
    }

    public function results()
    {
        // Resultados por dimensión
        $byDimension = SurveyResponse::join('survey_questions', 'survey_responses.question_id', '=', 'survey_questions.id')
            ->selectRaw("
                survey_questions.variable,
                survey_questions.dimension,
                COUNT(DISTINCT respondent_id) as respondents,
                ROUND(AVG(score), 2) as avg_score,
                COUNT(*) as total_responses
            ")
            ->groupBy('survey_questions.variable', 'survey_questions.dimension')
            ->orderBy('survey_questions.variable')
            ->orderBy('survey_questions.dimension')
            ->get();

        // Resultados por pregunta
        $byQuestion = SurveyResponse::join('survey_questions', 'survey_responses.question_id', '=', 'survey_questions.id')
            ->selectRaw("
                survey_questions.order_number,
                survey_questions.variable,
                survey_questions.dimension,
                survey_questions.question_text,
                COUNT(*) as total,
                ROUND(AVG(score), 2) as avg_score,
                SUM(CASE WHEN score = 1 THEN 1 ELSE 0 END) as score_1,
                SUM(CASE WHEN score = 2 THEN 1 ELSE 0 END) as score_2,
                SUM(CASE WHEN score = 3 THEN 1 ELSE 0 END) as score_3,
                SUM(CASE WHEN score = 4 THEN 1 ELSE 0 END) as score_4,
                SUM(CASE WHEN score = 5 THEN 1 ELSE 0 END) as score_5
            ")
            ->groupBy(
                'survey_questions.order_number',
                'survey_questions.variable',
                'survey_questions.dimension',
                'survey_questions.question_text'
            )
            ->orderBy('survey_questions.order_number')
            ->get();

        $totalRespondents = SurveyResponse::distinct('respondent_id')->count('respondent_id');

        return view('survey.results', compact('byDimension', 'byQuestion', 'totalRespondents'));
    }
}
