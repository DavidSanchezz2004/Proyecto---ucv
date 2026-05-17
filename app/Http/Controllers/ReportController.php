<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function efficiency(Request $request)
    {
        $user        = Auth::user();
        $isAsistente = $user->isAsistente();
        $baseline    = config('sol.manual_baseline_seconds', 30);

        $base = AccessLog::where('status', 'SUCCESS')
            ->when($isAsistente, fn($q) => $q->where('user_id', $user->id));

        $totalAccesses     = (clone $base)->count();
        $totalFailed       = AccessLog::where('status', 'FAILED')
            ->when($isAsistente, fn($q) => $q->where('user_id', $user->id))->count();
        $avgSeconds        = round((clone $base)->avg('duration_seconds') ?? 0, 2);
        $minSeconds        = round((clone $base)->min('duration_seconds') ?? 0, 2);
        $maxSeconds        = round((clone $base)->max('duration_seconds') ?? 0, 2);
        $totalSavedSeconds = round(
            (clone $base)->sum(DB::raw("($baseline - duration_seconds)")), 2
        );
        $efficiencyPct = $baseline > 0 && $avgSeconds > 0
            ? round((($baseline - $avgSeconds) / $baseline) * 100, 1)
            : 0;

        $byCompany = (clone $base)
            ->selectRaw("company_id, ruc, razon_social,
                COUNT(*) as total_accesses,
                ROUND(AVG(duration_seconds), 2) as avg_seconds,
                ROUND(MIN(duration_seconds), 2) as min_seconds,
                ROUND(MAX(duration_seconds), 2) as max_seconds,
                ROUND(SUM($baseline - duration_seconds), 2) as total_saved")
            ->groupBy('company_id', 'ruc', 'razon_social')
            ->orderByDesc('total_accesses')
            ->paginate(15)
            ->withQueryString();

        $distribution = (clone $base)
            ->selectRaw("
                CASE
                    WHEN duration_seconds < 2 THEN 'Menos de 2s'
                    WHEN duration_seconds < 3 THEN '2 - 3s'
                    WHEN duration_seconds < 4 THEN '3 - 4s'
                    WHEN duration_seconds < 5 THEN '4 - 5s'
                    ELSE 'Más de 5s'
                END as rango,
                COUNT(*) as total")
            ->groupBy('rango')
            ->orderBy('rango')
            ->get();

        return view('reports.efficiency', compact(
            'baseline', 'totalAccesses', 'totalFailed',
            'avgSeconds', 'minSeconds', 'maxSeconds',
            'totalSavedSeconds', 'efficiencyPct',
            'byCompany', 'distribution', 'isAsistente'
        ));
    }
}
