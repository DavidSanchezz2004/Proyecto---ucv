@extends('layouts.app')
@section('title', 'Historial de Accesos')
@section('page-title', 'Auditoría de Accesos SOL')

@push('styles')
<style>
/* Executive Styles */
.exec-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}
.exec-header-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    letter-spacing: -0.02em;
    margin: 0;
}
.exec-header-subtitle { font-size: 0.8rem; color: #64748b; font-weight: 500; }

.exec-panel {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    margin-bottom: 1.5rem;
}
.exec-panel-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.form-select-exec, .form-control-exec {
    font-family: 'Montserrat', sans-serif;
    font-size: 0.8rem;
    padding: 0.4rem 0.6rem;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    color: #1e293b;
    transition: all 0.2s;
    background-color: #f8fafc;
}
.form-select-exec:focus, .form-control-exec:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    background-color: #fff;
}

.btn-exec-primary {
    background: #2c7be5;
    color: #fff;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.45rem 1rem;
    border-radius: 6px;
    border: none;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
}
.btn-exec-primary:hover { background: #1a68d1; color: #fff; }

.btn-exec-outline {
    background: transparent;
    color: #475569;
    font-size: 0.8rem;
    font-weight: 500;
    padding: 0.45rem 1rem;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}
.btn-exec-outline:hover { background: #f8fafc; color: #1e293b; border-color: #94a3b8; }

.badge-exec {
    padding: 0.35rem 0.6rem;
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}
.badge-exec.bg-emerald { background: #f0fdf4; color: #059669; }
.badge-exec.bg-rose { background: #fff1f2; color: #e11d48; }
.badge-exec.bg-slate { background: #f1f5f9; color: #475569; }
.badge-exec.bg-blue { background: #eff6ff; color: #2563eb; }
</style>
@endpush

@section('content')
<div class="exec-header">
    <div>
        <h5 class="exec-header-title">{{ $isAsistente ? 'Mis Accesos al Menú SOL' : 'Log de Accesos al Menú SOL' }}</h5>
        <div class="exec-header-subtitle">{{ $isAsistente ? 'Historial de tus conexiones y tiempo ahorrado' : 'Registro auditable de conexiones y métricas de automatización' }}</div>
    </div>
</div>

<div class="exec-panel">
    <div class="exec-panel-body" style="padding: 1rem 1.5rem;">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-3">
                <select name="empresa_id" class="form-select form-select-exec">
                    <option value="">Todas las empresas</option>
                    @foreach($companies as $c)
                    <option value="{{ $c->id }}" {{ request('empresa_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->ruc }} — {{ Str::limit($c->razon_social, 30) }}
                    </option>
                    @endforeach
                </select>
            </div>
            @unless($isAsistente)
            <div class="col-md-2">
                <select name="user_id" class="form-select form-select-exec">
                    <option value="">Todos los usuarios</option>
                    @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                        {{ $u->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endunless
            <div class="col-md-2">
                <select name="status" class="form-select form-select-exec">
                    <option value="">Todos los estados</option>
                    <option value="SUCCESS" {{ request('status') === 'SUCCESS' ? 'selected' : '' }}>Exitoso</option>
                    <option value="FAILED"  {{ request('status') === 'FAILED'  ? 'selected' : '' }}>Fallido</option>
                    <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>Pendiente</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="fecha_desde" class="form-control form-control-exec"
                    value="{{ request('fecha_desde') }}" title="Desde">
            </div>
            <div class="col-md-2">
                <input type="date" name="fecha_hasta" class="form-control form-control-exec"
                    value="{{ request('fecha_hasta') }}" title="Hasta">
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn-exec-primary"><i class="bi bi-funnel me-1"></i>Filtrar</button>
                <a href="{{ route('access-logs.index') }}" class="btn-exec-outline">Limpiar</a>
            </div>
        </form>
    </div>
</div>

<div class="exec-panel">
    <div class="exec-panel-header">
        <h6 class="exec-panel-title" style="font-size:0.8rem;"><i class="bi bi-journal-text me-2 text-primary"></i>Trazabilidad de Conexiones</h6>
        <span class="badge-exec bg-blue">{{ $logs->total() }} registros encontrados</span>
    </div>
    <div class="table-responsive">
        <table class="table table-exec mb-0">
            <thead>
                <tr>
                    <th style="width:50px;">ID</th>
                    <th>Timestamp (Fecha y Hora)</th>
                    <th>Operador</th>
                    <th>Entidad Corporativa</th>
                    <th>Estado</th>
                    <th>Tiempo Ejecución</th>
                    <th>Ahorro Estimado</th>
                    <th>Detalles / Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td style="font-size:0.75rem; color:#94a3b8; font-weight:600;">#{{ $log->id }}</td>
                    <td style="font-size:0.8rem; font-weight:500; color:#475569;">
                        {{ $log->accessed_at->format('d M Y, H:i:s') }}
                    </td>
                    <td>
                        <div style="font-size:0.8rem; font-weight:600; color:#1e293b;">{{ $log->user?->name ?? 'Sistema' }}</div>
                    </td>
                    <td>
                        <div style="font-size:0.8rem; font-weight:600; color:#334155;">{{ Str::limit($log->razon_social, 30) }}</div>
                        <div class="font-monospace text-muted" style="font-size:0.7rem;">RUC: {{ $log->ruc }}</div>
                    </td>
                    <td>
                        @if($log->status === 'SUCCESS')
                            <span class="badge-exec bg-emerald"><i class="bi bi-check-circle"></i> Exitoso</span>
                        @elseif($log->status === 'FAILED')
                            <span class="badge-exec bg-rose"><i class="bi bi-x-circle"></i> Fallido</span>
                        @else
                            <span class="badge-exec bg-slate">Pendiente</span>
                        @endif
                    </td>
                    <td>
                        @if($log->duration_seconds)
                            <span style="font-size:0.8rem; font-weight:600; color:#3b82f6;">{{ $log->duration_seconds }}s</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($log->duration_seconds)
                            @php $saved = 30 - $log->duration_seconds; @endphp
                            <span style="font-size:0.8rem; font-weight:600; color:{{ $saved > 0 ? '#059669' : '#e11d48' }};">
                                {{ $saved > 0 ? '+' : '' }}{{ number_format($saved, 1) }}s
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td style="font-size:0.75rem; color:#64748b;">
                        {{ Str::limit($log->error_message, 40) ?? 'Conexión estándar completada' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bi bi-inbox text-muted" style="font-size:2.5rem; opacity:0.4;"></i>
                        <div class="mt-2 text-muted" style="font-size:0.85rem; font-weight:500;">No se encontraron registros en la bitácora con estos criterios</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="px-4 py-3 border-top">{{ $logs->links() }}</div>
    @endif
</div>
@endsection
