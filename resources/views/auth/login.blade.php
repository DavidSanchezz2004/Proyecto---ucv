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
        background: #2c7be5; /* Falcon blue */
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
    
    /* The distinctive curve from the design */
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
    .left-panel a:hover {
        text-decoration: underline;
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

    .login-options a {
        color: #2c7be5;
        text-decoration: none;
        font-weight: 500;
    }

    .btn-login {
        background-color: #93b9f4; /* Muted blue matching design */
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

    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: #9da9bb;
        font-size: 0.75rem;
        margin: 1.5rem 0;
    }
    .divider::before, .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #edf2f9;
    }
    .divider::before { margin-right: .5em; }
    .divider::after { margin-left: .5em; }

    .social-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-social {
        flex: 1;
        border: 1px solid #d8e2ef;
        background: #fff;
        color: #5e6e82;
        font-weight: 500;
        font-size: 0.8rem;
        padding: 0.4rem;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: background 0.2s;
    }
    .btn-social:hover {
        background: #f9fafd;
    }
    .text-google { color: #e63757; font-weight: 700; font-size: 0.9rem; }
    .text-facebook { color: #39508f; font-weight: 700; font-size: 0.9rem; }

    /* Responsive adjustments */
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
        
        <div style="margin-top:2rem; font-size: 0.8rem; z-index: 1;">
            ¿No tienes cuenta?<br>
            <a href="{{ route('register') }}">¡Regístrate aquí!</a>
        </div>
        
        <div class="bottom-links mt-4">
            Lee nuestros <a href="#">términos</a> y <a href="#">condiciones</a>
        </div>
    </div>
    
    <div class="right-panel">
        <h3>Account Login</h3>
        
        @if(session('success'))
        <div class="alert alert-success alert-sm py-2 text-sm">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="usuario@empresa.com" autofocus autocomplete="email">
                @error('email')
                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label class="form-label">Password</label>
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
                    <label class="form-check-label text-muted" for="remember" style="font-size:0.75rem;">Remember me</label>
                </div>
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-login w-100">
                Log in
            </button>
            
            <div class="divider">or log in with</div>
            
            <div class="social-buttons">
                <button type="button" class="btn btn-social">
                    <span class="text-google">G+</span> google
                </button>
                <button type="button" class="btn btn-social">
                    <i class="bi bi-facebook text-facebook"></i> facebook
                </button>
            </div>
        </form>

        <div class="text-center mt-3" style="font-size:0.78rem;color:#6b7280">
            ¿No tienes cuenta? <a href="{{ route('register') }}" style="color:#2c7be5;font-weight:600">Crear cuenta</a>
        </div>
    </div>
</div>
@endsection

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
