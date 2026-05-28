<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PcpartsVes - @yield('title','Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --sidebar-w: 240px; --sidebar-bg: #1a1a2e; --accent: #e94560; }

        body { background: #f0f2f5; }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1045;
            display: flex;
            flex-direction: column;
            transition: transform .28s ease;
        }
        .sidebar .brand {
            padding: 18px 16px;
            color: var(--accent);
            font-weight: 700;
            font-size: 1.15rem;
            border-bottom: 1px solid #16213e;
            white-space: nowrap;
        }
        .sidebar .nav-link {
            color: #a8b2d8;
            padding: 10px 16px;
            border-radius: 6px;
            margin: 2px 8px;
            transition: all .2s;
            white-space: nowrap;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active { background: var(--accent); color: #fff; }
        .sidebar .nav-link i { margin-right: 8px; }

        /* ── Overlay (mobile) ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 1044;
        }
        .sidebar-overlay.show { display: block; }

        /* ── Main content ── */
        .main-content {
            margin-left: var(--sidebar-w);
            padding: 20px;
            min-height: 100vh;
            transition: margin .28s ease;
        }

        /* ── Topbar ── */
        .topbar {
            background: #fff;
            border-radius: 10px;
            padding: 10px 16px;
            margin-bottom: 20px;
            box-shadow: 0 1px 4px rgba(0,0,0,.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .topbar .page-title { font-weight: 700; font-size: 1rem; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        /* ── Misc ── */
        .stat-card { border-radius: 12px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .toast-container { position: fixed; top: 16px; right: 16px; z-index: 9999; min-width: 260px; max-width: 90vw; }

        /* ── Mobile (< 992px) ── */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        /* ── Extra small tweaks ── */
        @media (max-width: 575.98px) {
            .main-content { padding: 12px; }
            .topbar { padding: 8px 12px; }
            .stat-card .card-body { padding: 14px; }
            .stat-card .fs-1 { font-size: 1.8rem !important; }
            .stat-card .fs-2 { font-size: 1.4rem !important; }
        }
    </style>
</head>
<body>

<!-- Sidebar overlay (mobile tap-to-close) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="brand d-flex align-items-center justify-content-between">
        <span><i class="bi bi-cpu-fill"></i> PcpartsVes</span>
        <button class="btn btn-sm text-white d-lg-none p-0 border-0" onclick="closeSidebar()" style="font-size:1.2rem;background:none">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <nav class="nav flex-column mt-3 flex-grow-1">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Users
        </a>
        <a href="{{ route('pcparts.index') }}" class="nav-link {{ request()->routeIs('pcparts.*') ? 'active' : '' }}">
            <i class="bi bi-motherboard-fill"></i> PC Parts
        </a>
        <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profile
        </a>
    </nav>
    <div class="p-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-danger btn-sm w-100">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </div>
</div>

<!-- Main -->
<div class="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-2 overflow-hidden">
            <!-- Hamburger (mobile only) -->
            <button class="btn btn-sm btn-outline-secondary d-lg-none flex-shrink-0" onclick="openSidebar()">
                <i class="bi bi-list fs-5"></i>
            </button>
            <h5 class="page-title">@yield('title','Dashboard')</h5>
        </div>
        <div class="d-flex align-items-center gap-2 flex-shrink-0">
            @if(auth()->user()->profile_picture)
                <img src="{{ Storage::url(auth()->user()->profile_picture) }}"
                     class="rounded-circle flex-shrink-0" width="34" height="34" style="object-fit:cover">
            @else
                <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:34px;height:34px;font-weight:700;font-size:.85rem">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
            @endif
            <span class="fw-semibold d-none d-sm-inline text-truncate" style="max-width:140px">
                {{ auth()->user()->name }}
            </span>
        </div>
    </div>

    @yield('content')
</div>

<!-- Toasts -->
<div class="toast-container">
    @foreach(['toast_success'=>'success','toast_error'=>'danger','toast_info'=>'info'] as $key=>$type)
        @if(session($key))
        <div class="toast align-items-center text-bg-{{ $type }} border-0 show mb-2"
             role="alert" data-bs-autohide="true" data-bs-delay="4000">
            <div class="d-flex">
                <div class="toast-body">{{ session($key) }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @endif
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    document.querySelectorAll('.toast').forEach(el => new bootstrap.Toast(el).show());

    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebarOverlay').classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('show');
        document.body.style.overflow = '';
    }
</script>
@yield('scripts')
</body>
</html>
