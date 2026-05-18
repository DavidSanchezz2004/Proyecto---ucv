@extends('layouts.app')

@section('title', 'Nueva Empresa')
@section('page-title', 'Nueva Empresa')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-building-add me-2 text-primary"></i>Registrar nueva empresa</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('companies.store') }}">
                    @csrf
                    <div class="mb-3" id="tour-field-ruc">
                        <label class="form-label fw-semibold">RUC <span class="text-danger">*</span></label>
                        <input type="text" name="ruc" class="form-control font-monospace @error('ruc') is-invalid @enderror"
                            value="{{ old('ruc') }}" placeholder="Ej: 20100066608" maxlength="11"
                            pattern="\d{11}" title="El RUC debe tener exactamente 11 dígitos">
                        @error('ruc')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Debe tener exactamente 11 dígitos numéricos.</div>
                    </div>

                    <div class="mb-3" id="tour-field-razon">
                        <label class="form-label fw-semibold">Razón Social <span class="text-danger">*</span></label>
                        <input type="text" name="razon_social" class="form-control @error('razon_social') is-invalid @enderror"
                            value="{{ old('razon_social') }}" placeholder="Nombre o denominación social" maxlength="255">
                        @error('razon_social')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3" id="tour-field-tipos">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tipo de Contribuyente</label>
                            <select name="tipo_contribuyente" class="form-select @error('tipo_contribuyente') is-invalid @enderror">
                                <option value="">Seleccionar...</option>
                                <option value="PERSONA NATURAL"  {{ old('tipo_contribuyente') === 'PERSONA NATURAL'  ? 'selected' : '' }}>Persona Natural</option>
                                <option value="PERSONA JURIDICA" {{ old('tipo_contribuyente') === 'PERSONA JURIDICA' ? 'selected' : '' }}>Persona Jurídica</option>
                                <option value="EMPRESA"          {{ old('tipo_contribuyente') === 'EMPRESA'          ? 'selected' : '' }}>Empresa</option>
                            </select>
                            @error('tipo_contribuyente')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                            <select name="estado" class="form-select @error('estado') is-invalid @enderror">
                                <option value="ACTIVO"     {{ old('estado','ACTIVO') === 'ACTIVO'     ? 'selected' : '' }}>Activo</option>
                                <option value="BAJA"       {{ old('estado') === 'BAJA'       ? 'selected' : '' }}>Baja</option>
                                <option value="SUSPENSION" {{ old('estado') === 'SUSPENSION' ? 'selected' : '' }}>Suspensión</option>
                            </select>
                            @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4" id="tour-field-address">
                        <label class="form-label fw-semibold">Dirección Fiscal</label>
                        <textarea name="direccion_fiscal" class="form-control @error('direccion_fiscal') is-invalid @enderror"
                            rows="2" placeholder="Dirección registrada en SUNAT">{{ old('direccion_fiscal') }}</textarea>
                        @error('direccion_fiscal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Credenciales SOL accordion --}}
                    {{-- id used by tour --}}
                    @php $solOpen = $errors->hasAny(['usuario_sol','clave_sol']) || old('usuario_sol'); @endphp
                    <div class="mb-4" id="tour-sol-section">
                        <button type="button"
                            class="d-flex align-items-center justify-content-between w-100 text-start px-3 py-2 rounded border {{ $solOpen ? 'border-primary bg-primary bg-opacity-10' : 'border-secondary-subtle bg-light' }}"
                            style="font-size:0.85rem;font-weight:600;color:{{ $solOpen ? '#0d6efd' : '#475569' }};cursor:pointer;"
                            data-bs-toggle="collapse" data-bs-target="#solFields" aria-expanded="{{ $solOpen ? 'true' : 'false' }}">
                            <span><i class="bi bi-key me-2"></i>Agregar credenciales SOL <span style="font-weight:400;font-size:0.75rem;">(opcional)</span></span>
                            <i class="bi bi-chevron-down" style="transition:transform .2s;{{ $solOpen ? 'transform:rotate(180deg)' : '' }}"></i>
                        </button>
                        <div id="solFields" class="collapse {{ $solOpen ? 'show' : '' }}">
                            <div class="border border-top-0 rounded-bottom p-3" style="background:#f8fafc;">
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold" style="font-size:0.8rem;">Usuario SOL</label>
                                        <input type="text" name="usuario_sol"
                                            class="form-control font-monospace @error('usuario_sol') is-invalid @enderror"
                                            value="{{ old('usuario_sol') }}" placeholder="Ej: 20100066" maxlength="8"
                                            style="font-size:0.85rem;" autocomplete="off">
                                        @error('usuario_sol')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <div class="form-text" style="font-size:0.7rem;">Máximo 8 caracteres (SUNAT)</div>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label fw-semibold" style="font-size:0.8rem;">Clave SOL</label>
                                        <input type="password" name="clave_sol"
                                            class="form-control @error('clave_sol') is-invalid @enderror"
                                            placeholder="Clave SOL" minlength="4"
                                            style="font-size:0.85rem;" autocomplete="new-password">
                                        @error('clave_sol')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <div class="form-text" style="font-size:0.7rem;">Se guarda cifrada. No se muestra nunca.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- REQ 1: Alerta informativa de responsabilidad --}}
                    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:1rem 1.1rem;margin-bottom:1.25rem;display:flex;gap:0.85rem;align-items:flex-start;">
                        <i class="bi bi-shield-check" style="color:#2563eb;font-size:1.15rem;flex-shrink:0;margin-top:1px;"></i>
                        <div>
                            <div style="font-size:0.8rem;font-weight:700;color:#1e40af;margin-bottom:0.25rem;">Registro bajo responsabilidad del usuario autorizado</div>
                            <div style="font-size:0.75rem;color:#3b5cb8;line-height:1.55;">
                                La información ingresada será utilizada únicamente para gestionar el acceso dentro del sistema.
                                El equipo de investigación <strong>no accede, no visualiza ni administra</strong> credenciales tributarias de los contribuyentes.
                                No registre datos de empresas o contribuyentes si no cuenta con autorización.
                            </div>
                        </div>
                    </div>

                    {{-- REQ 2: Checkbox obligatorio de autorización --}}
                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="authorization" id="authorization" value="1"
                                class="form-check-input @error('authorization') is-invalid @enderror"
                                {{ old('authorization') ? 'checked' : '' }}>
                            <label class="form-check-label" for="authorization" style="font-size:0.8rem;color:#374151;">
                                Declaro que cuento con autorización para registrar esta empresa y, si corresponde, sus credenciales de acceso.
                            </label>
                            @error('authorization')
                                <div class="invalid-feedback" style="font-size:0.75rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Guardar empresa
                        </button>
                        <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
