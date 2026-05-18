<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\ActivityLog;
use App\Models\Company;
use App\Services\SunatService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolAccessController extends Controller
{
    public function initiate(Request $request, Company $company): JsonResponse
    {
        if (!$company->hasCredentials()) {
            return response()->json([
                'success' => false,
                'message' => 'Esta empresa no tiene credenciales SOL configuradas.',
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isAsistente() || $company->solCredential->created_by !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Solo el asistente contable asignado puede ejecutar el acceso SOL.',
            ], 403);
        }

        $log = AccessLog::create([
            'company_id'      => $company->id,
            'user_id'         => Auth::id(),
            'ruc'             => $company->ruc,
            'razon_social'    => $company->razon_social,
            'status'          => 'PENDING',
            'steps_completed' => 0,
            'ip_address'      => $request->ip(),
            'user_agent'      => substr($request->userAgent() ?? '', 0, 500),
            'accessed_at'     => now(),
        ]);

        return response()->json([
            'success' => true,
            'log_id'  => $log->id,
            'steps'   => config('sol.simulation_steps', []),
        ]);
    }

    public function complete(Request $request, AccessLog $log): JsonResponse
    {
        $request->validate([
            'duration_ms'     => ['required', 'integer', 'min:0'],
            'steps_completed' => ['required', 'integer', 'min:0'],
        ]);

        if ($log->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'No autorizado.'], 403);
        }

        $durationMs  = (int) $request->duration_ms;
        $durationSec = round($durationMs / 1000, 3);
        $baseline    = config('sol.manual_baseline_seconds', 30);
        $saved       = round($baseline - $durationSec, 3);

        $log->update([
            'duration_ms'      => $durationMs,
            'duration_seconds' => $durationSec,
            'status'           => 'SUCCESS',
            'steps_completed'  => $request->steps_completed,
        ]);

        ActivityLog::record('sol_access_success',
            "Acceso SOL exitoso: {$log->ruc} en {$durationSec}s", [
                'model_type' => AccessLog::class,
                'model_id'   => $log->id,
            ]
        );

        return response()->json([
            'success'          => true,
            'duration_ms'      => $durationMs,
            'duration_seconds' => $durationSec,
            'saved_seconds'    => $saved,
            'efficiency_pct'   => $baseline > 0 ? round(($saved / $baseline) * 100, 1) : 0,
        ]);
    }

    public function fail(Request $request, AccessLog $log): JsonResponse
    {
        $request->validate([
            'error_message'   => ['nullable', 'string', 'max:500'],
            'steps_completed' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($log->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'No autorizado.'], 403);
        }

        $log->update([
            'status'          => 'FAILED',
            'steps_completed' => $request->steps_completed ?? 0,
            'error_message'   => $request->error_message ?? 'Error desconocido.',
        ]);

        ActivityLog::record('sol_access_failed', "Acceso SOL fallido: {$log->ruc}");

        return response()->json(['success' => true]);
    }

    /**
     * Abre SUNAT en nueva pestaña usando el flujo OAuth real.
     * Obtiene el state de SUNAT por server-side curl, registra el acceso
     * y devuelve una página HTML que auto-envía las credenciales a SUNAT.
     */
    public function launch(Company $company, string $sistema): View
    {
        $sistemas = SunatService::getSistemas();

        if (!array_key_exists($sistema, $sistemas)) {
            abort(404, 'Sistema no válido.');
        }

        if (!$company->hasCredentials()) {
            abort(422, 'Esta empresa no tiene credenciales SOL configuradas.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isAsistente() || $company->solCredential->created_by !== $user->id) {
            abort(403, 'Solo el asistente contable asignado puede ejecutar el acceso SOL.');
        }

        $sunat     = new SunatService();
        $stateData = $sunat->getState($sistema);

        if (isset($stateData['error'])) {
            ActivityLog::record('sol_access_failed', "SUNAT error ({$sistema}): {$company->ruc}");
        } else {
            ActivityLog::record('sol_access_success', "SUNAT launch ({$sistema}): {$company->ruc}");
        }

        $credential = $company->solCredential;

        return view('sol.launch', [
            'company'     => $company,
            'sistema'     => $sistema,
            'sistemaInfo' => $sistemas[$sistema],
            'stateData'   => $stateData,
            'actionUrl'   => $sunat->getActionUrl($sistema),
            'credential'  => $credential,
        ]);
    }
}
