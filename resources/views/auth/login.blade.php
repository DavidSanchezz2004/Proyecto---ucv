@extends('layouts.auth')

@section('title', 'Iniciar Sesión')

@section('styles')
    .split-card {
        display: flex;
        flex-direction: row;
        width: 100%;
        max-width: 820px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        overflow: hidden;
        min-height: 520px;
    }

    .left-panel {
        background: #2c7be5;
        width: 45%;
        color: white;
        padding: 3rem 2.5rem;
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
        top: 45%;
        left: -20%;
        width: 140%;
        height: 140%;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    .left-panel h2 {
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 1.5rem;
        letter-spacing: -0.5px;
        z-index: 1;
    }

    .left-panel p {
        font-size: 0.85rem;
        line-height: 1.6;
        opacity: 0.9;
        margin-bottom: 2.5rem;
        z-index: 1;
    }

    .left-panel .bottom-links {
        margin-top: auto;
        font-size: 0.75rem;
        z-index: 1;
    }
    .left-panel a {
        color: #fff;
        font-weight: 600;
        text-decoration: none;
    }
    .left-panel a:hover { text-decoration: underline; }

    .btn-register-cta {
        display: block;
        background: rgba(255,255,255,0.15);
        border: 2px solid rgba(255,255,255,0.8);
        border-radius: 6px;
        padding: 0.65rem 1.5rem;
        font-size: 0.88rem;
        font-weight: 700;
        color: #fff !important;
        text-decoration: none !important;
        text-align: center;
        transition: all 0.2s;
        z-index: 1;
        position: relative;
    }
    .btn-register-cta:hover {
        background: rgba(255,255,255,0.28);
        border-color: #fff;
        transform: translateY(-1px);
    }

    .right-panel {
        width: 55%;
        padding: 3rem 3.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .right-panel h3 {
        font-weight: 500;
        color: #344050;
        margin-bottom: 1.5rem;
        font-size: 1.3rem;
    }

    .form-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #5e6e82;
        margin-bottom: 0.3rem;
    }

    .form-control {
        border-radius: 4px;
        border: 1px solid #d8e2ef;
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
        color: #5e6e82;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(44, 123, 229, 0.25);
        border-color: #86b7fe;
    }

    .input-group-text {
        background-color: transparent;
        border-color: #d8e2ef;
        color: #9da9bb;
    }

    .login-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.75rem;
        margin-top: 0.8rem;
        margin-bottom: 1.2rem;
    }

    .btn-login {
        background-color: #93b9f4;
        color: white;
        font-weight: 600;
        border-radius: 4px;
        padding: 0.5rem;
        border: none;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    .btn-login:hover {
        background-color: #2c7be5;
        color: white;
    }

    @media (max-width: 768px) {
        .split-card { flex-direction: column; }
        .left-panel { width: 100%; padding: 2rem; }
        .right-panel { width: 100%; padding: 2rem; }
    }
@endsection

@section('content')
<div class="split-card">
    <div class="left-panel">
        <h2>SOL-Access</h2>
        <p>Con el poder de SOL-Access, puedes enfocarte en tus labores tributarias mientras nosotros automatizamos tu ingreso al Menú SOL.</p>

        <div style="margin-top:0.5rem; z-index:1; width:100%;">
            <div style="font-size:0.8rem; opacity:0.85; margin-bottom:0.75rem;">¿No tienes cuenta aún?</div>
            <a href="{{ route('register') }}" class="btn-register-cta">
                <i class="bi bi-person-plus me-2"></i>Crear cuenta gratuita
            </a>
        </div>

        <div class="bottom-links mt-4">
            Lee nuestros <a href="#" data-bs-toggle="modal" data-bs-target="#termsLoginModal">Términos y Condiciones</a>
        </div>
    </div>

    <div class="right-panel">
        <h3>Iniciar sesión</h3>

        @if(session('success'))
        <div class="alert alert-success alert-sm py-2 text-sm">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="usuario@empresa.com" autofocus autocomplete="email">
                @error('email')
                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="••••••••" autocomplete="current-password" style="border-right: none;">
                    <span class="input-group-text bg-white" style="border-left: none; cursor: pointer;" id="togglePass">
                        <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                    </span>
                </div>
                @error('password')
                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="login-options">
                <div class="form-check m-0">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label text-muted" for="remember" style="font-size:0.75rem;">Recordarme</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
            </button>
        </form>
    </div>
</div>

@endsection

@push('modals')
<div class="modal fade" id="termsLoginModal" tabindex="-1" aria-labelledby="termsLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsLoginModalLabel" style="font-size:1rem; font-weight:700; color:#1e293b;">
                    <i class="bi bi-file-earmark-text me-2 text-primary"></i>Términos y Condiciones de Uso
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="font-size:0.82rem; color:#334155; line-height:1.8;">
                @include('partials.terms-content')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endpush

@section('scripts')
<script>
document.getElementById('togglePass').addEventListener('click', function() {
    const pass = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (pass.type === 'password') {
        pass.type = 'text';
        icon.className = 'bi bi-eye-slash text-muted';
    } else {
        pass.type = 'password';
        icon.className = 'bi bi-eye text-muted';
    }
});
</script>
@endsection
