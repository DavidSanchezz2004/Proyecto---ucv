<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\ActivityLog;
use App\Models\Company;
use App\Models\SolCredential;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user        = Auth::user();
        $isAsistente = $user->isAsistente();
        $baseline    = config('sol.manual_baseline_seconds', 30);

        $accessBase = AccessLog::where('status', 'SUCCESS')
            ->when($isAsistente, fn($q) => $q->where('user_id', $user->id));

        $totalCompanies     = $isAsistente
            ? Company::where('created_by', $user->id)->count()
            : Company::count();
        $companiesWithCreds = $isAsistente
            ? Company::where('created_by', $user->id)->whereHas('solCredential')->count()
            : SolCredential::count();
        $totalUsers         = $isAsistente ? null : User::where('is_active', true)->count();

        $accessesToday  = (clone $accessBase)->whereDate('accessed_at', today())->count();
        $accessesTotal  = (clone $accessBase)->count();
        $accessesFailed = AccessLog::where('status', 'FAILED')
            ->when($isAsistente, fn($q) => $q->where('user_id', $user->id))->count();

        $avgSeconds = (clone $accessBase)->avg('duration_seconds') ?? 0;
        $totalSaved = (clone $accessBase)->sum(DB::raw("($baseline - duration_seconds)"));

        $dailyData = (clone $accessBase)
            ->where('accessed_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw("DATE(accessed_at) as fecha, COUNT(*) as total")
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get()
            ->keyBy('fecha');

        $labels = [];
        $values = [];
        for ($i = 6; $i >= 0; $i--) {
            $date     = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d/m');
            $values[] = $dailyData[$date]->total ?? 0;
        }

        $recentActivity = $isAsistente ? collect() : ActivityLog::with('user')
            ->latest('created_at')->take(8)->get();

        $recentAccesses = AccessLog::with(['company', 'user'])
            ->where('status', 'SUCCESS')
            ->when($isAsistente, fn($q) => $q->where('user_id', $user->id))
            ->latest('accessed_at')
            ->take(5)
            ->get();

        // Asistente extras
        $myCompanies   = $isAsistente
            ? Company::with('solCredential')
                ->where('created_by', $user->id)
                ->orderBy('razon_social')
                ->get()
            : collect();

        $surveyTotal    = SurveyQuestion::where('is_active', true)->count();
        $surveyAnswered = SurveyResponse::where('respondent_id', $user->id)->count();
        $surveyDone     = $surveyAnswered >= $surveyTotal && $surveyTotal > 0;

        $bestSeconds = $isAsistente
            ? (clone $accessBase)->min('duration_seconds') ?? 0
            : 0;

        return view('dashboard.index', compact(
            'isAsistente',
            'totalCompanies', 'companiesWithCreds', 'totalUsers',
            'accessesToday', 'accessesTotal', 'accessesFailed',
            'avgSeconds', 'totalSaved', 'baseline',
            'labels', 'values',
            'recentActivity', 'recentAccesses',
            'myCompanies', 'surveyTotal', 'surveyAnswered', 'surveyDone', 'bestSeconds'
        ));
    }
}
