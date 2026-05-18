@extends('layouts.auth')

@section('title', 'Aceptar Términos y Condiciones')

@section('styles')
    .terms-card {
        width: 100%;
        max-width: 580px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        overflow: hidden;
    }
    .terms-header {
        background: #2c7be5;
        color: #fff;
        padding: 2rem 2.5rem;
        text-align: center;
    }
    .terms-header h2 { font-weight: 700; font-size: 1.5rem; margin-bottom: 0.4rem; }
    .terms-header p  { font-size: 0.82rem; opacity: 0.88; margin: 0; }
    .terms-body { padding: 2rem 2.5rem; }
    .google-user-badge {
        display: flex; align-items: center; gap: 0.85rem;
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 0.85rem 1rem; margin-bottom: 1.5rem;
    }
    .google-avatar {
        width: 40px; height: 40px; border-radius: 50%; object-fit: cover;
        border: 2px solid #e2e8f0;
    }
    .google-avatar-placeholder {
        width: 40px; height: 40px; border-radius: 50%;
        background: #2c7be5; color: #fff; display: flex; align-items: center;
        justify-content: center; font-weight: 700; font-size: 1rem; flex-shrink: 0;
    }
    .terms-scroll-box {
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;
        padding: 1rem 1.1rem; max-height: 220px; overflow-y: auto;
        font-size: 0.78rem; color: #334155; line-height: 1.75;
        margin-bottom: 1.25rem;
    }
    .terms-scroll-box::-webkit-scrollbar { width: 5px; }
    .terms-scroll-box::-webkit-scrollbar-track { background: #f1f5f9; }
    .terms-scroll-box::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    .btn-accept {
        background: #2c7be5; color: #fff; font-weight: 600; border: none;
        border-radius: 4px; padding: 0.6rem 1.5rem; font-size: 0.88rem;
        transition: all 0.2s; cursor: pointer; width: 100%;
    }
    .btn-accept:hover { background: #1a68d1; }
    .btn-accept:disabled { background: #93b9f4; cursor: not-allowed; }
    @media (max-width: 600px) { .terms-body { padding: 1.5rem; } .terms-header { padding: 1.5rem; } }
@endsection

@section('content')
<div class="terms-card">
    <div class="terms-header">
        <svg width="36" height="36" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" style="margin-bottom:0.75rem">
            <path fill="#fff" fill-opacity=".9" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.08 17.74 9.5 24 9.5z"/>
            <path fill="#fff" fill-opacity=".7" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
            <path fill="#fff" fill-opacity=".5" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
            <path fill="#fff" fill-opacity=".85" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-3.58-13.46-8.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
        </svg>
        <h2>Casi listo</h2>
        <p>Para completar tu registro con Google debes aceptar nuestros Términos y Condiciones.</p>
    </div>

    <div class="terms-body">

        @php $pending = session('google_pending'); @endphp

        {{-- Google user badge --}}
        <div class="google-user-badge">
            @if($pending['avatar'] ?? null)
                <img src="{{ $pending['avatar'] }}" alt="Avatar" class="google-avatar">
            @else
                <div class="google-avatar-placeholder">
                    {{ strtoupper(substr($pending['name'] ?? 'U', 0, 1)) }}
                </div>
            @endif
            <div>
                <div style="font-size:0.88rem;font-weight:600;color:#1e293b;">{{ $pending['name'] ?? '' }}</div>
                <div style="font-size:0.75rem;color:#64748b;">{{ $pending['email'] ?? '' }}</div>
            </div>
            <div style="margin-left:auto;">
                <span style="font-size:0.68rem;background:#dcfce7;color:#166534;padding:0.2rem 0.5rem;border-radius:999px;font-weight:600;">
                    <i class="bi bi-google me-1"></i>Google
                </span>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger py-2 mb-3" style="font-size:0.8rem">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
        </div>
        @endif

        {{-- T&C scroll box --}}
        <div class="terms-scroll-box" id="termsBox">
            @include('partials.terms-content')
        </div>

        <form method="POST" action="{{ route('google.terms.complete') }}">
            @csrf

            <div class="p-3 rounded mb-4" style="background:#f8fafc;border:1px solid #e2e8f0;">
                <div class="form-check">
                    <input type="checkbox" name="terms" id="terms" value="1"
                           class="form-check-input @error('terms') is-invalid @enderror"
                           onchange="document.getElementById('btnAceptar').disabled = !this.checked;">
                    <label class="form-check-label" for="terms" style="font-size:0.82rem;color:#334155;line-height:1.5;">
                        He leído y acepto los <strong>Términos y Condiciones de uso</strong>
                        <span class="text-danger">*</span>
                    </label>
                    @error('terms')
                    <div class="invalid-feedback" style="font-size:0.72rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" id="btnAceptar" class="btn-accept" disabled>
                <i class="bi bi-check-circle me-2"></i>Aceptar y crear cuenta
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" style="font-size:0.78rem;color:#64748b;text-decoration:none;">
                <i class="bi bi-arrow-left me-1"></i>Cancelar y volver al inicio de sesión
            </a>
        </div>
    </div>
</div>
@endsection
