@extends('layouts.app')

@section('title', 'Nuevo Usuario')
@section('page-title', 'Incorporación de Personal')

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
    border-top: 3px solid #3b82f6; /* Blue accent */
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
.form-text-exec {
    font-size: 0.7rem;
    color: #64748b;
    margin-top: 0.3rem;
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
        <h5 class="exec-header-title">Registro de Personal</h5>
        <div class="exec-header-subtitle">Creación de nuevas cuentas de acceso y asignación de roles</div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="exec-panel">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title"><i class="bi bi-person-plus me-2 text-primary"></i>Datos del Nuevo Usuario</h6>
            </div>
            <div class="exec-panel-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <label class="form-label-exec">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-exec @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Ej. Juan Pérez">
                            @error('name')<div class="invalid-feedback" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-exec">Correo Electrónico (Credencial) <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-exec @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="usuario@empresa.com">
                            @error('email')<div class="invalid-feedback" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-exec">Rol Operativo <span class="text-danger">*</span></label>
                            <select name="role_id" class="form-select form-select-exec @error('role_id') is-invalid @enderror">
                                <option value="">Seleccionar nivel de acceso...</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('role_id')<div class="invalid-feedback" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label-exec">Contraseña Provisional <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control form-control-exec @error('password') is-invalid @enderror"
                                placeholder="••••••••">
                            @error('password')<div class="invalid-feedback" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                            <div class="form-text-exec">Mínimo 8 caracteres. Se recomienda combinación alfanumérica.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-exec">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control form-control-exec"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="d-flex gap-3 pt-3 border-top">
                        <button type="submit" class="btn-exec-primary w-100 justify-content-center">
                            <i class="bi bi-person-check me-1"></i>Aperturar Cuenta
                        </button>
                        <a href="{{ route('users.index') }}" class="btn-exec-outline w-100 justify-content-center">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