SOLTour.init({
    pageKey: 'companies_create',
    autoStart: true,
    steps: [
        {
            target: '#tour-field-ruc',
            icon: 'upc-scan',
            title: 'RUC de la empresa',
            desc: 'Ingresa los 11 dígitos del RUC exactamente como aparece en los documentos tributarios. No uses guiones ni espacios.',
            tip: 'Puedes verificar el RUC en el portal de consulta de SUNAT si no lo tienes a mano.',
            arrow: 'top'
        },
        {
            target: '#tour-field-razon',
            icon: 'building',
            title: 'Nombre de la empresa',
            desc: 'Escribe el nombre oficial tal como está registrado en SUNAT. Puede ser el nombre completo de una persona o la razón social de una empresa.',
            arrow: 'top'
        },
        {
            target: '#tour-field-tipos',
            icon: 'tags',
            title: 'Tipo y estado',
            desc: 'Indica si es persona natural (una persona como tú), persona jurídica (empresa con RUC de 20...) o empresa en general. El estado muestra si está activa en SUNAT.',
            arrow: 'top'
        },
        {
            target: '#tour-field-address',
            icon: 'geo-alt',
            title: 'Dirección fiscal',
            desc: 'Es la dirección que la empresa tiene registrada ante SUNAT. Este campo es opcional pero te ayuda a tener el perfil completo de la empresa.',
            arrow: 'top'
        },
        {
            target: '#tour-sol-section',
            icon: 'key',
            title: 'Credenciales SOL',
            desc: 'Si ya tienes el usuario y clave SOL de esta empresa, agrégalos aquí haciendo clic en el botón para desplegar el formulario. Con esto el botón de acceso automático quedará habilitado.',
            tip: 'Las credenciales se guardan de forma cifrada. Nunca se muestran en pantalla.',
            arrow: 'top'
        }
    ]
});
</script>
@endpush
@endsection
