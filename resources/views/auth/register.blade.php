@extends('layouts.auth')

@section('title', 'Crear Cuenta')

@section('styles')
    .split-card {
        display: flex;
        flex-direction: row;
        width: 100%;
        max-width: 900px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        overflow: hidden;
        min-height: 600px;
    }
    .left-panel {
        background: #2c7be5;
        width: 38%;
        color: white;
        padding: 3rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .left-panel::before {
        content: '';
        position: absolute;
        top: 45%;left: -20%;
        width: 140%;height: 140%;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;pointer-events: none;
    }
    .left-panel h2 { font-weight: 700; font-size: 2rem; margin-bottom: 1.2rem; z-index: 1; }
    .left-panel p  { font-size: 0.82rem; line-height: 1.65; opacity: 0.9; margin-bottom: 2rem; z-index: 1; }
    .left-panel a  { color: #fff; font-weight: 600; text-decoration: none; }
    .left-panel a:hover { text-decoration: underline; }
    .right-panel { width: 62%; padding: 2.5rem 3rem; display: flex; flex-direction: column; justify-content: center; overflow-y: auto; }
    .right-panel h3 { font-weight: 500; color: #344050; margin-bottom: 1.25rem; font-size: 1.2rem; }
    .form-label { font-size: 0.73rem; font-weight: 600; color: #5e6e82; margin-bottom: 0.3rem; }
    .form-control { border-radius: 4px; border: 1px solid #d8e2ef; padding: 0.45rem 0.75rem; font-size: 0.85rem; color: #344050; }
    .form-control:focus { box-shadow: 0 0 0 0.2rem rgba(44,123,229,0.2); border-color: #86b7fe; }
    .section-divider { font-size: 0.7rem; font-weight: 600; color: #9da9bb; text-transform: uppercase; letter-spacing: 0.08em; margin: 1.25rem 0 1rem; display: flex; align-items: center; gap: 0.5rem; }
    .section-divider::before, .section-divider::after { content: ''; flex: 1; border-bottom: 1px solid #edf2f9; }
    .btn-register { background-color: #2c7be5; color: white; font-weight: 600; border-radius: 4px; padding: 0.5rem; border: none; font-size: 0.85rem; transition: all 0.2s; }
    .btn-register:hover { background-color: #1a68d1; color: white; }
    .optional-badge { background: #edf2f9; color: #5e6e82; font-size: 0.65rem; font-weight: 500; padding: 0.15rem 0.45rem; border-radius: 3px; vertical-align: middle; margin-left: 4px; }
    .sol-accordion-btn {
        display: flex; align-items: center; justify-content: space-between;
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 0.75rem 1rem; cursor: pointer; transition: all 0.2s; text-decoration: none;
    }
    .sol-accordion-btn:hover { background: #f1f5f9; border-color: #cbd5e1; }
    .sol-accordion-btn.open  { background: #eff6ff; border-color: #93c5fd; border-bottom-left-radius: 0; border-bottom-right-radius: 0; }
    .sol-chevron { font-size: 0.75rem; color: #64748b; transition: transform 0.2s; }
    .sol-accordion-btn[aria-expanded="true"] .sol-chevron { transform: rotate(180deg); }
    .sol-accordion-body { border: 1px solid #93c5fd; border-top: none; border-radius: 0 0 8px 8px; padding: 1rem; background: #fafcff; }
    @media (max-width: 768px) { .split-card { flex-direction: column; } .left-panel { width: 100%; } .right-panel { width: 100%; padding: 2rem; } }
@endsection

@section('content')
<div class="split-card">
    <div class="left-panel">
        <h2>SOL-Access</h2>
        <p>Registra tu cuenta, ingresa tu RUC y credenciales SOL para automatizar tu acceso al portal SUNAT.</p>

        <div style="margin-top:1.5rem; font-size: 0.8rem; z-index: 1;">
            ¿Ya tienes cuenta?<br>
            <a href="{{ route('login') }}">Iniciar sesión</a>
        </div>

        <div style="margin-top:auto; font-size:0.7rem; opacity:.7; z-index:1;">
            Investigación Formativa Nivel II<br>UCV 2026
        </div>
    </div>

    <div class="right-panel">
        <h3>Crear cuenta</h3>

        @if($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:0.8rem">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            {{-- Datos personales --}}
            <div class="row g-3 mb-2">
                <div class="col-12">
                    <label class="form-label">Nombre completo <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="Tu nombre y apellidos" autofocus>
                    @error('name')<div class="invalid-feedback" style="font-size:0.7rem">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="tu@correo.com">
                    @error('email')<div class="invalid-feedback" style="font-size:0.7rem">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contraseña <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" id="reg-password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Min. 8 caracteres" style="border-right:none;">
                        <span class="input-group-text bg-white" style="border-left:none;cursor:pointer;border-color:#d8e2ef;" id="toggleRegPass">
                            <i class="bi bi-eye text-muted" id="eyeRegPass" style="font-size:0.85rem;"></i>
                        </span>
                    </div>
                    @error('password')<div class="text-danger mt-1" style="font-size:0.7rem"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirmar contraseña <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="reg-password-confirm"
                            class="form-control" placeholder="Repite la contraseña" style="border-right:none;">
                        <span class="input-group-text bg-white" style="border-left:none;cursor:pointer;border-color:#d8e2ef;" id="toggleRegConfirm">
                            <i class="bi bi-eye text-muted" id="eyeRegConfirm" style="font-size:0.85rem;"></i>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Acordeón: Empresa / Credenciales SOL --}}
            @php $solOpen = $errors->hasAny(['ruc','razon_social','usuario_sol','clave_sol']) || old('ruc'); @endphp
            <div class="mt-3">
                <button type="button"
                    class="sol-accordion-btn w-100 {{ $solOpen ? 'open' : '' }}"
                    data-bs-toggle="collapse"
                    data-bs-target="#solFields"
                    aria-expanded="{{ $solOpen ? 'true' : 'false' }}">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-shield-lock-fill" style="color:#2c7be5;font-size:1rem"></i>
                        <div class="text-start">
                            <div style="font-size:0.82rem;font-weight:600;color:#1e293b">Agregar mi empresa y credenciales SOL</div>
                            <div style="font-size:0.7rem;color:#64748b;font-weight:400">Opcional — para automatizar el acceso a SUNAT</div>
                        </div>
                    </div>
                    <i class="bi bi-chevron-down sol-chevron"></i>
                </button>

                <div class="collapse {{ $solOpen ? 'show' : '' }}" id="solFields">
                    <div class="sol-accordion-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">RUC</label>
                                <input type="text" name="ruc" class="form-control font-monospace @error('ruc') is-invalid @enderror"
                                    value="{{ old('ruc') }}" maxlength="11" pattern="\d{11}" placeholder="20XXXXXXXXX">
                                @error('ruc')<div class="invalid-feedback" style="font-size:0.7rem">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Razón Social</label>
                                <input type="text" name="razon_social" class="form-control @error('razon_social') is-invalid @enderror"
                                    value="{{ old('razon_social') }}" placeholder="Nombre o razón social">
                                @error('razon_social')<div class="invalid-feedback" style="font-size:0.7rem">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Usuario SOL</label>
                                <input type="text" name="usuario_sol" class="form-control font-monospace @error('usuario_sol') is-invalid @enderror"
                                    value="{{ old('usuario_sol') }}" maxlength="8" placeholder="USUARIOL" style="text-transform:uppercase">
                                @error('usuario_sol')<div class="invalid-feedback" style="font-size:0.7rem">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">Clave SOL</label>
                                <input type="password" name="clave_sol" class="form-control @error('clave_sol') is-invalid @enderror"
                                    placeholder="Tu clave SOL de SUNAT">
                                @error('clave_sol')<div class="invalid-feedback" style="font-size:0.7rem">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mt-3 px-2 py-2 rounded d-flex align-items-center gap-2"
                             style="background:#eff6ff;border:1px solid #bfdbfe;font-size:0.71rem;color:#1e40af">
                            <i class="bi bi-shield-check" style="font-size:1rem;flex-shrink:0"></i>
                            Tu clave SOL se almacena cifrada con AES-256. Nunca se muestra en pantalla.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Términos y Condiciones --}}
            <div class="mt-3 p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                <div class="form-check">
                    <input type="checkbox" name="terms" id="terms" value="1"
                        class="form-check-input @error('terms') is-invalid @enderror"
                        {{ old('terms') ? 'checked' : '' }}>
                    <label class="form-check-label" for="terms" style="font-size:0.8rem; color:#334155; line-height:1.4;">
                        He leído y acepto los
                        <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" style="color:#2c7be5; font-weight:600;">
                            Términos y Condiciones de uso
                        </a>
                        <span class="text-danger">*</span>
                    </label>
                    @error('terms')
                    <div class="invalid-feedback" style="font-size:0.7rem;">Debes aceptar los Términos y Condiciones para continuar.</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-register w-100 mt-3">
                <i class="bi bi-person-check me-2"></i>Crear cuenta
            </button>

            <div style="display:flex;align-items:center;gap:0.75rem;margin:1rem 0 0.75rem;">
                <div style="flex:1;height:1px;background:#e2e8f0;"></div>
                <span style="font-size:0.72rem;color:#94a3b8;white-space:nowrap;">o regístrate con</span>
                <div style="flex:1;height:1px;background:#e2e8f0;"></div>
            </div>

            <a href="{{ route('google.redirect') }}"
               style="display:flex;align-items:center;justify-content:center;gap:0.6rem;width:100%;padding:0.5rem 1rem;border:1.5px solid #e2e8f0;border-radius:4px;font-size:0.85rem;font-weight:600;color:#344050;text-decoration:none;transition:all 0.2s;background:#fff;"
               onmouseover="this.style.background='#f8fafc';this.style.borderColor='#94a3b8'"
               onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0'">
                <svg width="18" height="18" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.08 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-3.58-13.46-8.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                    <path fill="none" d="M0 0h48v48H0z"/>
                </svg>
                Registrarse con Google
            </a>

            <div class="text-center mt-3" style="font-size:0.78rem;color:#6b7280">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}" style="color:#2c7be5;font-weight:600">Iniciar sesión</a>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash text-muted';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye text-muted';
    }
}
document.getElementById('toggleRegPass').addEventListener('click', () => togglePass('reg-password', 'eyeRegPass'));
document.getElementById('toggleRegConfirm').addEventListener('click', () => togglePass('reg-password-confirm', 'eyeRegConfirm'));
</script>
@endsection

@push('modals')
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel" style="font-size:1rem; font-weight:700; color:#1e293b;">
                    <i class="bi bi-file-earmark-text me-2 text-primary"></i>Términos y Condiciones de Uso
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="font-size:0.82rem; color:#334155; line-height:1.8;">
                @include('partials.terms-content')
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Cerrar
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal"
                    onclick="document.getElementById('terms').checked = true; document.getElementById('terms').dispatchEvent(new Event('change'));">
                    <i class="bi bi-check-lg me-1"></i>Acepto los Términos y Condiciones
                </button>
            </div>
        </div>
    </div>
</div>
@endpush
