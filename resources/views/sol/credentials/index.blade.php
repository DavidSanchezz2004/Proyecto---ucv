@extends('layouts.app')
@section('title', 'Credenciales SOL')
@section('page-title', 'Bóveda de Credenciales')

@push('styles')
<style>
/* Executive Table & Badges */
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
.exec-header-subtitle {
    font-size: 0.8rem;
    color: #64748b;
    font-weight: 500;
}

.exec-panel {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    margin-bottom: 1.5rem;
}
.exec-alert {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 6px;
    padding: 1rem;
    display: flex;
    gap: 1rem;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}
.exec-alert-icon {
    color: #d97706;
    font-size: 1.2rem;
    line-height: 1;
}

.btn-exec-primary {
    background: #2c7be5;
    color: #fff;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}
.btn-exec-primary:hover { background: #1a68d1; color: #fff; box-shadow: 0 4px 10px rgba(44,123,229,0.2); }

.btn-action-icon {
    width: 28px; height: 28px;
    display: inline-flex; align-items: center; justify-content: center;
    border-radius: 6px;
    font-size: 0.9rem;
    color: #64748b;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
}
.btn-action-icon:hover { background: #e2e8f0; color: #1e293b; }

.badge-exec {
    padding: 0.35rem 0.6rem;
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}
.badge-exec.bg-slate { background: #f1f5f9; color: #475569; }
</style>
@endpush

@section('content')
<div class="exec-header">
    <div>
        <h5 class="exec-header-title">Directorio de Credenciales SOL</h5>
        <div class="exec-header-subtitle">Gestión centralizada de accesos y tokens criptográficos</div>
    </div>
    <a href="{{ route('sol-credentials.create') }}" class="btn-exec-primary">
        <i class="bi bi-plus-lg me-2"></i>Nueva Credencial
    </a>
</div>

<div class="exec-alert">
    <i class="bi bi-shield-lock exec-alert-icon"></i>
    <div>
        <div style="font-size:0.8rem; font-weight:600; color:#92400e; margin-bottom:0.2rem;">Zona Restringida - Alta Seguridad</div>
        <div style="font-size:0.75rem; color:#b45309; line-height:1.4;">
            Las claves listadas a continuación se encuentran cifradas de extremo a extremo utilizando el estándar <strong>AES-256-CBC</strong>.
            Únicamente el motor de simulación interno es capaz de descifrarlas durante el proceso de automatización.
        </div>
    </div>
</div>

<div class="exec-panel">
    <div class="table-responsive">
        <table class="table table-exec mb-0">
            <thead>
                <tr>
                    <th>Empresa / Contribuyente</th>
                    <th>RUC</th>
                    <th>Usuario SOL</th>
                    <th>Clave SOL</th>
                    <th>Última Verificación</th>
                    <th>Responsable</th>
                    <th class="text-end">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($credentials as $cred)
                <tr>
                    <td>
                        <div style="font-weight:600; color:#334155;">{{ $cred->company?->razon_social ?? '—' }}</div>
                    </td>
                    <td>
                        <span class="font-monospace fw-semibold" style="color:#1e293b;">{{ $cred->company?->ruc ?? '—' }}</span>
                    </td>
                    <td>
                        <span class="font-monospace fw-bold" style="color:#94a3b8; letter-spacing:0.15em;">••••••••</span>
                        <div style="font-size:0.6rem;color:#94a3b8;margin-top:2px;"><i class="bi bi-shield-lock me-1"></i>Solo visible al asistente</div>
                    </td>
                    <td>
                        <span class="font-monospace text-muted" style="letter-spacing:0.1em; font-size:1.1rem; line-height:1;">••••••••</span>
                        <span class="badge-exec bg-slate ms-2" style="font-size:0.6rem; padding:0.2rem 0.4rem;"><i class="bi bi-lock me-1"></i>AES-256</span>
                    </td>
                    <td style="font-size:0.75rem;color:#64748b;font-weight:500;">
                        {{ $cred->last_verified_at ? $cred->last_verified_at->format('d/m/Y H:i') : 'No verificada' }}
                    </td>
                    <td style="font-size:0.75rem;color:#64748b;font-weight:500;">
                        <i class="bi bi-person me-1"></i>{{ $cred->creator?->name ?? '—' }}
                    </td>
                    <td class="text-end">
                        <span style="font-size:0.72rem;font-weight:600;color:#94a3b8;display:inline-flex;align-items:center;gap:0.3rem;">
                            <i class="bi bi-lock-fill"></i> Solo asistente
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-shield-lock text-muted" style="font-size:2.5rem; opacity:0.5;"></i>
                        <div class="mt-2 text-muted" style="font-size:0.85rem; font-weight:500;">No hay credenciales registradas en la bóveda</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($credentials->hasPages())
    <div class="px-4 py-3 border-top">{{ $credentials->links() }}</div>
    @endif
</div>
@endsection
