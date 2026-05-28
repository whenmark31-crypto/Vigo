<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PcpartsVes - @yield('title','Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .sidebar {
            width: 240px; min-height: 100vh; background: #1a1a2e;
            position: fixed; top: 0; left: 0; z-index: 100;
        }
        .sidebar .brand { padding: 20px 16px; color: #e94560; font-weight: 700; font-size: 1.2rem; border-bottom: 1px solid #16213e; }
        .sidebar .nav-link { color: #a8b2d8; padding: 10px 16px; border-radius: 6px; margin: 2px 8px; transition: all .2s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #e94560; color: #fff; }
        .sidebar .nav-link i { margin-right: 8px; }
        .main-content { margin-left: 240px; padding: 24px; }
        .topbar { background: #fff; border-radius: 10px; padding: 12px 20px; margin-bottom: 24px; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
        .stat-card { border-radius: 12px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
    </style>
</head>
<body>
<div class="sidebar d-flex flex-column">
    <div class="brand"><i class="bi bi-cpu-fill"></i> PcpartsVes</div>
    <nav class="nav flex-column mt-3">
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
    <div class="mt-auto p-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-danger btn-sm w-100"><i class="bi bi-box-arrow-left"></i> Logout</button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">@yield('title','Dashboard')</h5>
        <div class="d-flex align-items-center gap-2">
            @if(auth()->user()->profile_picture)
                <img src="{{ Storage::url(auth()->user()->profile_picture) }}" class="rounded-circle" width="36" height="36" style="object-fit:cover">
            @else
                <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-weight:700">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
            @endif
            <span class="fw-semibold">{{ auth()->user()->name }}</span>
        </div>
    </div>

    @yield('content')
</div>

<!-- Toast -->
<div class="toast-container">
    @foreach(['toast_success'=>'success','toast_error'=>'danger','toast_info'=>'info'] as $key=>$type)
        @if(session($key))
        <div class="toast align-items-center text-bg-{{ $type }} border-0 show mb-2" role="alert" data-bs-autohide="true" data-bs-delay="4000">
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
</script>
@yield('scripts')
</body>
</html>
