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
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Min. 8 caracteres">
                    @error('password')<div class="invalid-feedback" style="font-size:0.7rem">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirmar contraseña <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repite la contraseña">
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

            <button type="submit" class="btn btn-register w-100 mt-2">
                Crear cuenta
            </button>

            <div class="text-center mt-3" style="font-size:0.78rem;color:#6b7280">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}" style="color:#2c7be5;font-weight:600">Iniciar sesión</a>
            </div>
        </form>
    </div>
</div>
@endsection
