@extends('layouts.app')
@section('title', 'Acceso denegado')
@section('page-title', 'Acceso denegado')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 text-center py-5">
        <div style="font-size:72px;color:#fee2e2;font-weight:900;line-height:1">403</div>
        <h4 class="fw-bold text-danger">Acceso no autorizado</h4>
        <p class="text-muted mb-4">No tienes permisos para acceder a esta sección.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">
            <i class="bi bi-house me-1"></i>Volver al Dashboard
        </a>
    </div>
</div>
@endsection
