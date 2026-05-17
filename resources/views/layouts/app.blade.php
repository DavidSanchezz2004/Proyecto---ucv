<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SOL-Access Manager') — Sistema de Automatización SUNAT</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Montserrat Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 250px;
            --primary: #1e293b; /* Darker, executive slate */
            --primary-dark: #0f172a;
            --accent: #2c7be5; /* Falcon blue */
            --bg-color: #f8fafc;
            --text-main: #334155;
            --text-muted: #64748b;
        }
        body { 
            font-family: 'Montserrat', sans-serif; 
            background: var(--bg-color); 
            font-size: 0.85rem; 
            color: var(--text-main);
        }

        /* Executive Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #0f172a; /* Deep slate */
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
            box-shadow: 4px 0 24px rgba(0,0,0,0.05);
        }
        .sidebar-brand-wrapper {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .sidebar-brand-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }
        .sidebar-brand-text h5 {
            color: #f8fafc;
            font-size: 1.05rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.02em;
        }
        .sidebar-brand-text small {
            color: #64748b;
            font-size: 0.65rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        /* Custom Scrollbar */
        .sidebar-menu::-webkit-scrollbar { width: 4px; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .nav-section {
            color: #475569;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 1rem 0 0.5rem 0.75rem;
        }
        .nav-section:first-child { margin-top: 0; }

        .nav-link {
            color: #94a3b8;
            padding: 0.65rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .nav-link i {
            font-size: 1.1rem;
            color: #64748b;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
        }
        .nav-link:hover {
            color: #f8fafc;
            background: rgba(255,255,255,0.03);
        }
        .nav-link:hover i { color: #cbd5e1; }
        
        .nav-link.active {
            color: #fff;
            background: rgba(59, 130, 246, 0.15); /* Sleek blue highlight */
            font-weight: 600;
        }
        .nav-link.active i { color: #60a5fa; }

        .sidebar-user {
            padding: 1.25rem 1rem;
            background: #0b1121; /* Slightly darker than sidebar */
            border-top: 1px solid rgba(255,255,255,0.05);
            margin-top: auto;
        }
        .user-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        .user-avatar {
            width: 36px;
            height: 36px;
            background: #1e293b;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 1.1rem;
        }
        .user-info-text { overflow: hidden; }
        .user-name {
            color: #f8fafc;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0.1rem;
        }
        .user-role {
            color: #64748b;
            font-size: 0.7rem;
            font-weight: 500;
        }
        .btn-logout {
            width: 100%;
            padding: 0.5rem;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 6px;
            color: #94a3b8;
            font-size: 0.8rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        /* Main content */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 500;
        }
        .topbar .page-title { font-size: 1.1rem; font-weight: 600; color: #1e293b; letter-spacing: -0.01em; }
        .topbar .user-info small { color: #64748b; font-size: 0.75rem; }

        /* Tables & Badges from original layout */
        .table th { font-size: 12px; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; }
        .table td { vertical-align: middle; }

        .badge-admin      { background: #eff6ff; color: #2563eb; }
        .badge-supervisor { background: #f0fdf4; color: #059669; }
        .badge-asistente  { background: #fffbeb; color: #d97706; }

        .page-content { padding: 1.5rem; }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }

        /* ── Tour / Coach Marks ─────────────────── */
        .tour-overlay {
            position:fixed;inset:0;background:rgba(15,23,42,.55);
            backdrop-filter:blur(3px);z-index:1050;opacity:0;pointer-events:none;
            transition:opacity .25s ease;
        }
        .tour-overlay.tour-show{opacity:1;pointer-events:auto;}
        .tour-popover {
            position:fixed;width:min(365px,calc(100vw - 28px));
            background:#0f172a;border:1px solid rgba(255,255,255,.07);
            border-radius:18px;padding:20px 20px 16px;
            box-shadow:0 32px 64px rgba(0,0,0,.45),0 0 0 1px rgba(255,255,255,.04);
            z-index:1060;opacity:0;pointer-events:none;
            transform:translateY(8px) scale(.97);
            transition:opacity .22s ease,transform .22s ease;
            font-family:'Montserrat',sans-serif;
        }
        .tour-popover.tour-show{opacity:1;pointer-events:auto;transform:none;}
        .tour-popover::before{
            content:'';position:absolute;width:12px;height:12px;
            background:#0f172a;border-radius:2px;transform:rotate(45deg);
        }
        .tour-popover.arrow-left::before  {left:-5px;top:50%;margin-top:-6px;}
        .tour-popover.arrow-right::before {right:-5px;top:50%;margin-top:-6px;}
        .tour-popover.arrow-top::before   {left:28px;top:-5px;}
        .tour-popover.arrow-bottom::before{left:28px;bottom:-5px;}
        .tour-pov-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;}
        .tour-icon-box{
            width:36px;height:36px;border-radius:9px;
            background:rgba(59,130,246,.15);border:1px solid rgba(59,130,246,.22);
            display:flex;align-items:center;justify-content:center;color:#60a5fa;font-size:1rem;
        }
        .tour-close-btn{
            width:26px;height:26px;background:rgba(255,255,255,.06);border:none;
            border-radius:50%;color:#64748b;cursor:pointer;
            display:flex;align-items:center;justify-content:center;
            font-size:.85rem;transition:background .2s,color .2s;
        }
        .tour-close-btn:hover{background:rgba(255,255,255,.12);color:#f8fafc;}
        .tour-title{font-size:.95rem;font-weight:800;color:#f8fafc;letter-spacing:-.02em;margin-bottom:7px;line-height:1.3;}
        .tour-desc{font-size:.79rem;color:rgba(248,250,252,.72);line-height:1.65;margin-bottom:10px;}
        .tour-tip{
            background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.06);
            border-radius:8px;padding:8px 11px;font-size:.72rem;
            color:rgba(248,250,252,.55);line-height:1.55;margin-bottom:12px;
        }
        .tour-tip strong{color:#93c5fd;}
        .tour-footer{
            display:flex;align-items:center;justify-content:space-between;gap:10px;
            padding-top:12px;border-top:1px solid rgba(255,255,255,.05);
        }
        .tour-dots{display:flex;gap:4px;align-items:center;}
        .tour-dot{width:5px;height:5px;border-radius:50%;background:rgba(255,255,255,.18);transition:all .25s;}
        .tour-dot.active{background:#3b82f6;width:14px;border-radius:3px;}
        .tour-actions{display:flex;gap:6px;}
        .tour-btn{
            border:none;border-radius:999px;padding:7px 13px;
            font-size:.74rem;font-weight:700;font-family:'Montserrat',sans-serif;
            cursor:pointer;transition:all .2s;
            display:inline-flex;align-items:center;gap:4px;white-space:nowrap;
        }
        .tour-btn:hover:not(:disabled){transform:translateY(-1px);}
        .tour-btn:disabled{opacity:.35;cursor:not-allowed;transform:none!important;}
        .tour-btn-ghost  {background:rgba(255,255,255,.07);color:rgba(248,250,252,.75);}
        .tour-btn-primary{background:#2c7be5;color:#fff;}
        .tour-btn-success{background:#059669;color:#fff;}
        .tour-highlighted{
            position:relative!important;z-index:1055!important;
            box-shadow:0 0 0 3px rgba(44,123,229,.5),0 0 0 8px rgba(44,123,229,.14),
                       0 20px 40px rgba(0,0,0,.18)!important;
            border-radius:8px;transform:scale(1.008)!important;
            transition:box-shadow .3s,transform .25s!important;
        }
        .tour-trigger-btn{
            width:30px;height:30px;background:transparent;border:1px solid #e2e8f0;
            border-radius:7px;display:inline-flex;align-items:center;justify-content:center;
            color:#94a3b8;font-size:.85rem;cursor:pointer;transition:all .2s;
            margin-left:.5rem;flex-shrink:0;
        }
        .tour-trigger-btn:hover{background:#eff6ff;color:#2c7be5;border-color:#2c7be5;}
    </style>
    @stack('styles')
</head>
<body>

<!-- Executive Sidebar -->
<nav id="sidebar">
    <div class="sidebar-brand-wrapper">
        <div class="sidebar-brand-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <div class="sidebar-brand-text">
            <h5>SOL-Access</h5>
            <small>Investigación UCV</small>
        </div>
    </div>

    <div class="sidebar-menu">
        <span class="nav-section">Principal</span>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>

        <span class="nav-section">Gestión</span>
        @if(auth()->user()->hasRole('admin', 'supervisor') || auth()->user()->isAsistente())
        <a href="{{ route('companies.index') }}" class="nav-link {{ request()->routeIs('companies.*') ? 'active' : '' }}">
            <i class="bi bi-buildings"></i> Empresas
        </a>
        @endif

        @if(auth()->user()->isAdmin())
        <a href="{{ route('sol-credentials.index') }}" class="nav-link {{ request()->routeIs('sol-credentials.*') ? 'active' : '' }}">
            <i class="bi bi-key"></i> Credenciales SOL
        </a>
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Usuarios
        </a>
        @endif

        <span class="nav-section">Análisis Operativo</span>
        @if(auth()->user()->isAsistente())
        <a href="{{ route('access-logs.index') }}" class="nav-link {{ request()->routeIs('access-logs.*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Mis Accesos
        </a>
        <a href="{{ route('reports.efficiency') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow"></i> Mi Eficiencia
        </a>
        @else
        <a href="{{ route('access-logs.index') }}" class="nav-link {{ request()->routeIs('access-logs.*') ? 'active' : '' }}">
            <i class="bi bi-list-columns-reverse"></i> Logs de Accesos
        </a>
        <a href="{{ route('reports.efficiency') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i> Eficiencia
        </a>
        @endif

        <span class="nav-section">Investigación</span>
        <a href="{{ route('research.about') }}" class="nav-link {{ request()->routeIs('research.about') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Sobre el estudio
        </a>
        <a href="{{ route('research.team') }}" class="nav-link {{ request()->routeIs('research.team') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Equipo
        </a>
        <a href="{{ route('survey.index') }}" class="nav-link {{ request()->routeIs('survey.index') ? 'active' : '' }}">
            <i class="bi bi-clipboard2-data"></i> Piloto Likert
        </a>
        @if(auth()->user()->hasRole('admin', 'supervisor'))
        <a href="{{ route('survey.results') }}" class="nav-link {{ request()->routeIs('survey.results') ? 'active' : '' }}">
            <i class="bi bi-pie-chart"></i> Resultados
        </a>
        @endif
    </div>

    <div class="sidebar-user">
        <div class="user-card">
            <div class="user-avatar">
                <i class="bi bi-person"></i>
            </div>
            <div class="user-info-text">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ auth()->user()->role?->display_name }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </button>
        </form>
    </div>
</nav>

<!-- Main Content -->
<div id="main-content">
    <div class="topbar">
        <div>
            <button class="btn btn-sm btn-light d-md-none me-2" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <span class="page-title">@yield('page-title', 'Panel')</span>
            <button type="button" class="tour-trigger-btn" data-tour-start title="Guía de uso">
                <i class="bi bi-map"></i>
            </button>
        </div>
        <div class="user-info text-end d-none d-md-block">
            <div style="font-size:13px;font-weight:600">{{ auth()->user()->name }}</div>
            <small>
                <span class="badge rounded-pill
                    @if(auth()->user()->isAdmin()) badge-admin
                    @elseif(auth()->user()->isSupervisor()) badge-supervisor
                    @else badge-asistente @endif" style="font-size:10px">
                    {{ auth()->user()->role?->display_name }}
                </span>
            </small>
        </div>
    </div>

    <div class="page-content">
        @include('partials.alerts')
        @yield('content')
    </div>
</div>

<!-- Bootstrap JS + Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js" defer></script>

<script>
document.getElementById('sidebarToggle')?.addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('show');
});
</script>

@include('partials.tour')
@stack('scripts')
</body>
</html>
