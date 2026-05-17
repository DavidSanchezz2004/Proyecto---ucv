@extends('layouts.app')
@section('title', 'Resultados de Encuesta')
@section('page-title', 'Métricas de Usabilidad (Resultados)')

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
.exec-panel-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.03em;
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
.badge-exec.bg-emerald { background: #f0fdf4; color: #059669; }

.likert-score-box {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 0.15rem;
}
.likert-score-val {
    font-size: 1.1rem;
    font-weight: 800;
    font-family: 'Montserrat', sans-serif;
    letter-spacing: -0.02em;
}
.likert-score-max {
    font-size: 0.7rem;
    color: #94a3b8;
    font-weight: 600;
}

.table-likert-detail th {
    font-size: 0.65rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-align: center;
}
.table-likert-detail td {
    vertical-align: middle;
}
</style>
@endpush

@section('content')

<div class="exec-header">
    <div>
        <h5 class="exec-header-title">Resultados de Usabilidad (Escala Likert)</h5>
        <div class="exec-header-subtitle">Análisis cuantitativo de validación de investigación formativa</div>
    </div>
    <span class="badge-exec bg-blue" style="font-size:0.75rem;">
        <i class="bi bi-people-fill me-1"></i>Muestra Total: {{ $totalRespondents }} Participantes
    </span>
</div>

{{-- Resumen por dimensión --}}
<div class="exec-panel">
    <div class="exec-panel-header">
        <h6 class="exec-panel-title"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Evaluación Global por Dimensión</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-exec mb-0">
            <thead>
                <tr>
                    <th style="width:20%">Constructo Variable</th>
                    <th style="width:30%">Dimensión Evaluada</th>
                    <th class="text-center">Participación (N)</th>
                    <th class="text-center">Puntaje Promedio</th>
                    <th style="width:25%">Nivel de Satisfacción Estimado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($byDimension as $row)
                <tr>
                    <td>
                        <span class="badge-exec"
                            style="background:{{ $row->variable === 'Variable Independiente' ? '#eff6ff' : '#f0fdf4' }};
                                   color:{{ $row->variable === 'Variable Independiente' ? '#2563eb' : '#059669' }};">
                            {{ $row->variable }}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight:600; color:#1e293b; font-size:0.8rem;">{{ $row->dimension }}</div>
                    </td>
                    <td class="text-center">
                        <span style="font-size:0.8rem; font-weight:600; color:#475569;">{{ $row->respondents }}</span>
                    </td>
                    <td class="text-center">
                        <div class="likert-score-box">
                            <span class="likert-score-val" style="color: @if($row->avg_score >= 4) #059669 @elseif($row->avg_score >= 3) #d97706 @else #dc2626 @endif">
                                {{ $row->avg_score }}
                            </span>
                            <span class="likert-score-max">/ 5</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="flex-grow:1;height:6px;background:#e2e8f0;border-radius:3px;overflow:hidden;">
                                <div style="height:100%;border-radius:3px;width:{{ ($row->avg_score/5)*100 }}%;
                                    background:@if($row->avg_score >= 4) #10b981 @elseif($row->avg_score >= 3) #f59e0b @else #ef4444 @endif">
                                </div>
                            </div>
                            <span style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; min-width:80px; text-align:right;">
                                @if($row->avg_score >= 4.5) <span style="color:#059669">Excelente</span>
                                @elseif($row->avg_score >= 3.5) <span style="color:#10b981">Aceptable</span>
                                @elseif($row->avg_score >= 2.5) <span style="color:#f59e0b">Regular</span>
                                @elseif($row->avg_score >= 1.5) <span style="color:#ef4444">Deficiente</span>
                                @else <span style="color:#dc2626">Crítico</span> @endif
                            </span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Detalle por pregunta --}}
<div class="exec-panel">
    <div class="exec-panel-header">
        <h6 class="exec-panel-title"><i class="bi bi-list-ol me-2 text-secondary"></i>Análisis Desagregado por Ítem</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-exec table-likert-detail mb-0">
            <thead>
                <tr>
                    <th style="width:40px;">Ítem</th>
                    <th style="text-align:left;">Enunciado de la Pregunta</th>
                    <th class="text-center" title="Número de Respondentes">N</th>
                    <th class="text-center" style="background:#f8fafc; border-left:1px solid #e2e8f0;">Puntaje Global</th>
                    <th class="text-center" style="color:#dc2626;" title="Totalmente en Desacuerdo">TD (1)</th>
                    <th class="text-center" style="color:#f59e0b;" title="En Desacuerdo">D (2)</th>
                    <th class="text-center" style="color:#94a3b8;" title="Neutral">N (3)</th>
                    <th class="text-center" style="color:#3b82f6;" title="De Acuerdo">A (4)</th>
                    <th class="text-center" style="color:#059669;" title="Totalmente de Acuerdo">TA (5)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($byQuestion as $row)
                <tr>
                    <td style="font-size:0.7rem; font-weight:700; color:#94a3b8;">P{{ $row->order_number }}</td>
                    <td style="font-size:0.8rem; font-weight:500; color:#1e293b;">{{ Str::limit($row->question_text, 80) }}</td>
                    <td class="text-center" style="font-size:0.75rem; font-weight:600; color:#64748b;">{{ $row->total }}</td>
                    <td class="text-center" style="background:#f8fafc; border-left:1px solid #e2e8f0;">
                        <span style="font-size:0.9rem; font-weight:800; font-family:'Montserrat', sans-serif; color:{{ $row->avg_score >= 4 ? '#059669' : ($row->avg_score >= 3 ? '#d97706' : '#dc2626') }}">
                            {{ $row->avg_score }}
                        </span>
                    </td>
                    <td class="text-center" style="font-size:0.75rem; font-weight:600; color:#ef4444;">{{ $row->score_1 ?: '-' }}</td>
                    <td class="text-center" style="font-size:0.75rem; font-weight:600; color:#f59e0b;">{{ $row->score_2 ?: '-' }}</td>
                    <td class="text-center" style="font-size:0.75rem; font-weight:600; color:#94a3b8;">{{ $row->score_3 ?: '-' }}</td>
                    <td class="text-center" style="font-size:0.75rem; font-weight:600; color:#3b82f6;">{{ $row->score_4 ?: '-' }}</td>
                    <td class="text-center" style="font-size:0.75rem; font-weight:600; color:#10b981;">{{ $row->score_5 ?: '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 border-top" style="font-size:0.7rem; color:#94a3b8; font-weight:500;">
        <strong>Leyenda de Escala Likert:</strong> TD = Totalmente en desacuerdo (1) &nbsp;·&nbsp; D = En desacuerdo (2) &nbsp;·&nbsp; N = Neutral (3) &nbsp;·&nbsp; A = De acuerdo (4) &nbsp;·&nbsp; TA = Totalmente de acuerdo (5)
    </div>
</div>
@endsection
