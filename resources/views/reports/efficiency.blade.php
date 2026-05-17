@extends('layouts.app')
@section('title', 'Reporte de Eficiencia')
@section('page-title', 'Reporte de Eficiencia Operativa')

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
    padding: 1rem 1.5rem;
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

.exec-stat-card {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.2s;
}
.exec-stat-value {
    font-size: 2rem;
    font-weight: 800;
    font-family: 'Montserrat', sans-serif;
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin-bottom: 0.2rem;
}
.exec-stat-label { font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
.exec-stat-desc { font-size: 0.65rem; color: #94a3b8; margin-top: 0.2rem; }

.exec-alert-academic {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-left: 4px solid #3b82f6;
    border-radius: 6px;
    padding: 1rem;
    display: flex;
    gap: 1rem;
    align-items: center;
    margin-bottom: 1.5rem;
}

.comparison-box {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    border-radius: 8px;
    color: #fff;
    padding: 2rem;
    margin-bottom: 1.5rem;
}
.comp-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    padding: 1.5rem;
    text-align: center;
    height: 100%;
}
.comp-card.highlight-green {
    background: rgba(16, 185, 129, 0.1);
    border-color: rgba(16, 185, 129, 0.3);
}
.comp-card.highlight-amber {
    background: rgba(245, 158, 11, 0.1);
    border-color: rgba(245, 158, 11, 0.3);
}

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
.badge-exec.bg-blue { background: #eff6ff; color: #2563eb; }
</style>
@endpush

@section('content')

<div class="exec-header">
    <div>
        <h5 class="exec-header-title">{{ $isAsistente ? 'Mi Eficiencia Operativa' : 'Reporte de Eficiencia Operativa' }}</h5>
        <div class="exec-header-subtitle">{{ $isAsistente ? 'Tu tiempo ahorrado y rendimiento personal en el Menú SOL' : 'Análisis de rendimiento y métricas de optimización de procesos' }}</div>
    </div>
</div>

{{-- Contexto académico --}}
<div class="exec-alert-academic">
    <i class="bi bi-mortarboard-fill" style="font-size:1.5rem; color:#3b82f6;"></i>
    <div>
        <div style="font-size:0.8rem; font-weight:600; color:#1e293b; margin-bottom:0.2rem;">Parámetros de Investigación Formativa</div>
        <div style="font-size:0.75rem; color:#64748b;">
            <span style="font-weight:600; color:#475569;">Variable Dependiente:</span> Eficiencia Operativa &nbsp;|&nbsp;
            <span style="font-weight:600; color:#475569;">Dimensión:</span> Optimización del Tiempo &nbsp;|&nbsp;
            <span style="font-weight:600; color:#475569;">Indicador:</span> Reducción de tiempo de acceso al Menú SOL (segundos)
        </div>
    </div>
</div>

{{-- KPIs principales --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="exec-stat-card">
            <div class="exec-stat-value" style="color:#1e293b;">{{ $baseline }}s</div>
            <div class="exec-stat-label">Tiempo Manual Estimado</div>
            <div class="exec-stat-desc">Baseline de investigación</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="exec-stat-card" style="border-bottom: 3px solid #059669;">
            <div class="exec-stat-value" style="color:#059669;">{{ $avgSeconds }}s</div>
            <div class="exec-stat-label">Tiempo Automatizado</div>
            <div class="exec-stat-desc">Promedio medido en simulación</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="exec-stat-card" style="border-bottom: 3px solid #3b82f6;">
            <div class="exec-stat-value" style="color:#3b82f6;">{{ $efficiencyPct }}%</div>
            <div class="exec-stat-label">Reducción de Tiempo</div>
            <div class="exec-stat-desc">Eficiencia operativa ganada</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="exec-stat-card" style="border-bottom: 3px solid #d97706;">
            <div class="exec-stat-value" style="color:#d97706;">{{ number_format($totalSavedSeconds, 0) }}s</div>
            <div class="exec-stat-label">Tiempo Total Ahorrado</div>
            <div class="exec-stat-desc">{{ $totalAccesses }} accesos exitosos registrados</div>
        </div>
    </div>
</div>

{{-- Comparativa visual --}}
@if($totalAccesses > 0)
<div class="comparison-box">
    <h6 style="font-size:0.9rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#cbd5e1; margin-bottom:1.5rem;">
        <i class="bi bi-bar-chart-line me-2"></i>Comparativa: Acceso Manual vs. Automatizado
    </h6>
    <div class="row g-4 align-items-center">
        <div class="col-md-4">
            <div class="comp-card">
                <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; color:#94a3b8; margin-bottom:0.5rem;">Proceso Manual</div>
                <div style="font-size:3rem; font-weight:800; font-family:'Montserrat', sans-serif; line-height:1; margin-bottom:0.5rem; color:#f8fafc;">{{ $baseline }}s</div>
                <div style="font-size:0.7rem; color:#64748b;">Búsqueda URL + ingreso RUC + usuario + clave</div>
            </div>
        </div>
        <div class="col-md-2 text-center">
            <i class="bi bi-arrow-right text-primary" style="font-size:2rem; opacity:0.8;"></i>
            <div style="font-size:0.65rem; font-weight:600; color:#cbd5e1; text-transform:uppercase; letter-spacing:0.05em; margin-top:0.5rem;">Automatización</div>
        </div>
        <div class="col-md-3">
            <div class="comp-card highlight-green">
                <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; color:#34d399; margin-bottom:0.5rem;">Proceso Automatizado</div>
                <div style="font-size:3rem; font-weight:800; font-family:'Montserrat', sans-serif; line-height:1; margin-bottom:0.5rem; color:#10b981;">{{ $avgSeconds }}s</div>
                <div style="font-size:0.7rem; color:#a7f3d0;">Simulación de inyección segura</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="comp-card highlight-amber">
                <div style="font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; color:#fbbf24; margin-bottom:0.5rem;">Ahorro por Operación</div>
                <div style="font-size:3rem; font-weight:800; font-family:'Montserrat', sans-serif; line-height:1; margin-bottom:0.5rem; color:#f59e0b;">
                    {{ number_format($baseline - $avgSeconds, 1) }}s
                </div>
                <div style="font-size:0.7rem; color:#fde68a;">≈ {{ $efficiencyPct }}% más rápido</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Gráfico distribución --}}
    <div class="col-md-5">
        <div class="exec-panel h-100 mb-0">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title"><i class="bi bi-pie-chart me-2 text-primary"></i>Distribución de Tiempos</h6>
            </div>
            <div class="exec-panel-body" style="padding: 1.5rem;">
                <canvas id="distChart" height="200"></canvas>
            </div>
        </div>
    </div>
    {{-- Estadísticas --}}
    <div class="col-md-7">
        <div class="exec-panel h-100 mb-0">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title"><i class="bi bi-table me-2 text-success"></i>Métricas de Acceso Detalladas</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-exec mb-0" style="font-size:0.85rem;">
                    <tbody>
                        <tr>
                            <td class="text-muted font-weight-500 py-3" style="width:60%;">Total Accesos Exitosos</td>
                            <td class="text-end fw-bold py-3" style="color:#1e293b;">{{ $totalAccesses }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted font-weight-500 py-3">Total Accesos Fallidos</td>
                            <td class="text-end fw-bold py-3 text-danger">{{ $totalFailed }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted font-weight-500 py-3">Tiempo Mínimo Registrado</td>
                            <td class="text-end fw-bold py-3 text-success">{{ $minSeconds }}s</td>
                        </tr>
                        <tr>
                            <td class="text-muted font-weight-500 py-3">Tiempo Máximo Registrado</td>
                            <td class="text-end fw-bold py-3 text-warning">{{ $maxSeconds }}s</td>
                        </tr>
                        <tr>
                            <td class="text-muted font-weight-500 py-3">Tiempo Promedio Automatizado</td>
                            <td class="text-end fw-bold py-3" style="color:#1e293b;">{{ $avgSeconds }}s</td>
                        </tr>
                        <tr style="background:#f0fdf4;">
                            <td class="fw-bold py-3" style="color:#065f46;">Ahorro Promedio por Acceso</td>
                            <td class="text-end fw-bold py-3" style="color:#059669;">{{ number_format($baseline - $avgSeconds, 1) }}s</td>
                        </tr>
                        <tr style="background:#eff6ff; border-bottom:none;">
                            <td class="fw-bold py-3" style="color:#1e40af;">Tiempo Total Ahorrado</td>
                            <td class="text-end fw-bold py-3" style="color:#2563eb;">{{ number_format($totalSavedSeconds, 1) }}s <span class="text-muted" style="font-size:0.7rem;">(≈ {{ number_format($totalSavedSeconds/60, 1) }} min)</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Por empresa --}}
<div class="exec-panel">
    <div class="exec-panel-header">
        <h6 class="exec-panel-title"><i class="bi bi-building me-2 text-secondary"></i>Análisis de Eficiencia por Entidad</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-exec mb-0">
            <thead>
                <tr>
                    <th>RUC</th>
                    <th>Razón Social</th>
                    <th class="text-center">Volumen Accesos</th>
                    <th class="text-center">Promedio (Auto)</th>
                    <th class="text-center">Estimado Manual</th>
                    <th class="text-center">Ahorro Neto</th>
                    <th style="width:20%;">Nivel de Eficiencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach($byCompany as $row)
                <tr>
                    <td><span class="font-monospace fw-semibold" style="color:#475569; font-size:0.8rem;">{{ $row->ruc }}</span></td>
                    <td>
                        <div style="font-weight:600; color:#1e293b; font-size:0.8rem;">{{ Str::limit($row->razon_social, 35) }}</div>
                    </td>
                    <td class="text-center"><span class="badge-exec bg-blue">{{ $row->total_accesses }}</span></td>
                    <td class="text-center fw-bold" style="color:#3b82f6; font-size:0.8rem;">{{ $row->avg_seconds }}s</td>
                    <td class="text-center text-muted" style="font-size:0.8rem; font-weight:500;">
                        {{ $row->total_accesses * $baseline }}s
                    </td>
                    <td class="text-center fw-bold" style="color:#059669; font-size:0.8rem;">+{{ $row->total_saved }}s</td>
                    <td>
                        @php $pct = $baseline > 0 ? round((($baseline - $row->avg_seconds) / $baseline) * 100, 0) : 0; @endphp
                        <div class="d-flex align-items-center gap-2">
                            <div style="flex-grow:1; height:6px; background:#e2e8f0; border-radius:3px; overflow:hidden;">
                                <div style="height:100%; background:#10b981; border-radius:3px; width:{{ min(100, $pct) }}%;"></div>
                            </div>
                            <span style="font-size:0.75rem; font-weight:700; color:#059669;">{{ $pct }}%</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($byCompany->hasPages())
    <div class="px-4 py-3 border-top">{{ $byCompany->links() }}</div>
    @endif
</div>

@else
<div class="exec-panel p-5 text-center">
    <i class="bi bi-graph-up text-muted" style="font-size:4rem; opacity:0.2; margin-bottom:1rem; display:block;"></i>
    <h5 style="font-weight:700; color:#1e293b;">Métricas No Disponibles</h5>
    <p class="text-muted" style="font-size:0.85rem; max-width:400px; margin:0 auto 1.5rem auto;">
        Aún no existen registros de simulación en la bitácora. Ejecute procesos de conexión al Menú SOL para que el motor genere la data analítica correspondiente.
    </p>
    <a href="{{ route('companies.index') }}" class="btn btn-primary" style="font-size:0.85rem; font-weight:600; padding:0.6rem 1.5rem;">
        <i class="bi bi-building me-2"></i>Ir al Directorio de Empresas
    </a>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
@if($distribution->count() > 0)
const ctx = document.getElementById('distChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: @json($distribution->pluck('rango')),
        datasets: [{
            data: @json($distribution->pluck('total')),
            backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6'],
            borderWidth: 2, borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { font: { size: 11, family: "'Montserrat', sans-serif" } } }
        }
    }
});
@endif
</script>
@endpush
