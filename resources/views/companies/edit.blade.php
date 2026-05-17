@extends('layouts.app')

@section('title', 'Editar Entidad')
@section('page-title', 'Edición Corporativa')

@push('styles')
<style>
/* Executive Styles for Forms */
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
    border-top: 3px solid #3b82f6;
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

.form-label-exec {
    font-size: 0.75rem;
    font-weight: 600;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    margin-bottom: 0.4rem;
}
.form-control-exec, .form-select-exec {
    font-family: 'Montserrat', sans-serif;
    font-size: 0.9rem;
    padding: 0.6rem 0.8rem;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    color: #1e293b;
    transition: all 0.2s;
}
.form-control-exec:focus, .form-select-exec:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

.btn-exec-primary {
    background: #2c7be5;
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.6rem 1.2rem;
    border-radius: 6px;
    border: none;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
.btn-exec-primary:hover { background: #1a68d1; color: #fff; box-shadow: 0 4px 10px rgba(44,123,229,0.2); }

.btn-exec-outline {
    background: transparent;
    color: #475569;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 0.6rem 1.2rem;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
.btn-exec-outline:hover { background: #f8fafc; color: #1e293b; border-color: #94a3b8; }
</style>
@endpush

@section('content')
<div class="exec-header">
    <div>
        <h5 class="exec-header-title">Actualizar Información</h5>
        <div class="exec-header-subtitle">Modificación de datos del contribuyente</div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-9 col-lg-7">
        <div class="exec-panel">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title"><i class="bi bi-pencil-square me-2 text-primary"></i>Datos de Entidad</h6>
                <span class="font-monospace fw-semibold text-muted" style="font-size:0.8rem; background:#f1f5f9; padding:0.2rem 0.5rem; border-radius:4px;">{{ $company->ruc }}</span>
            </div>
            <div class="exec-panel-body">
                <form method="POST" action="{{ route('companies.update', $company) }}">
                    @csrf @method('PUT')
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <label class="form-label-exec">RUC <span class="text-danger">*</span></label>
                            <input type="text" name="ruc" class="form-control form-control-exec font-monospace @error('ruc') is-invalid @enderror"
                                value="{{ old('ruc', $company->ruc) }}" maxlength="11" pattern="\d{11}">
                            @error('ruc')<div class="invalid-feedback" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label-exec">Razón Social <span class="text-danger">*</span></label>
                            <input type="text" name="razon_social" class="form-control form-control-exec fw-semibold @error('razon_social') is-invalid @enderror"
                                value="{{ old('razon_social', $company->razon_social) }}" maxlength="255">
                            @error('razon_social')<div class="invalid-feedback" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-exec">Clasificación SUNAT</label>
                            <select name="tipo_contribuyente" class="form-select form-select-exec">
                                <option value="">Seleccionar régimen...</option>
                                <option value="PERSONA NATURAL"  {{ old('tipo_contribuyente', $company->tipo_contribuyente) === 'PERSONA NATURAL'  ? 'selected' : '' }}>Persona Natural</option>
                                <option value="PERSONA JURIDICA" {{ old('tipo_contribuyente', $company->tipo_contribuyente) === 'PERSONA JURIDICA' ? 'selected' : '' }}>Persona Jurídica</option>
                                <option value="EMPRESA"          {{ old('tipo_contribuyente', $company->tipo_contribuyente) === 'EMPRESA'          ? 'selected' : '' }}>Empresa</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-exec">Estado de Actividad</label>
                            <select name="estado" class="form-select form-select-exec @error('estado') is-invalid @enderror">
                                <option value="ACTIVO"     {{ old('estado', $company->estado) === 'ACTIVO'     ? 'selected' : '' }}>Activo</option>
                                <option value="BAJA"       {{ old('estado', $company->estado) === 'BAJA'       ? 'selected' : '' }}>De Baja</option>
                                <option value="SUSPENSION" {{ old('estado', $company->estado) === 'SUSPENSION' ? 'selected' : '' }}>Suspensión Temporal</option>
                            </select>
                            @error('estado')<div class="invalid-feedback" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label-exec">Domicilio Fiscal (Opcional)</label>
                        <textarea name="direccion_fiscal" class="form-control form-control-exec" rows="2" placeholder="Ingrese la dirección fiscal registrada...">{{ old('direccion_fiscal', $company->direccion_fiscal) }}</textarea>
                    </div>

                    <div class="d-flex gap-3 pt-3 border-top">
                        <button type="submit" class="btn-exec-primary w-100 justify-content-center">
                            <i class="bi bi-cloud-check me-1"></i>Guardar Cambios
                        </button>
                        <a href="{{ route('companies.show', $company) }}" class="btn-exec-outline w-100 justify-content-center">
                            Cancelar Edición
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
