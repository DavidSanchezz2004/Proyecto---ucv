<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Accediendo a SUNAT...</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Montserrat', sans-serif;
    background: #060d1a;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 24px;
    position: relative;
    overflow: hidden;
}

/* Fondo animado */
body::before {
    content: '';
    position: fixed;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 50% -10%, rgba(220,38,38,0.18) 0%, transparent 65%),
        radial-gradient(ellipse 50% 40% at 80% 100%, rgba(37,99,235,0.12) 0%, transparent 60%);
    pointer-events: none;
}
.grid-bg {
    position: fixed;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
    mask-image: radial-gradient(ellipse 90% 70% at 50% 50%, black 40%, transparent 100%);
}

/* Card principal */
.card {
    position: relative;
    z-index: 10;
    background: rgba(15, 23, 42, 0.85);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 20px;
    padding: 2.75rem 2.75rem 2.25rem;
    text-align: center;
    max-width: 420px;
    width: 100%;
    backdrop-filter: blur(20px);
    box-shadow:
        0 0 0 1px rgba(220,38,38,0.12),
        0 32px 64px rgba(0,0,0,0.5),
        inset 0 1px 0 rgba(255,255,255,0.06);
}

/* Logo SUNAT */
.sunat-logo {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 32px; font-weight: 900; color: #fff;
    letter-spacing: -2px;
    box-shadow: 0 8px 32px rgba(220,38,38,0.4), 0 0 0 1px rgba(220,38,38,0.3);
    position: relative;
}
.sunat-logo::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 18px;
    background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
}

h2 {
    font-size: 1.2rem;
    font-weight: 800;
    color: #f8fafc;
    margin-bottom: 0.35rem;
    letter-spacing: -0.02em;
}
.company-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: #cbd5e1;
    margin-bottom: 0.2rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ruc-badge {
    display: inline-block;
    font-size: 0.72rem;
    font-weight: 700;
    font-family: 'Montserrat', monospace;
    color: #64748b;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 6px;
    padding: 0.15rem 0.6rem;
    letter-spacing: 0.05em;
    margin-bottom: 2rem;
}

