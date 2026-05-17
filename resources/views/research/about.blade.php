@extends('layouts.app')
@section('title', 'Sobre el estudio')
@section('page-title', 'Sobre el estudio')

@push('styles')
<style>
.research-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 1.75rem;
    flex-wrap: wrap;
    gap: 1rem;
}
.research-header-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    letter-spacing: -0.02em;
    margin: 0 0 0.25rem;
}
.research-header-sub {
    font-size: 0.8rem;
    color: #64748b;
    font-weight: 500;
}

/* Cards */
.r-card {
    background: #fff;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    padding: 1.5rem;
    margin-bottom: 1.25rem;
}
.r-card-accent-blue  { border-left: 4px solid #3b82f6; }
.r-card-accent-red   { border-left: 4px solid #dc2626; }
.r-card-accent-amber { border-left: 4px solid #f59e0b; }
.r-card-accent-slate { border-left: 4px solid #475569; }

.r-card-label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.r-card-label.blue  { color: #3b82f6; }
.r-card-label.red   { color: #dc2626; }
.r-card-label.amber { color: #d97706; }
.r-card-label.slate { color: #475569; }

.r-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.4;
    margin-bottom: 0.75rem;
}
.r-body {
    font-size: 0.85rem;
    color: #475569;
    line-height: 1.75;
}
.r-body p { margin-bottom: 0.85rem; }
.r-body p:last-child { margin-bottom: 0; }

/* Objetivo destacado */
.objective-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #1e293b 100%);
    border-radius: 10px;
    padding: 1.75rem;
    margin-bottom: 1.25rem;
    position: relative;
    overflow: hidden;
}
.objective-card::before {
    content: '';
    position: absolute;
    top: -30px; right: -30px;
    width: 120px; height: 120px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
}
.objective-card::after {
    content: '';
    position: absolute;
    bottom: -20px; left: 40%;
    width: 80px; height: 80px;
    background: rgba(255,255,255,0.03);
    border-radius: 50%;
}

/* Variables */
.variable-card {
    background: #fff;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 1.25rem;
    height: 100%;
}
.variable-card.vi { border-top: 3px solid #3b82f6; }
.variable-card.vd { border-top: 3px solid #dc2626; }

.variable-type {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 0.35rem;
}
.variable-type.vi { color: #3b82f6; }
.variable-type.vd { color: #dc2626; }

.variable-name {
    font-size: 0.9rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.85rem;
    line-height: 1.3;
}

.dim-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.3rem 0.65rem;
    border-radius: 20px;
    margin: 0.2rem;
}
.dim-badge.vi { background: #eff6ff; color: #1d4ed8; }
.dim-badge.vd { background: #fef2f2; color: #b91c1c; }

/* Metodología */
.method-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.4rem 0.9rem;
    border-radius: 6px;
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #e2e8f0;
    margin: 0.25rem;
}

/* Alert ético */
.ethics-card {
    background: #fffbeb;
    border-radius: 10px;
    border: 1px solid #fde68a;
    border-left: 4px solid #f59e0b;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.25rem;
}

/* UCV badge */
.ucv-badge {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 6px;
    padding: 0.4rem 0.85rem;
    font-size: 0.72rem;
    font-weight: 700;
    color: #dc2626;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    white-space: nowrap;
}
</style>
@endpush

@section('content')

<div class="research-header">
    <div>
        <h5 class="research-header-title">Sobre el estudio</h5>
        <div class="research-header-sub">Información general del prototipo académico SOL-Access</div>
    </div>
    <div class="ucv-badge">
        <i class="bi bi-mortarboard-fill"></i>
        UCV · Investigación Formativa Nivel II · 2026
    </div>
</div>

{{-- Título y descripción --}}
<div class="r-card r-card-accent-blue">
    <div class="r-card-label blue"><i class="bi bi-file-earmark-text"></i> Título del trabajo de investigación</div>
    <div class="r-title">
        Relación entre la automatización del acceso al Menú SOL y la eficiencia operativa en asistentes contables de Lima, 2026
    </div>
    <div class="r-body">
        <p>
            Este prototipo académico fue desarrollado como parte del Trabajo de Investigación Formativa Nivel II de la Universidad César Vallejo. El estudio buscó analizar la relación entre la automatización del acceso al Menú SOL y la eficiencia operativa en asistentes contables de Lima.
        </p>
        <p>
            La propuesta partió de una situación frecuente en empresas de servicios contables: el ingreso manual al Menú SOL de SUNAT requiere buscar credenciales, copiar datos, validar el acceso y ubicar el módulo correspondiente. Cuando este proceso se repite varias veces durante la jornada laboral, puede generar demoras, errores de digitación e interrupciones en el trabajo contable.
        </p>
        <p>
            El sistema representa una alternativa de acceso automatizado, con el fin de reducir pasos manuales, facilitar el inicio de sesión y mejorar la experiencia del usuario. Asimismo, el prototipo sirve como apoyo para recoger información mediante una encuesta tipo Likert dirigida a asistentes contables.
        </p>
    </div>
</div>

{{-- Objetivo general --}}
<div class="objective-card">
    <div style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#93c5fd; margin-bottom:0.5rem; display:flex; align-items:center; gap:0.4rem;">
        <i class="bi bi-bullseye"></i> Objetivo general
    </div>
    <div style="font-size:1rem; font-weight:700; color:#f8fafc; line-height:1.5; position:relative; z-index:1;">
        Determinar la relación entre la automatización del acceso al Menú SOL y la eficiencia operativa en asistentes contables de Lima, 2026.
    </div>
</div>

{{-- Variables --}}
<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="variable-card vi">
            <div class="variable-type vi"><i class="bi bi-arrow-right-circle-fill me-1"></i>Variable independiente</div>
            <div class="variable-name">Automatización del acceso al Menú SOL</div>
            <div style="font-size:0.72rem; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:0.5rem;">Dimensiones</div>
            <div>
                <span class="dim-badge vi"><i class="bi bi-check2"></i> Reducción de pasos manuales</span>
                <span class="dim-badge vi"><i class="bi bi-check2"></i> Automatización del inicio de sesión</span>
                <span class="dim-badge vi"><i class="bi bi-check2"></i> Facilidad de uso</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="variable-card vd">
            <div class="variable-type vd"><i class="bi bi-arrow-left-circle-fill me-1"></i>Variable dependiente</div>
            <div class="variable-name">Eficiencia operativa</div>
            <div style="font-size:0.72rem; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:0.5rem;">Dimensiones</div>
            <div>
                <span class="dim-badge vd"><i class="bi bi-check2"></i> Optimización del tiempo</span>
                <span class="dim-badge vd"><i class="bi bi-check2"></i> Disminución de errores</span>
                <span class="dim-badge vd"><i class="bi bi-check2"></i> Capacidad de respuesta operativa</span>
            </div>
        </div>
    </div>
</div>

{{-- Enfoque metodológico --}}
<div class="r-card r-card-accent-slate">
    <div class="r-card-label slate"><i class="bi bi-diagram-3"></i> Enfoque metodológico</div>
    <div class="mb-1">
        <span class="method-badge"><i class="bi bi-bar-chart-line" style="color:#3b82f6;"></i> Cuantitativo</span>
        <span class="method-badge"><i class="bi bi-gear" style="color:#7c3aed;"></i> Tipo aplicada</span>
        <span class="method-badge"><i class="bi bi-eye-slash" style="color:#0891b2;"></i> No experimental</span>
        <span class="method-badge"><i class="bi bi-link-45deg" style="color:#059669;"></i> Correlacional</span>
        <span class="method-badge"><i class="bi bi-calendar-check" style="color:#d97706;"></i> Corte transversal</span>
        <span class="method-badge"><i class="bi bi-people" style="color:#dc2626;"></i> Muestra piloto ≈ 20 asistentes contables</span>
        <span class="method-badge"><i class="bi bi-clipboard2-data" style="color:#475569;"></i> Escala Likert de 5 puntos</span>
    </div>
</div>

{{-- Aviso ético --}}
<div class="ethics-card">
    <div style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#92400e; margin-bottom:0.5rem; display:flex; align-items:center; gap:0.4rem;">
        <i class="bi bi-shield-check-fill"></i> Aviso académico y ético
    </div>
    <div style="font-size:0.83rem; color:#78350f; line-height:1.75;">
        Este sistema fue elaborado con fines académicos y de investigación formativa. El uso de credenciales reales requiere autorización expresa del titular o responsable correspondiente. La información recolectada mediante el prototipo y la encuesta se utiliza únicamente para fines del estudio, respetando la confidencialidad de los participantes y evitando exponer datos sensibles de contribuyentes o empresas.
    </div>
</div>

@endsection
