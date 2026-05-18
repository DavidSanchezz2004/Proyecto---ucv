@extends('layouts.app')

@section('title', 'Editar Credencial SOL')
@section('page-title', 'Mantenimiento de Credenciales')

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
    border-top: 3px solid #f59e0b; /* Amber accent for editing */
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
.form-control-exec {
    font-family: 'Montserrat', sans-serif;
    font-size: 0.9rem;
    padding: 0.6rem 0.8rem;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    color: #1e293b;
    transition: all 0.2s;
}
.form-control-exec:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
}
.form-text-exec {
    font-size: 0.7rem;
    color: #64748b;
    margin-top: 0.3rem;
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

.exec-alert {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 1rem;
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}
.exec-alert-icon {
    color: #f59e0b;
    font-size: 1.2rem;
    line-height: 1;
}

.readonly-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
}
</style>
@endpush

@section('content')
<div class="exec-header">
    <div>
        <h5 class="exec-header-title">Actualizar Credencial Segura</h5>
        <div class="exec-header-subtitle">Modificación de tokens de acceso SOL</div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">
        <div class="exec-panel">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title">
                    <i class="bi bi-key-fill me-2 text-warning"></i>Modificar Credencial
                </h6>
            </div>
            <div class="exec-panel-body">
                
                {{-- REQ 3: Alerta de credenciales protegidas --}}
                <div style="background:#fffbeb;border:1px solid #fde68a;border-left:4px solid #f59e0b;border-radius:8px;padding:1rem 1.1rem;margin-bottom:1.25rem;display:flex;gap:0.85rem;align-items:flex-start;">
                    <i class="bi bi-shield-lock-fill" style="color:#d97706;font-size:1.2rem;flex-shrink:0;margin-top:1px;"></i>
                    <div>
                        <div style="font-size:0.8rem;font-weight:700;color:#92400e;margin-bottom:0.3rem;">Credenciales protegidas</div>
                        <div style="font-size:0.75rem;color:#78350f;line-height:1.55;">
                            Las credenciales deben pertenecer a empresas o contribuyentes que <strong>autorizaron su uso</strong>.
                            Si dejas la clave en blanco, se conservará la actual cifrada.
                            El equipo de investigación <strong>no tendrá acceso directo a la contraseña</strong> ni realizará operaciones tributarias en nombre del usuario.
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('sol-credentials.update', $solCredential) }}" id="formEditarCredencial" onsubmit="return false;">
                    @csrf @method('PUT')
                    
                    <div class="readonly-box">
                        <div class="form-label-exec" style="font-size:0.65rem;">Entidad Vinculada</div>
                        <div style="font-size:0.95rem; font-weight:600; color:#1e293b; margin-bottom:0.2rem;">{{ $solCredential->company?->razon_social }}</div>
                        <div class="font-monospace text-muted" style="font-size:0.8rem;">RUC: {{ $solCredential->company?->ruc }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-exec">Usuario SOL <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person-badge"></i></span>
                            <input type="text" name="usuario_sol" class="form-control form-control-exec border-start-0 ps-0 font-monospace @error('usuario_sol') is-invalid @enderror"
                                value="{{ old('usuario_sol', $solCredential->usuario_sol) }}" maxlength="8"
                                style="text-transform:uppercase" oninput="this.value=this.value.toUpperCase()">
                        </div>
                        @error('usuario_sol')<div class="text-danger mt-1" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label-exec">Nueva Clave de Acceso (Opcional)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-key"></i></span>
                            <input type="password" name="clave_sol" id="clave_sol"
                                class="form-control form-control-exec border-start-0 border-end-0 px-0 font-monospace @error('clave_sol') is-invalid @enderror"
                                placeholder="Dejar en blanco para no modificar" maxlength="20">
                            <button type="button" class="btn btn-outline-secondary bg-white border-start-0" onclick="toggleClave()" style="border-color:#cbd5e1; color:#64748b;">
                                <i class="bi bi-eye" id="eyeClave"></i>
                            </button>
                        </div>
                        @error('clave_sol')<div class="text-danger mt-1" style="font-size:0.7rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-3 mt-5 pt-3 border-top">
                        <button type="button" class="btn-exec-warning w-100 justify-content-center"
                                data-bs-toggle="modal" data-bs-target="#modalConfirmarEdicion">
                            <i class="bi bi-shield-check me-1"></i>Actualizar Credencial
                        </button>
                        <a href="{{ route('sol-credentials.index') }}" class="btn-exec-outline w-100 justify-content-center">
                            Cancelar Edición
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="modalConfirmarEdicion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <div style="width:56px;height:56px;background:#fef3c7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <i class="bi bi-shield-check" style="font-size:1.6rem;color:#d97706;"></i>
                    </div>
                    <h6 style="font-weight:700;color:#1e293b;margin-bottom:0.5rem;">Confirmar autorización</h6>
                    <p style="font-size:0.82rem;color:#475569;line-height:1.6;margin-bottom:0;">
                        Está por actualizar credenciales de acceso al Menú SOL.
                        Confirme que cuenta con <strong>autorización del titular o responsable</strong> de la empresa.
                        Esta acción quedará registrada en el historial del sistema.
                    </p>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal"
                            style="font-size:0.82rem;border-radius:8px;">
                        Cancelar
                    </button>
                    <button type="button" class="btn w-100" data-bs-dismiss="modal"
                            onclick="document.getElementById('formEditarCredencial').removeAttribute('onsubmit'); document.getElementById('formEditarCredencial').submit();"
                            style="background:#059669;color:#fff;font-size:0.82rem;border-radius:8px;font-weight:600;">
                        <i class="bi bi-check-circle me-1"></i>Sí, cuento con autorización
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
function toggleClave() {
    const f = document.getElementById('clave_sol');
    const i = document.getElementById('eyeClave');
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
@endpush