/* Spinner */
.spinner-ring {
    width: 56px; height: 56px;
    margin: 0 auto 2rem;
    position: relative;
}
.spinner-ring::before, .spinner-ring::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 50%;
}
.spinner-ring::before {
    border: 3px solid rgba(255,255,255,0.05);
}
.spinner-ring::after {
    border: 3px solid transparent;
    border-top-color: #dc2626;
    border-right-color: rgba(220,38,38,0.3);
    animation: spin .8s cubic-bezier(0.4,0,0.6,1) infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Steps */
.step-list {
    text-align: left;
    margin-bottom: 1.75rem;
    display: flex;
    flex-direction: column;
    gap: 0;
}
.step-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 8px;
    transition: background .3s;
    font-size: 0.8rem;
    font-weight: 500;
    color: #475569;
}
.step-item.is-done  { color: #94a3b8; }
.step-item.is-active { color: #e2e8f0; background: rgba(255,255,255,0.04); }

.step-dot {
    width: 22px; height: 22px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px;
    font-weight: 800;
    flex-shrink: 0;
    transition: all .3s;
}
.step-dot.done   { background: rgba(16,185,129,0.15); color: #10b981; border: 1.5px solid rgba(16,185,129,0.3); }
.step-dot.active { background: rgba(220,38,38,0.15); color: #f87171; border: 1.5px solid rgba(220,38,38,0.3); animation: pulse-dot 1s ease infinite; }
.step-dot.idle   { background: rgba(255,255,255,0.04); color: #334155; border: 1.5px solid rgba(255,255,255,0.07); }
@keyframes pulse-dot {
    0%, 100% { box-shadow: 0 0 0 0 rgba(220,38,38,0.3); }
    50%       { box-shadow: 0 0 0 5px rgba(220,38,38,0); }
}

/* Nota inferior */
.note {
    font-size: 0.68rem;
    color: #334155;
    line-height: 1.6;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(255,255,255,0.05);
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    text-align: left;
}
.note-icon { font-size: 0.9rem; color: #475569; flex-shrink: 0; margin-top: 1px; }

/* ——— ERROR ——— */
.err-icon {
    width: 72px; height: 72px;
    background: rgba(220,38,38,0.1);
    border: 1px solid rgba(220,38,38,0.2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 28px;
}
.err-title { font-size: 1.1rem; font-weight: 800; color: #fca5a5; margin-bottom: 0.5rem; }
.err-msg   { font-size: 0.8rem; color: #64748b; line-height: 1.7; margin-bottom: 1.5rem; }
.btn-close {
    background: rgba(255,255,255,0.06);
    color: #94a3b8;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    padding: 0.6rem 1.5rem;
    font-size: 0.82rem;
    font-weight: 600;
    font-family: 'Montserrat', sans-serif;
    cursor: pointer;
    transition: all .2s;
}
.btn-close:hover { background: rgba(255,255,255,0.1); color: #e2e8f0; }

/* Powered by */
.powered {
    position: fixed;
    bottom: 20px;
    font-size: 0.65rem;
    color: #1e293b;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    z-index: 5;
}
</style>
</head>
<body>
<div class="grid-bg"></div>

@if(isset($stateData['error']))

<div class="card">
    <div class="err-icon">⚠️</div>
    <div class="err-title">Sin conexión con SUNAT</div>
    <div class="err-msg">
        El portal puede estar en mantenimiento o sin disponibilidad.<br>
        Intenta nuevamente en unos minutos.
    </div>
    <button class="btn-close" onclick="window.close()">Cerrar ventana</button>
</div>

@else

<div class="card">
    <div class="sunat-logo">S</div>

    <h2>Ingresando a SUNAT</h2>
    <div class="company-name">{{ $company->razon_social }}</div>
    <div class="ruc-badge">RUC &nbsp;{{ $company->ruc }}</div>

    <div class="spinner-ring"></div>

    <div class="step-list">
        <div class="step-item is-done">
            <div class="step-dot done">✓</div>
            Credenciales verificadas
        </div>
        <div class="step-item is-done">
            <div class="step-dot done">✓</div>
            Conexión cifrada establecida
        </div>
        <div class="step-item is-active">
            <div class="step-dot active" id="ico-auth">↻</div>
            <span id="txt-auth">Autenticando en SUNAT...</span>
        </div>
        <div class="step-item" id="step-redir">
            <div class="step-dot idle" id="ico-redir">→</div>
            Redirigiendo al portal
        </div>
    </div>

    <div class="note">
        <span class="note-icon">🔒</span>
        Tus credenciales viajan cifradas y nunca se almacenan en texto plano. Esta ventana te llevará directamente al portal SUNAT.
    </div>
</div>

<form id="solForm" method="POST" action="{{ $actionUrl }}" style="display:none">
    <input type="hidden" name="tipo"        value="2">
    <input type="hidden" name="dni"         value="">
    <input type="hidden" name="custom_ruc"  value="{{ $company->ruc }}">
    <input type="hidden" name="j_username"  value="{{ $credential->usuario_sol }}">
    <input type="hidden" name="j_password"  value="{{ $credential->clave_sol }}">
    <input type="hidden" name="captcha"     value="">
    <input type="hidden" name="originalUrl" value="{{ $stateData['originalUrl'] }}">
    <input type="hidden" name="lang"        value="{{ $stateData['lang'] }}">
    <input type="hidden" name="state"       value="{{ $stateData['state'] }}">
</form>

<script>
setTimeout(() => {
    const auth = document.getElementById('ico-auth');
    auth.className   = 'step-dot done';
    auth.textContent = '✓';
    document.getElementById('txt-auth').textContent = 'Autenticación completada';
    document.querySelector('#step-redir').classList.add('is-active');
    const redir = document.getElementById('ico-redir');
    redir.className   = 'step-dot active';
    redir.textContent = '↻';
}, 900);

setTimeout(() => document.getElementById('solForm').submit(), 1500);
</script>

@endif

<div class="powered">SOL-Access &nbsp;·&nbsp; Investigación UCV</div>
</body>
</html>
