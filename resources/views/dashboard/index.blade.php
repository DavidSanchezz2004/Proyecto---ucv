@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Overview Ejecutivo')

@push('styles')
<style>
/* Executive Dashboard Styles */
.stat-card {
    background: #fff;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    height: 100%;
    transition: all 0.2s ease;
}
.stat-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    border-color: #cbd5e1;
}
.stat-icon {
    width: 40px; 
    height: 40px;
    border-radius: 6px;
    display: flex; 
    align-items: center; 
    justify-content: center;
    font-size: 1.1rem;
    margin-bottom: 1rem;
}
.icon-slate { background: #f1f5f9; color: #475569; }
.icon-blue { background: #eff6ff; color: #2563eb; }
.icon-emerald { background: #f0fdf4; color: #059669; }

.stat-value { 
    font-size: 1.6rem; 
    font-weight: 700; 
    color: #1e293b;
    line-height: 1.2;
    margin-bottom: 0.25rem;
}
.stat-label { 
    font-size: 0.75rem; 
    color: #64748b;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

/* Executive Banner */
.efficiency-banner {
    background: #0f172a; /* Slate 900 */
    border-radius: 8px;
    padding: 1.5rem 2rem;
    color: #fff;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}
.efficiency-banner::before {
    content: '';
    position: absolute;
    top: 0; right: 0; bottom: 0; width: 40%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.03));
    pointer-events: none;
}
.eb-title { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: #94a3b8; font-weight: 600; margin-bottom: 0.3rem; }
.eb-heading { font-size: 1.1rem; font-weight: 600; color: #f8fafc; }

.eb-stat-box {
    text-align: right;
    padding-left: 2rem;
    border-left: 1px solid rgba(255,255,255,0.1);
}
.eb-stat-value { font-size: 1.7rem; font-weight: 700; font-family: 'Montserrat', sans-serif; }
.eb-stat-label { font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.2rem; }

/* Panels */
.exec-panel {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    height: 100%;
}
.exec-panel-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.exec-panel-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
.exec-panel-body { padding: 1.5rem; }

/* Tables & Lists */
.exec-list-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.8rem 0;
    border-bottom: 1px solid #f1f5f9;
}
.exec-list-item:last-child { border-bottom: none; }
.exec-list-icon {
    width: 32px; height: 32px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    color: #64748b;
    font-size: 0.9rem;
}
.exec-list-title { font-size: 0.85rem; font-weight: 600; color: #334155; }
.exec-list-subtitle { font-size: 0.75rem; color: #64748b; margin-top: 0.1rem; }

.table-exec th {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    font-weight: 600;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
}
.table-exec td {
    font-size: 0.85rem;
    color: #334155;
    padding: 0.85rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
</style>
@endpush

@section('content')

{{-- Bienvenida personalizada (solo asistente) --}}
@if($isAsistente)
<div style="background:linear-gradient(135deg,#1e293b 0%,#0f172a 100%);border-radius:10px;padding:1.5rem 2rem;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
    <div>
        <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;color:#64748b;font-weight:600;margin-bottom:0.3rem;">Panel Personal</div>
        <div style="font-size:1.2rem;font-weight:700;color:#f8fafc;">Bienvenido, {{ explode(' ', auth()->user()->name)[0] }}</div>
        <div style="font-size:0.8rem;color:#64748b;margin-top:0.2rem;">{{ now()->format('l, d \d\e F \d\e Y') }}</div>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('companies.create') }}" style="background:rgba(59,130,246,0.15);border:1px solid rgba(59,130,246,0.3);color:#60a5fa;font-size:0.78rem;font-weight:600;padding:0.5rem 1rem;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;transition:all .2s;">
            <i class="bi bi-plus-lg"></i> Nueva Empresa
        </a>
        <a href="{{ route('access-logs.index') }}" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:#94a3b8;font-size:0.78rem;font-weight:600;padding:0.5rem 1rem;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="bi bi-clock-history"></i> Mis Accesos
        </a>
        <a href="{{ route('reports.efficiency') }}" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:#94a3b8;font-size:0.78rem;font-weight:600;padding:0.5rem 1rem;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="bi bi-graph-up-arrow"></i> Mi Eficiencia
        </a>
        @unless($surveyDone)
        <a href="{{ route('survey.index') }}" style="background:rgba(245,158,11,0.15);border:1px solid rgba(245,158,11,0.3);color:#fbbf24;font-size:0.78rem;font-weight:600;padding:0.5rem 1rem;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;">
            <i class="bi bi-clipboard2-check"></i> Completar Encuesta
        </a>
        @endunless
    </div>
</div>
@endif

{{-- Eficiencia Banner --}}
@if($accessesTotal > 0)
<div class="efficiency-banner mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-4">
        <div>
            <div class="eb-title">Análisis de Eficiencia Operativa</div>
            <div class="eb-heading">Métricas de Automatización Menú SOL</div>
        </div>
        <div class="d-flex flex-wrap gap-4 align-items-center">
            <div class="eb-stat-box" style="border-left:none;">
                <div class="eb-stat-value text-white">{{ $baseline }}s</div>
                <div class="eb-stat-label">Manual (Est.)</div>
            </div>
            <div class="text-center opacity-50">
                <i class="bi bi-chevron-right"></i>
            </div>
            <div class="eb-stat-box">
                <div class="eb-stat-value" style="color: #60a5fa;">{{ number_format($avgSeconds, 1) }}s</div>
                <div class="eb-stat-label">Automático</div>
            </div>
            <div class="eb-stat-box">
                <div class="eb-stat-value" style="color: #34d399;">
                    +{{ $avgSeconds > 0 ? number_format((($baseline - $avgSeconds) / $baseline) * 100, 0) : 0 }}%
                </div>
                <div class="eb-stat-label">Mejora Neta</div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- KPI Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-slate"><i class="bi bi-buildings"></i></div>
            <div class="stat-value">{{ $totalCompanies }}</div>
            <div class="stat-label">Empresas</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="bi bi-shield-lock"></i></div>
            <div class="stat-value">{{ $companiesWithCreds }}</div>
            <div class="stat-label">Credenciales Activas</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-slate"><i class="bi bi-calendar2-day"></i></div>
            <div class="stat-value">{{ $accessesToday }}</div>
            <div class="stat-label">Accesos Hoy</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-emerald"><i class="bi bi-check-circle"></i></div>
            <div class="stat-value">{{ $accessesTotal }}</div>
            <div class="stat-label">Éxitos Totales</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="bi bi-stopwatch"></i></div>
            <div class="stat-value">{{ number_format($avgSeconds, 1) }}s</div>
            <div class="stat-label">T. Promedio</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon icon-emerald"><i class="bi bi-lightning"></i></div>
            <div class="stat-value">{{ number_format($totalSaved, 0) }}s</div>
            <div class="stat-label">Tiempo Ahorrado</div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Gráfico de accesos --}}
    <div class="col-md-7">
        <div class="exec-panel">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title">Volumen de Accesos (7 Días)</h6>
                <i class="bi bi-bar-chart-line text-muted"></i>
            </div>
            <div class="exec-panel-body p-4">
                <canvas id="accessChart" height="100"></canvas>
            </div>
        </div>
    </div>

    {{-- Últimos accesos SOL --}}
    <div class="col-md-5">
        <div class="exec-panel">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title">Registro Reciente</h6>
                <a href="{{ route('access-logs.index') }}" class="text-decoration-none" style="font-size:0.75rem; font-weight:600;">Ver todos</a>
            </div>
            <div class="exec-panel-body p-3">
                @forelse($recentAccesses as $log)
                <div class="exec-list-item">
                    <div class="exec-list-icon">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="exec-list-title text-truncate">{{ $log->razon_social }}</div>
                        <div class="exec-list-subtitle">{{ $log->user?->name }} • {{ $log->accessed_at->format('d/m Y, H:i') }}</div>
                    </div>
                    <div class="text-end">
                        <span style="font-size:0.75rem; font-weight:600; color:#059669; background:#f0fdf4; padding:0.2rem 0.6rem; border-radius:4px;">
                            {{ $log->duration_seconds }}s
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                    <div class="mt-2 text-muted" style="font-size:0.85rem;">No hay registros disponibles</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Actividad reciente: solo admin/supervisor --}}
    @unless($isAsistente)
    <div class="col-12">
        <div class="exec-panel mt-2">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title">Auditoría de Sistema</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-exec mb-0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Operador</th>
                            <th>Evento</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentActivity as $log)
                        <tr>
                            <td style="color:#64748b; font-weight:500;">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td style="font-weight:500;">{{ $log->user?->name ?? 'Sistema' }}</td>
                            <td>
                                <span style="font-size:0.7rem; font-weight:600; text-transform:uppercase; padding:0.25rem 0.5rem; border-radius:4px; 
                                    background: {{ str_contains($log->action,'login') ? '#f1f5f9' : (str_contains($log->action,'sol') ? '#fef2f2' : '#f0fdf4') }};
                                    color: {{ str_contains($log->action,'login') ? '#475569' : (str_contains($log->action,'sol') ? '#dc2626' : '#059669') }};">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td style="color:#64748b;">{{ Str::limit($log->description, 70) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Sin actividad reciente</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endunless
