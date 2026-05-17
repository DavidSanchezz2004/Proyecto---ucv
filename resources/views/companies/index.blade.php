@extends('layouts.app')

@section('title', 'Empresas')
@section('page-title', 'Gestión de Contribuyentes')

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

.exec-filter-bar {
    background: #fff;
    border-radius: 8px;
    padding: 1rem 1.5rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    margin-bottom: 1.5rem;
}
.form-control-exec, .form-select-exec {
    font-family: 'Montserrat', sans-serif;
    font-size: 0.85rem;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    color: #334155;
}
.form-control-exec:focus, .form-select-exec:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
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
}
.btn-exec-outline:hover { background: #f8fafc; color: #1e293b; border-color: #94a3b8; }

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

/* Botón Menú SOL */
.btn-sol {
    background: transparent;
    color: #2c7be5; /* Azul corporativo */
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.4rem 0.85rem;
    border-radius: 6px;
    border: 1px solid #2c7be5;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    cursor: pointer;
}
.btn-sol:hover:not(:disabled) {
    background: #2c7be5;
    color: #fff;
    box-shadow: 0 4px 12px rgba(44, 123, 229, 0.2);
}
.btn-sol:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    border-color: #cbd5e1;
    color: #64748b;
}

/* Redesigned Modal */
.sol-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15, 23, 42, 0.5); /* Slate transparent backdrop */
    backdrop-filter: blur(4px);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
}
.exec-modal-content {
    background: #fff;
    border-radius: 12px;
    padding: 2.5rem;
    width: 100%;
    max-width: 480px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    border: 1px solid #e2e8f0;
}
.digit-btn {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 38px; height: 34px; padding: 0 10px;
    border-radius: 6px; font-size: 0.8rem; font-weight: 600;
    background: #f1f5f9; color: #475569;
    text-decoration: none; border: 1px solid #e2e8f0;
    transition: all 0.15s;
}
.digit-btn:hover { background: #e2e8f0; color: #1e293b; }
.digit-btn-active { background: #1e293b !important; color: #fff !important; border-color: #1e293b !important; }
</style>
@endpush

@section('content')
<div class="exec-header">
    <div>
        <h5 class="exec-header-title">Directorio de Empresas</h5>
        <div class="exec-header-subtitle">Gestión unificada de entidades y accesos al Menu SOL</div>
    </div>
    <a href="{{ route('companies.create') }}" class="btn-exec-primary text-decoration-none" id="tour-new-btn">
        <i class="bi bi-plus-lg me-2"></i>Nueva Empresa
    </a>
</div>

{{-- Filtro por último dígito RUC --}}
<div class="exec-filter-bar mb-2" id="tour-digit-bar">
    <div style="font-size:0.7rem;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.6rem;">
        Filtrar por último dígito RUC
    </div>
    <div class="d-flex flex-wrap gap-1">
        @php $dActual = request('digito_ruc'); @endphp

        {{-- Botón Todos --}}
        <a href="{{ route('companies.index', array_merge(request()->except('digito_ruc','page'), [])) }}"
           class="digit-btn {{ !is_numeric($dActual) ? 'digit-btn-active' : '' }}">
            Todos
        </a>

        @for($d = 0; $d <= 9; $d++)
        <a href="{{ route('companies.index', array_merge(request()->except('digito_ruc','page'), ['digito_ruc' => $d])) }}"
           class="digit-btn {{ (string)$dActual === (string)$d ? 'digit-btn-active' : '' }}">
            {{ $d }}
        </a>
        @endfor
    </div>
</div>

{{-- Filtros --}}
<div class="exec-filter-bar" id="tour-search-bar">
    <form method="GET" class="row g-3 align-items-center">
        @if(is_numeric(request('digito_ruc')))
        <input type="hidden" name="digito_ruc" value="{{ request('digito_ruc') }}">
        @endif
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted" style="border-color:#cbd5e1;"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control form-control-exec border-start-0 ps-0" placeholder="Buscar por RUC o Razón Social..."
                    value="{{ request('q') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="estado" class="form-select form-select-exec">
                <option value="">Cualquier estado</option>
                <option value="ACTIVO"     {{ request('estado') === 'ACTIVO'     ? 'selected' : '' }}>Activo</option>
                <option value="BAJA"       {{ request('estado') === 'BAJA'       ? 'selected' : '' }}>Baja</option>
                <option value="SUSPENSION" {{ request('estado') === 'SUSPENSION' ? 'selected' : '' }}>Suspensión</option>
            </select>
        </div>
        <div class="col-auto d-flex gap-2">
            <button type="submit" class="btn-exec-primary">Filtrar</button>
            <a href="{{ route('companies.index') }}" class="btn-exec-outline text-decoration-none">Limpiar</a>
        </div>
    </form>
</div>

<div class="exec-panel" id="tour-companies-table">
    <div class="table-responsive">
        <table class="table table-exec mb-0">
            <thead>
                <tr>
                    <th>RUC</th>
                    <th>Razón Social</th>
                    <th>Clasificación</th>
                    <th>Estado</th>
                    <th>Credencial</th>
                    <th class="text-center">Automatización</th>
                    <th class="text-end">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                <tr>
                    <td>
                        <span class="font-monospace fw-semibold" style="color:#1e293b;">{{ $company->ruc }}</span>
                    </td>
                    <td>
                        <div style="font-weight:600; color:#334155;">{{ $company->razon_social }}</div>
                    </td>
                    <td>
                        <span class="badge-exec {{ $company->tipo_contribuyente === 'PERSONA NATURAL' ? 'bg-slate' : 'bg-blue' }}">
                            {{ $company->tipo_contribuyente ?? '—' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-exec 
                            @if($company->estado === 'ACTIVO') bg-emerald
                            @elseif($company->estado === 'BAJA') bg-rose
                            @else bg-amber @endif">
                            {{ $company->estado }}
                        </span>
                    </td>
                    <td>
                        @if($company->solCredential)
                            <span class="badge-exec bg-emerald" style="background:transparent; color:#059669; padding:0;">
                                <i class="bi bi-shield-check"></i> Activa
                            </span>
                        @else
                            <span class="badge-exec bg-slate" style="background:transparent; color:#94a3b8; padding:0;">
                                <i class="bi bi-shield-x"></i> Sin configurar
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($company->solCredential && $company->estado === 'ACTIVO')
                            <div x-data="solSimulation({{ $company->id }}, '{{ addslashes($company->razon_social) }}', '{{ $company->ruc }}')" x-cloak>
                                <button @click="start()" class="btn-sol" :disabled="loading"
                                    style="font-family:'Montserrat',sans-serif;letter-spacing:0.02em;">
                                    <span x-show="!loading"><i class="bi bi-box-arrow-in-right"></i> Menu  SOL</span>
                                    <span x-show="loading">
                                        <span class="spinner-border spinner-border-sm" style="width:11px;height:11px;border-width:2px;"></span> Conectando
                                    </span>
                                </button>

                                <div x-show="open" class="sol-overlay" @click.self="open=false" style="display:none">
                                    <div class="exec-modal-content text-start">
                                        {{-- Cabecera empresa --}}
                                        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
                                            <div style="width:40px;height:40px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                                <i class="bi bi-buildings" style="color:#64748b;font-size:18px"></i>
                                            </div>
                                            <div>
                                                <div style="font-size:1rem;font-weight:700;color:#1e293b" x-text="companyName"></div>
                                                <div style="font-size:0.75rem;color:#64748b;letter-spacing:0.05em;">RUC <span x-text="ruc" class="font-monospace"></span></div>
                                            </div>
                                        </div>

                                        <div style="font-size:0.8rem;font-weight:600;color:#475569;margin-bottom:1rem;text-transform:uppercase;letter-spacing:0.05em;">
                                            Secuencia de Automatización
                                        </div>

                                        {{-- Pasos --}}
                                        <div class="mb-4">
                                            <template x-for="(step, i) in steps" :key="i">
                                                <div class="d-flex align-items-center gap-3 py-2" style="font-size:0.85rem;font-weight:500;">
                                                    <div style="width:16px;display:flex;justify-content:center;">
                                                        <template x-if="currentStep > i">
                                                            <div class="step-indicator done"></div>
                                                        </template>
                                                        <template x-if="currentStep === i && !completed">
                                                            <div class="step-indicator active"></div>
                                                        </template>
                                                        <template x-if="currentStep < i">
                                                            <div class="step-indicator pending"></div>
                                                        </template>
                                                    </div>
                                                    <span :class="currentStep >= i ? 'text-dark' : 'text-muted'" x-text="step.label"></span>
                                                </div>
                                            </template>
                                        </div>

                                        {{-- Resultado --}}
                                        <div x-show="completed" style="display:none" x-transition.opacity>
                                            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:1rem;margin-bottom:1rem;">
                                                <div class="d-flex align-items-start gap-2">
                                                    <i class="bi bi-check2-circle" style="color:#059669;font-size:1.25rem;"></i>
                                                    <div>
                                                        <div style="font-size:0.85rem;font-weight:700;color:#065f46;margin-bottom:0.25rem;">Acceso Completado</div>
                                                        <div style="font-size:0.75rem;color:#166534;">
                                                            Tiempo de ejecución: <strong x-text="durationText"></strong><br>
                                                            Ahorro estimado: <strong x-text="savedText"></strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="font-size:0.7rem;color:#64748b;line-height:1.4;">
                                                <strong>Nota de Investigación:</strong> El sistema inyecta las credenciales cifradas y redirige al portal SUNAT en la pestaña abierta.
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4" x-show="completed" style="display:none">
                                            <button @click="open=false" class="btn-exec-outline w-100 text-center">Cerrar Panel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <span class="text-muted" style="font-size:0.75rem;font-weight:500;">
                                <i class="bi bi-lock"></i>
                                @if($company->estado !== 'ACTIVO') Inactiva @else Sin Credencial @endif
                            </span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('companies.show', $company) }}" class="btn-action-icon" title="Ver detalle">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->user()->isSupervisor() || $company->created_by === auth()->id())
                            <a href="{{ route('companies.edit', $company) }}" class="btn-action-icon" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('companies.destroy', $company) }}" class="d-inline"
                                onsubmit="return confirm('¿Eliminar registro corporativo de {{ addslashes($company->razon_social) }}?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action-icon" title="Eliminar" style="color:#e11d48;">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="bi bi-inbox text-muted" style="font-size:2.5rem; opacity:0.5;"></i>
                        <div class="mt-2 text-muted" style="font-size:0.85rem; font-weight:500;">No hay registros corporativos disponibles</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($companies->hasPages())
    <div class="px-4 py-3 border-top">{{ $companies->links() }}</div>
    @endif
