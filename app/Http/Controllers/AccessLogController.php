<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessLogController extends Controller
{
    public function index(Request $request)
    {
        $user        = Auth::user();
        $isAsistente = $user->isAsistente();

        $logs = AccessLog::with(['company', 'user'])
            ->when($isAsistente, fn($q) => $q->where('user_id', $user->id))
            ->when($request->empresa_id, fn($q, $id) => $q->where('company_id', $id))
            ->when(!$isAsistente && $request->user_id, fn($q, $id) => $q->where('user_id', $id))
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->byDateRange($request->fecha_desde, $request->fecha_hasta)
            ->latest('accessed_at')
            ->paginate(20)
            ->withQueryString();

        // Asistente solo ve sus propias empresas en el filtro
        $companies = $isAsistente
            ? Company::where('created_by', $user->id)->orderBy('razon_social')->get(['id', 'ruc', 'razon_social'])
            : Company::orderBy('razon_social')->get(['id', 'ruc', 'razon_social']);

        $users = $isAsistente ? collect() : User::orderBy('name')->get(['id', 'name']);

        return view('access-logs.index', compact('logs', 'companies', 'users', 'isAsistente'));
    }
}