</div>

{{-- Sección adicional asistente --}}
@if($isAsistente)
<div class="row g-3 mt-1">

    {{-- Mis Empresas --}}
    <div class="col-md-7">
        <div class="exec-panel" style="height:auto;">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title"><i class="bi bi-buildings me-2 text-primary"></i>Mis Empresas</h6>
                <a href="{{ route('companies.index') }}" style="font-size:0.75rem;font-weight:600;text-decoration:none;color:#2c7be5;">Ver todas</a>
            </div>
            @forelse($myCompanies as $c)
            <div style="display:flex;align-items:center;gap:1rem;padding:0.85rem 1.5rem;border-bottom:1px solid #f1f5f9;">
                <div style="width:34px;height:34px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-building" style="color:#64748b;font-size:0.95rem;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:0.85rem;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $c->razon_social }}</div>
                    <div style="font-size:0.7rem;color:#64748b;font-family:monospace;">RUC {{ $c->ruc }}</div>
                </div>
                <div style="display:flex;align-items:center;gap:0.5rem;flex-shrink:0;">
                    @if($c->solCredential)
                        <span style="font-size:0.65rem;font-weight:600;background:#f0fdf4;color:#059669;padding:0.2rem 0.55rem;border-radius:4px;"><i class="bi bi-shield-check me-1"></i>SOL</span>
                    @else
                        <span style="font-size:0.65rem;font-weight:600;background:#f1f5f9;color:#94a3b8;padding:0.2rem 0.55rem;border-radius:4px;"><i class="bi bi-shield-x me-1"></i>Sin credencial</span>
                    @endif
                    <span style="font-size:0.65rem;font-weight:600;padding:0.2rem 0.55rem;border-radius:4px;
                        {{ $c->estado === 'ACTIVO' ? 'background:#f0fdf4;color:#059669;' : 'background:#fff1f2;color:#e11d48;' }}">
                        {{ $c->estado }}
                    </span>
                    <a href="{{ route('companies.show', $c) }}" style="width:26px;height:26px;display:inline-flex;align-items:center;justify-content:center;border-radius:5px;background:#f8fafc;border:1px solid #e2e8f0;color:#64748b;font-size:0.8rem;text-decoration:none;">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:2.5rem 1rem;color:#94a3b8;">
                <i class="bi bi-building-add" style="font-size:2rem;display:block;margin-bottom:0.75rem;opacity:0.4;"></i>
                <div style="font-size:0.85rem;font-weight:500;">Aún no tienes empresas registradas</div>
                <a href="{{ route('companies.create') }}" style="font-size:0.8rem;color:#2c7be5;font-weight:600;text-decoration:none;margin-top:0.5rem;display:inline-block;">+ Registrar primera empresa</a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Panel derecho --}}
    <div class="col-md-5 d-flex flex-column gap-3">

        {{-- Mejor tiempo personal --}}
        @if($accessesTotal > 0)
        <div class="exec-panel" style="height:auto;padding:1.5rem;">
            <div style="font-size:0.65rem;text-transform:uppercase;letter-spacing:0.08em;color:#64748b;font-weight:700;margin-bottom:1rem;">Mis Estadísticas</div>
            <div class="row g-3 text-center">
                <div class="col-4">
                    <div style="font-size:1.5rem;font-weight:800;color:#2c7be5;line-height:1.1;">{{ $accessesTotal }}</div>
                    <div style="font-size:0.65rem;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;">Accesos</div>
                </div>
                <div class="col-4">
                    <div style="font-size:1.5rem;font-weight:800;color:#059669;line-height:1.1;">{{ $bestSeconds }}s</div>
                    <div style="font-size:0.65rem;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;">Mejor Tiempo</div>
                </div>
                <div class="col-4">
                    <div style="font-size:1.5rem;font-weight:800;color:#d97706;line-height:1.1;">{{ number_format($totalSaved, 0) }}s</div>
                    <div style="font-size:0.65rem;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;">Ahorrado</div>
                </div>
            </div>
            <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid #f1f5f9;display:flex;align-items:center;gap:0.5rem;">
                <div style="flex:1;height:6px;background:#e2e8f0;border-radius:3px;overflow:hidden;">
                    <div style="height:100%;background:linear-gradient(90deg,#3b82f6,#10b981);border-radius:3px;width:{{ $avgSeconds > 0 ? min(100, round((($baseline - $avgSeconds)/$baseline)*100)) : 0 }}%;"></div>
                </div>
                <span style="font-size:0.75rem;font-weight:700;color:#059669;">{{ $avgSeconds > 0 ? round((($baseline - $avgSeconds)/$baseline)*100) : 0 }}% eficiencia</span>
            </div>
        </div>
        @endif

        {{-- Encuesta Likert --}}
        <div class="exec-panel" style="height:auto;padding:1.5rem;">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                <div style="width:36px;height:36px;border-radius:8px;background:{{ $surveyDone ? '#f0fdf4' : '#fffbeb' }};display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-clipboard2-{{ $surveyDone ? 'check-fill' : 'data' }}" style="font-size:1.1rem;color:{{ $surveyDone ? '#059669' : '#d97706' }};"></i>
                </div>
                <div>
                    <div style="font-size:0.85rem;font-weight:700;color:#1e293b;">Encuesta de Investigación</div>
                    <div style="font-size:0.7rem;color:#64748b;">Piloto Likert — {{ $surveyTotal }} preguntas</div>
                </div>
            </div>

            {{-- Barra de progreso --}}
            <div style="margin-bottom:1rem;">
                <div style="display:flex;justify-content:space-between;font-size:0.7rem;font-weight:600;color:#64748b;margin-bottom:0.4rem;">
                    <span>Progreso</span>
                    <span>{{ $surveyAnswered }} / {{ $surveyTotal }}</span>
                </div>
                <div style="height:8px;background:#e2e8f0;border-radius:4px;overflow:hidden;">
                    <div style="height:100%;background:{{ $surveyDone ? '#059669' : '#f59e0b' }};border-radius:4px;width:{{ $surveyTotal > 0 ? round(($surveyAnswered/$surveyTotal)*100) : 0 }}%;transition:width .4s;"></div>
                </div>
            </div>

            @if($surveyDone)
                <div style="font-size:0.8rem;color:#059669;font-weight:600;text-align:center;padding:0.5rem;background:#f0fdf4;border-radius:6px;">
                    <i class="bi bi-check-circle-fill me-1"></i>Encuesta completada. ¡Gracias!
                </div>
            @else
                <a href="{{ route('survey.index') }}" style="display:block;text-align:center;background:#f59e0b;color:#fff;font-size:0.82rem;font-weight:700;padding:0.6rem 1rem;border-radius:6px;text-decoration:none;transition:all .2s;">
                    {{ $surveyAnswered > 0 ? 'Continuar Encuesta' : 'Iniciar Encuesta' }}
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            @endif
        </div>

    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('accessChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Accesos Registrados',
            data: @json($values),
            backgroundColor: '#2c7be5', /* Corporate Blue */
            borderRadius: 4,
            barThickness: 16
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { 
                backgroundColor: '#1e293b',
                padding: 10,
                titleFont: { family: 'Montserrat', size: 12 },
                bodyFont: { family: 'Montserrat', size: 12 },
                callbacks: { label: ctx => ` ${ctx.parsed.y} accesos` } 
            }
        },
        scales: {
            y: { 
                beginAtZero: true, 
                ticks: { stepSize: 1, font: { family: 'Montserrat', size: 10 }, color: '#94a3b8' }, 
                border: { display: false },
                grid: { color: '#f1f5f9' } 
            },
            x: { 
                ticks: { font: { family: 'Montserrat', size: 10 }, color: '#64748b' }, 
                grid: { display: false },
                border: { display: false }
            }
        }
    }
});
</script>
@endpush
