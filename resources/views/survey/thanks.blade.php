@extends('layouts.app')
@section('title', 'Encuesta Completada')
@section('page-title', 'Encuesta Piloto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <div style="width:80px;height:80px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem">
                    <i class="bi bi-check-circle-fill text-success" style="font-size:40px"></i>
                </div>
                <h4 class="fw-bold mb-2">¡Gracias por tu participación!</h4>
                <p class="text-muted mb-3" style="font-size:14px">
                    Tus respuestas han sido registradas correctamente y contribuyen
                    a la investigación sobre automatización del acceso al Menú SOL de SUNAT.
                </p>
                <div class="alert py-2 mb-4" style="background:#eff6ff;border:1px solid #bfdbfe;font-size:12px">
                    <i class="bi bi-mortarboard me-1 text-primary"></i>
                    <strong>Investigación Formativa Nivel II — UCV 2026</strong><br>
                    Relación entre la automatización del acceso al Menú SOL y la eficiencia operativa
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-house me-1"></i>Ir al Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
