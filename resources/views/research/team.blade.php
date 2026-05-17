@extends('layouts.app')
@section('title', 'Equipo de investigación')
@section('page-title', 'Equipo de investigación')

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

/* Intro card */
.intro-card {
    background: #fff;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    border-left: 4px solid #3b82f6;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.75rem;
    font-size: 0.85rem;
    color: #475569;
    line-height: 1.75;
}

/* Member card */
.member-card {
    background: #fff;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    padding: 1.5rem;
    height: 100%;
    transition: box-shadow 0.2s, border-color 0.2s;
}
.member-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.07);
    border-color: #cbd5e1;
}

.member-avatar {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    font-weight: 700;
    font-family: 'Montserrat', sans-serif;
    flex-shrink: 0;
    margin-bottom: 1rem;
}

.member-name {
    font-size: 0.92rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.3;
    margin-bottom: 0.25rem;
}
.member-index {
    font-size: 0.65rem;
    font-weight: 700;
    color: #94a3b8;
    letter-spacing: 0.05em;
    margin-bottom: 0.75rem;
}

.member-divider {
    border: none;
    border-top: 1px solid #f1f5f9;
    margin: 0.75rem 0;
}

.member-detail {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: #475569;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}
.member-detail:last-child { margin-bottom: 0; }
.member-detail i {
    font-size: 0.85rem;
    margin-top: 1px;
    flex-shrink: 0;
}

.orcid-link {
    color: #16a34a;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    word-break: break-all;
}
.orcid-link:hover { text-decoration: underline; color: #15803d; }

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

/* Section title */
.section-label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #94a3b8;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.section-label::after {
    content: '';
    flex: 1;
    border-top: 1px solid #e2e8f0;
}
</style>
@endpush

@section('content')

<div class="research-header">
    <div>
        <h5 class="research-header-title">Equipo de investigación</h5>
        <div class="research-header-sub">Integrantes del Trabajo de Investigación Formativa Nivel II</div>
    </div>
    <div class="ucv-badge">
        <i class="bi bi-mortarboard-fill"></i>
        UCV · Lima · 2026
    </div>
</div>

{{-- Texto introductorio --}}
<div class="intro-card">
    <i class="bi bi-info-circle-fill me-2" style="color:#3b82f6;"></i>
    El equipo de investigación estuvo conformado por estudiantes de distintas escuelas profesionales de la Universidad César Vallejo. Cada integrante participó en el desarrollo del Trabajo de Investigación Formativa Nivel II, orientado al análisis de la automatización del acceso al Menú SOL y su relación con la eficiencia operativa en asistentes contables de Lima.
</div>

<div class="section-label"><i class="bi bi-people-fill"></i> Integrantes del equipo</div>

@php
$members = [
    [
        'index'   => '01',
        'name'    => 'Campoverde Salas, Natali Guisella',
        'career'  => 'Educación Primaria',
        'cycle'   => 'IV',
        'email'   => 'ncampoverdes@ucvirtual.edu.pe',
        'orcid'   => null,
        'color'   => '#3b82f6',
        'bg'      => '#eff6ff',
        'initials'=> 'NC',
    ],
    [
        'index'   => '02',
        'name'    => 'Leon Hernandez, Rosa Milagros',
        'career'  => 'Educación Primaria',
        'cycle'   => 'IV',
        'email'   => 'rleonher@ucvvirtual.edu.pe',
        'orcid'   => 'https://orcid.org/0009-0009-1461-4656',
        'color'   => '#8b5cf6',
        'bg'      => '#f5f3ff',
        'initials'=> 'RL',
    ],
    [
        'index'   => '03',
        'name'    => 'Rojas Quiquinlla, Yesila',
        'career'  => 'Ingeniería Mecánica Eléctrica',
        'cycle'   => null,
        'email'   => null,
        'orcid'   => null,
        'color'   => '#10b981',
        'bg'      => '#ecfdf5',
        'initials'=> 'RQ',
    ],
    [
        'index'   => '04',
        'name'    => 'Sanchez Quicaño, David Aaron',
        'career'  => 'Ingeniería de Sistemas',
        'cycle'   => 'VIII',
        'email'   => 'dasanchezqu24@ucvvirtual.edu.pe',
        'orcid'   => 'https://orcid.org/0009-0004-2966-1408',
        'color'   => '#dc2626',
        'bg'      => '#fef2f2',
        'initials'=> 'DS',
    ],
    [
        'index'   => '05',
        'name'    => 'Seguin Shepherd, Milagros Brigitte',
        'career'  => 'Administración de Empresas',
        'cycle'   => null,
        'email'   => null,
        'orcid'   => null,
        'color'   => '#f59e0b',
        'bg'      => '#fffbeb',
        'initials'=> 'SS',
    ],
];
@endphp

<div class="row g-4">
    @foreach($members as $m)
    <div class="col-md-6 col-lg-4">
        <div class="member-card">
            <div class="member-avatar" style="background:{{ $m['bg'] }}; color:{{ $m['color'] }};">
                {{ $m['initials'] }}
            </div>
            <div class="member-index">Integrante {{ $m['index'] }}</div>
            <div class="member-name">{{ $m['name'] }}</div>

            <hr class="member-divider">

            <div class="member-detail">
                <i class="bi bi-building" style="color:#64748b;"></i>
                <span>{{ $m['career'] }}</span>
            </div>

            @if($m['cycle'])
            <div class="member-detail">
                <i class="bi bi-journal-bookmark" style="color:#64748b;"></i>
                <span>Ciclo {{ $m['cycle'] }}</span>
            </div>
            @endif

            @if($m['email'])
            <div class="member-detail">
                <i class="bi bi-envelope" style="color:#3b82f6;"></i>
                <span style="word-break:break-all;">{{ $m['email'] }}</span>
            </div>
            @endif

            @if($m['orcid'])
            <div class="member-detail">
                <i class="bi bi-patch-check-fill" style="color:#16a34a;"></i>
                <a href="{{ $m['orcid'] }}" target="_blank" rel="noopener" class="orcid-link">
                    ORCID <i class="bi bi-box-arrow-up-right" style="font-size:0.65rem;"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>

@endsection
