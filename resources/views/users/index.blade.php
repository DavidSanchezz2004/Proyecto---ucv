@extends('layouts.app')

@section('title', 'Usuarios')
@section('page-title', 'Directorio de Personal')

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
.badge-exec.bg-emerald { background: #f0fdf4; color: #059669; }
.badge-exec.bg-slate { background: #f1f5f9; color: #475569; }
.badge-exec.bg-rose { background: #fff1f2; color: #e11d48; }

.user-avatar-exec {
    width: 32px; height: 32px;
    background: #eff6ff; color: #2563eb;
    border-radius: 8px; /* Square with rounded corners instead of circle */
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem; font-weight: 700;
    font-family: 'Montserrat', sans-serif;
}

.search-bar-exec {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 0.4rem 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    width: 300px;
}
.search-bar-exec input {
    border: none;
    background: transparent;
    font-size: 0.85rem;
    color: #1e293b;
    width: 100%;
    outline: none;
}
.search-bar-exec i { color: #94a3b8; }
</style>
@endpush

@section('content')
<div class="exec-header">
    <div>
        <h5 class="exec-header-title">Gestión de Usuarios</h5>
        <div class="exec-header-subtitle">Control de accesos y roles del sistema operativo</div>
    </div>
    <a href="{{ route('users.create') }}" class="btn-exec-primary">
        <i class="bi bi-person-plus me-2"></i>Registrar Personal
    </a>
</div>

<div class="exec-panel">
    <div class="exec-panel-header" style="padding: 1rem 1.5rem;">
        <form method="GET" class="d-flex align-items-center gap-3">
            <div class="search-bar-exec">
                <i class="bi bi-search"></i>
                <input type="text" name="q" placeholder="Buscar por nombre o correo electrónico..." value="{{ request('q') }}">
            </div>
            <button type="submit" class="btn-exec-primary py-1 px-3" style="font-size:0.8rem;">Buscar</button>
            <a href="{{ route('users.index') }}" class="text-muted" style="font-size:0.8rem; text-decoration:none;">Limpiar</a>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-exec mb-0">
            <thead>
                <tr>
                    <th>Colaborador</th>
                    <th>Credencial (Correo)</th>
                    <th>Nivel de Acceso</th>
                    <th>Estado Operativo</th>
                    <th>T&amp;C</th>
                    <th>Último Login</th>
                    <th class="text-end">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="user-avatar-exec">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div style="font-size:0.85rem; font-weight:600; color:#1e293b;">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td style="font-size:0.8rem; color:#475569;">{{ $user->email }}</td>
                    <td>
                        <span class="badge-exec 
                            @if($user->role?->name === 'admin') badge-admin
                            @elseif($user->role?->name === 'supervisor') badge-supervisor
                            @else badge-asistente @endif" style="font-size:0.6rem;">
                            {{ $user->role?->display_name ?? '—' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($user->is_active)
                                <span class="badge-exec bg-emerald"><i class="bi bi-check-circle"></i> Activo</span>
                            @else
                                <span class="badge-exec bg-slate"><i class="bi bi-dash-circle"></i> Inactivo</span>
                            @endif
                            
                            @if($user->isLocked())
                                <span class="badge-exec bg-rose"><i class="bi bi-lock-fill"></i> Bloqueado</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($user->terms_accepted_at)
                            <span class="badge-exec bg-emerald" title="Aceptados el {{ $user->terms_accepted_at->format('d M Y, H:i') }}&#10;IP: {{ $user->terms_accepted_ip ?? '—' }}">
                                <i class="bi bi-check-circle"></i> Aceptó
                            </span>
                            <div style="font-size:0.65rem; color:#64748b; margin-top:2px;">{{ $user->terms_accepted_at->format('d/m/Y') }}</div>
                        @else
                            <span class="badge-exec bg-slate"><i class="bi bi-dash-circle"></i> Pendiente</span>
                        @endif
                    </td>
                    <td style="font-size:0.75rem; color:#64748b; font-weight:500;">
                        {{ $user->last_login_at ? $user->last_login_at->format('d M Y, H:i') : 'Nunca' }}
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('users.edit', $user) }}" class="btn-action-icon" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('users.toggle', $user) }}" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-action-icon" 
                                    style="color: {{ $user->is_active ? '#d97706' : '#059669' }}"
                                    title="{{ $user->is_active ? 'Desactivar Cuenta' : 'Activar Cuenta' }}">
                                    <i class="bi bi-{{ $user->is_active ? 'person-dash' : 'person-check' }}"></i>
                                </button>
                            </form>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline"
                                onsubmit="return confirm('¿Eliminar al usuario {{ addslashes($user->name) }} del sistema?')">
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
                        <i class="bi bi-people text-muted" style="font-size:2.5rem; opacity:0.5;"></i>
                        <div class="mt-2 text-muted" style="font-size:0.85rem; font-weight:500;">No se encontraron usuarios en la plataforma</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-4 py-3 border-top">{{ $users->links() }}</div>
    @endif
</div>
@endsection