</div>
@endsection

@push('scripts')
<script>
SOLTour.init({
    pageKey: 'companies',
    autoStart: true,
    steps: [
        {
            target: '#tour-new-btn',
            icon: 'building-add',
            title: 'Registrar una empresa',
            desc: 'Haz clic aquí para agregar una empresa nueva. Necesitarás el RUC de 11 dígitos y el nombre oficial tal como aparece en SUNAT.',
            arrow: 'bottom'
        },
        {
            target: '#tour-digit-bar',
            icon: 'hash',
            title: 'Filtrar por último dígito del RUC',
            desc: 'SUNAT divide las declaraciones por el último número del RUC. Usa estos botones para ver rápidamente las empresas que te corresponden atender en un día determinado.',
            tip: 'Por ejemplo, si hoy toca el dígito 3, haz clic en "3" y solo verás esas empresas.',
            arrow: 'top'
        },
        {
            target: '#tour-search-bar',
            icon: 'funnel',
            title: 'Buscar y filtrar',
            desc: 'Escribe el nombre o RUC de la empresa que buscas. También puedes filtrar por estado: Activo, Baja o Suspensión para encontrar lo que necesitas más rápido.',
            arrow: 'top'
        },
        {
            target: '#tour-companies-table',
            icon: 'table',
            title: 'Lista de empresas',
            desc: 'Aquí aparecen todas tus empresas. La columna "Credencial" muestra si ya tienen usuario y clave SOL configurados. Sin credencial, el botón de acceso no estará activo.',
            tip: 'El botón azul "Menú SOL" abre el portal de SUNAT automáticamente, sin que tengas que escribir usuario ni contraseña.',
            arrow: 'top'
        }
    ]
});
</script>
<script>
function solSimulation(companyId, companyName, ruc) {
    return {
        companyId,
        companyName,
        ruc,
        open:        false,
        loading:     false,
        completed:   false,
        steps:       @json(config('sol.simulation_steps')),
        currentStep: -1,
        startTime:   null,
        durationText: '',
        savedText:    '',
        logId:        null,

        async start() {
            // Reservar pestaña ahora (sincrónico = no bloqueada por popup blocker)
            // Se mantiene en blanco hasta que termine la animación
            const sunatTab = window.open('about:blank', '_blank');

            this.open      = true;
            this.loading   = true;
            this.completed = false;
            this.currentStep = -1;

            try {
                const res = await fetch(`/sol/${this.companyId}/access`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    }
                });
                const data = await res.json();

                if (!data.success) {
                    alert(data.message || 'Error al iniciar el acceso');
                    this.open    = false;
                    this.loading = false;
                    return;
                }

                this.logId     = data.log_id;
                this.startTime = performance.now();
                this.loading   = false;

                // Animar pasos
                for (let i = 0; i < this.steps.length; i++) {
                    this.currentStep = i;
                    await new Promise(r => setTimeout(r, this.steps[i].duration_ms));
                }
                this.currentStep = this.steps.length;

                const durationMs  = Math.round(performance.now() - this.startTime);
                const durationSec = (durationMs / 1000).toFixed(2);
                const saved       = Math.max(0, 30 - durationMs / 1000).toFixed(2);

                this.durationText = `${durationSec}s`;
                this.savedText    = `${saved}s`;
                this.completed    = true;

                // Animación terminada → navegar la pestaña reservada a SUNAT
                if (sunatTab) {
                    sunatTab.location.href = `/sol/${this.companyId}/launch/menu`;
                }

                // Registrar en el servidor
                await fetch(`/sol/${this.logId}/complete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        duration_ms:     durationMs,
                        steps_completed: this.steps.length,
                    })
                });

            } catch (e) {
                console.error(e);
                if (this.logId) {
                    await fetch(`/sol/${this.logId}/fail`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ error_message: 'Error en secuencia', steps_completed: this.currentStep })
                    });
                }
                alert('Error al conectar. Intente nuevamente.');
                this.open    = false;
                this.loading = false;
            }
        }
    };
}
</script>
@endpush
