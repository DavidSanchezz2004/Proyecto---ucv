@extends('layouts.app')

@section('title', 'Editar Usuario')
@section('page-title', 'Actualización de Personal')

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
    border-top: 3px solid #f59e0b; /* Amber accent */
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
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
}

.btn-exec-warning {
    background: #f59e0b;
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
.btn-exec-warning:hover { background: #d97706; color: #fff; box-shadow: 0 4px 10px rgba(245,158,11,0.2); }

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
        <h5 class="exec-header-title">Actualizar Usuario</h5>
        <div class="exec-header-subtitle">Modificación de credenciales de acceso y permisos operativos</div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="exec-panel">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title"><i class="bi bi-pencil-square me-2 text-warning"></i>Perfil de Colaborador</h6>
                <span class="font-monospace fw-semibold text-muted" style="font-size:0.8rem; background:#f1f5f9; padding:0.2rem 0.5rem; border-radius:4px;">{{ $user->name }}</span>
            </div>
            <div class="exec-panel-body">
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf @method('PUT')
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <label class="form-label-exec">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-exec @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}">
                            @error('name')<div class="invalid-feedback" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-exec">Correo Electrónico (Credencial) <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-exec @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}">
                            @error('email')<div class="invalid-feedback" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-exec">Rol Operativo <span class="text-danger">*</span></label>
                            <select name="role_id" class="form-select form-select-exec @error('role_id') is-invalid @enderror">
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('role_id')<div class="invalid-feedback" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label-exec">Restablecer Contraseña (Opcional)</label>
                            <input type="password" name="password" class="form-control form-control-exec @error('password') is-invalid @enderror"
                                placeholder="Dejar en blanco para no cambiar">
                            @error('password')<div class="invalid-feedback" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-exec">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-exec"
                                placeholder="Repita la nueva contraseña">
                        </div>
                    </div>

                    <div class="d-flex gap-3 pt-3 border-top">
                        <button type="submit" class="btn-exec-warning w-100 justify-content-center">
                            <i class="bi bi-cloud-check me-1"></i>Guardar Cambios
                        </button>
                        <a href="{{ route('users.index') }}" class="btn-exec-outline w-100 justify-content-center">
                            Cancelar Edición
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
