@extends('layouts.app')

@section('title', $company->razon_social)
@section('page-title', 'Detalle de Contribuyente')

@push('styles')
<style>
/* Executive Styles */
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

.data-label {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 0.2rem;
}
.data-value {
    font-size: 0.9rem;
    color: #334155;
    font-weight: 500;
}
.data-value.ruc {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
}

.badge-exec {
    padding: 0.35rem 0.6rem;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}
.badge-exec.bg-slate    { background: #f1f5f9; color: #475569; }
.badge-exec.bg-blue     { background: #eff6ff; color: #2563eb; }
.badge-exec.bg-emerald  { background: #f0fdf4; color: #059669; }
.badge-exec.bg-rose     { background: #fff1f2; color: #e11d48; }
.badge-exec.bg-amber    { background: #fffbeb; color: #d97706; }

.btn-exec-primary {
    background: #2c7be5;
    color: #fff;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    transition: all 0.2s;
}
.btn-exec-primary:hover { background: #1a68d1; color: #fff; }

.btn-exec-outline {
    background: transparent;
    color: #475569;
    font-size: 0.8rem;
    font-weight: 500;
    padding: 0.45rem 0.85rem;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.btn-exec-outline:hover { background: #f8fafc; color: #1e293b; border-color: #94a3b8; }

.log-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.8rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
}
.log-item:last-child { border-bottom: none; }

/* Botón Menú SOL */
.btn-sol {
    background: transparent;
    color: #2c7be5;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.6rem 1rem;
    border-radius: 6px;
    border: 1px solid #2c7be5;
    transition: all 0.2s ease;
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    font-family: 'Montserrat', sans-serif;
}
.btn-sol:hover:not(:disabled) {
    background: #2c7be5;
    color: #fff;
    box-shadow: 0 4px 12px rgba(44, 123, 229, 0.2);
}
.btn-sol:disabled { opacity: 0.6; cursor: not-allowed; border-color: #cbd5e1; color: #64748b; }

/* Modal Override */
.sol-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);
    z-index: 2000; display: flex; align-items: center; justify-content: center;
}
.exec-modal-content {
    background: #fff; border-radius: 12px; padding: 2.5rem;
    width: 100%; max-width: 480px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); border: 1px solid #e2e8f0;
}
.step-indicator {
    width: 18px; height: 18px; border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 11px; font-weight: 700;
}
.step-indicator.pending { background: #e2e8f0; }
.step-indicator.active  { background: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.25); animation: pulse-step 0.8s ease infinite; }
.step-indicator.done    { background: #059669; color: #fff; }
.step-indicator.done::after  { content: '✓'; }
.step-indicator.active::after { content: ''; }
@keyframes pulse-step {
    0%, 100% { box-shadow: 0 0 0 3px rgba(59,130,246,0.25); }
    50%       { box-shadow: 0 0 0 5px rgba(59,130,246,0.12); }
}
</style>
@endpush

@section('content')
<div class="exec-header">
    <div>
        <h5 class="exec-header-title">{{ $company->razon_social }}</h5>
        <div class="exec-header-subtitle">Perfil corporativo e historial operativo</div>
    </div>
    <a href="{{ route('companies.index') }}" class="btn-exec-outline">
        <i class="bi bi-arrow-left me-2"></i>Volver al Directorio
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        {{-- Datos de la empresa --}}
        <div class="exec-panel">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title">Información de Entidad</h6>
                @if($company->created_by === auth()->id())
                <a href="{{ route('companies.edit', $company) }}" class="btn-exec-outline py-1 px-2" style="font-size:0.7rem;">
                    <i class="bi bi-pencil me-1"></i>Editar Perfil
                </a>
                @endif
            </div>
            <div class="exec-panel-body">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="data-label">Número de RUC</div>
                        <div class="data-value ruc">{{ $company->ruc }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="data-label">Razón Social</div>
                        <div class="data-value" style="font-weight:600;">{{ $company->razon_social }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="data-label">Clasificación</div>
                        <span class="badge-exec {{ $company->tipo_contribuyente === 'PERSONA NATURAL' ? 'bg-slate' : 'bg-blue' }}">
                            {{ $company->tipo_contribuyente ?? '—' }}
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <div class="data-label">Estado SUNAT</div>
                        <span class="badge-exec 
                            @if($company->estado === 'ACTIVO') bg-emerald
                            @elseif($company->estado === 'BAJA') bg-rose
                            @else bg-amber @endif">
                            {{ $company->estado }}
                        </span>
                    </div>
                    @if($company->direccion_fiscal)
                    <div class="col-12">
                        <div class="data-label">Domicilio Fiscal</div>
                        <div class="data-value">{{ $company->direccion_fiscal }}</div>
                    </div>
                    @endif
                    <div class="col-sm-6 mt-4">
                        <div class="data-label">Responsable Registro</div>
                        <div class="data-value" style="font-size:0.8rem;"><i class="bi bi-person me-1 text-muted"></i>{{ $company->creator?->name ?? '—' }}</div>
                    </div>
                    <div class="col-sm-6 mt-4">
                        <div class="data-label">Fecha Creación</div>
                        <div class="data-value" style="font-size:0.8rem;"><i class="bi bi-calendar3 me-1 text-muted"></i>{{ $company->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Últimos accesos --}}
        <div class="exec-panel">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title">Historial de Accesos SOL</h6>
            </div>
            <div class="p-0">
                @forelse($recentLogs as $log)
                <div class="log-item">
                    <div style="width:32px;height:32px;border-radius:6px;display:flex;align-items:center;justify-content:center;
                        background:{{ $log->status === 'SUCCESS' ? '#f0fdf4' : '#fff1f2' }};
                        color:{{ $log->status === 'SUCCESS' ? '#059669' : '#e11d48' }};">
                        <i class="bi bi-{{ $log->status === 'SUCCESS' ? 'shield-check' : 'shield-x' }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:0.85rem;font-weight:600;color:#334155;">{{ $log->user?->name ?? 'Sistema' }}</div>
                        <div style="font-size:0.7rem;color:#64748b;">{{ $log->accessed_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                    <div class="text-end">
                        <span class="badge-exec {{ $log->status==='SUCCESS' ? 'bg-emerald' : 'bg-rose' }}" style="font-size:0.6rem; padding:0.2rem 0.4rem;">
                            {{ $log->status }}
                        </span>
                        @if($log->duration_seconds)
                        <div style="font-size:0.7rem;font-weight:600;color:#059669;margin-top:0.2rem;">{{ $log->duration_seconds }}s</div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">
                    <i class="bi bi-clock-history" style="font-size:2rem; opacity:0.5;"></i>
                    <div class="mt-2" style="font-size:0.8rem; font-weight:500;">No hay accesos registrados en el sistema</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Credencial SOL --}}
        <div class="exec-panel" style="border-top: 3px solid {{ $company->solCredential ? '#3b82f6' : '#e2e8f0' }};">
            <div class="exec-panel-header">
                <h6 class="exec-panel-title">Módulo de Autenticación</h6>
            </div>
            <div class="exec-panel-body">
                @if($company->solCredential)
                    @php $ownsCredential = auth()->user()->isAsistente() && auth()->id() === $company->solCredential->created_by; @endphp
                    @if($ownsCredential)
                    <div class="mb-4">
                        <div class="data-label">Usuario SOL</div>
                        <div class="data-value ruc" style="font-size:0.9rem;">{{ $company->solCredential->usuario_sol }}</div>
                    </div>
                    <div class="mb-4">
                        <div class="data-label">Clave SOL</div>
                        <div class="data-value" style="font-size:1.2rem; letter-spacing:0.2em; line-height:1;">••••••••</div>
                        <div style="font-size:0.65rem;color:#64748b;margin-top:0.3rem;"><i class="bi bi-lock me-1"></i>Tokenizada con AES-256</div>
                    </div>

                    @if($company->estado === 'ACTIVO')
                    <div class="mt-4 pt-3 border-top" x-data="solSimulation({{ $company->id }}, '{{ $company->razon_social }}', '{{ $company->ruc }}')" x-cloak>
                        <button @click="start()" class="btn-sol" :disabled="loading">
                            <span x-show="!loading"><i class="bi bi-box-arrow-in-right"></i> Ejecutar Acceso SOL</span>
                            <span x-show="loading"><span class="spinner-border spinner-border-sm" style="width:14px;height:14px;"></span> Conectando...</span>
                        </button>
                        @include('partials.sol-modal')
                    </div>
                    @else
                    <div class="mt-4 pt-3 border-top text-center" style="font-size:0.8rem; color:#e11d48; font-weight:500;">
                        La empresa no está activa. No se puede acceder al Menú SOL.
                    </div>
                    @endif
                    @else
                    {{-- Credencial registrada por otro usuario — acceso restringido --}}
                    <div class="mb-4">
                        <div class="data-label">Usuario SOL</div>
                        <div class="data-value ruc" style="font-size:0.9rem; color:#94a3b8; letter-spacing:0.15em;">••••••••</div>
                    </div>
                    <div class="mb-4">
                        <div class="data-label">Clave SOL</div>
                        <div class="data-value" style="font-size:1.2rem; letter-spacing:0.2em; line-height:1;">••••••••</div>
                        <div style="font-size:0.65rem;color:#64748b;margin-top:0.3rem;"><i class="bi bi-lock me-1"></i>Tokenizada con AES-256</div>
                    </div>
                    <div class="mt-4 pt-3 border-top text-center py-3" style="background:#f8fafc; border-radius:8px;">
                        <i class="bi bi-shield-lock-fill" style="font-size:1.8rem; color:#94a3b8; display:block; margin-bottom:0.5rem;"></i>
                        <div style="font-size:0.8rem; color:#475569; font-weight:600;">Credencial protegida</div>
                        <div style="font-size:0.72rem; color:#64748b; margin-top:0.25rem;">Solo visible para el asistente asignado</div>
                    </div>
                    @endif
                @else
                    @php $canAddCredential = $company->created_by === auth()->id(); @endphp
                    @if($canAddCredential)
                    <form method="POST" action="{{ route('companies.storeCredential', $company) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="data-label d-block mb-1">Usuario SOL</label>
                            <input type="text" name="usuario_sol"
                                class="form-control font-monospace @error('usuario_sol') is-invalid @enderror"
                                value="{{ old('usuario_sol') }}" placeholder="Ej: 20100066" maxlength="8"
                                style="font-size:0.85rem;" autocomplete="off">
                            @error('usuario_sol')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="data-label d-block mb-1">Clave SOL</label>
                            <input type="password" name="clave_sol"
                                class="form-control @error('clave_sol') is-invalid @enderror"
                                placeholder="Clave SOL" minlength="4"
                                style="font-size:0.85rem;" autocomplete="new-password">
                            @error('clave_sol')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text" style="font-size:0.65rem;"><i class="bi bi-lock me-1"></i>Se guarda cifrada con AES-256.</div>
                        </div>
                        <button type="submit" class="btn-exec-primary w-100">
                            <i class="bi bi-key me-2"></i>Guardar Credencial
                        </button>
                    </form>
                    @else
                    <div class="text-center py-4">
                        <i class="bi bi-shield-lock" style="font-size:2.5rem;color:#cbd5e1;display:block;margin-bottom:1rem;"></i>
                        <div style="font-size:0.85rem;color:#475569;font-weight:600;">Sin credenciales configuradas</div>
                        <div style="font-size:0.75rem;color:#64748b;">Contacte al administrador para habilitar el acceso SOL.</div>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function solSimulation(companyId, companyName, ruc) {
    return {
        companyId, companyName, ruc,
        open: false, loading: false, completed: false,
        steps: @json(config('sol.simulation_steps')),
        currentStep: -1,
        durationText: '', savedText: '',
        logId: null,
        async start() {
            this.open = true; this.loading = true; this.completed = false; this.currentStep = -1;
            try {
                const res = await fetch(`/sol/${this.companyId}/access`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json' }
                });
                const data = await res.json();
                if (!data.success) { alert(data.message); this.open = false; this.loading = false; return; }
                this.logId = data.log_id;
                const t0 = performance.now();
                this.loading = false;
                for (let i = 0; i < this.steps.length; i++) {
                    this.currentStep = i;
                    await new Promise(r => setTimeout(r, this.steps[i].duration_ms));
                }
                this.currentStep = this.steps.length;
                const ms = Math.round(performance.now() - t0);
                this.durationText = `${(ms/1000).toFixed(2)}s`;
                this.savedText = `${(30 - ms/1000).toFixed(2)}s`;
                this.completed = true;
                await fetch(`/sol/${this.logId}/complete`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json' },
                    body: JSON.stringify({ duration_ms: ms, steps_completed: this.steps.length })
                });
            } catch(e) { alert('Error en simulación'); this.open = false; this.loading = false; }
        }
    };
}
</script>
@endpush
