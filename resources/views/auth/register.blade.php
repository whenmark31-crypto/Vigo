<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PcpartsVes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #1a1a2e; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 16px; }
        .auth-card { background: #fff; border-radius: 16px; padding: 36px 32px; width: 100%; max-width: 440px; box-shadow: 0 8px 32px rgba(0,0,0,.3); }
        .brand-title { color: #e94560; font-weight: 800; font-size: 1.6rem; }
        .toast-container { position: fixed; top: 16px; right: 16px; z-index: 9999; max-width: calc(100vw - 32px); }
        @media (max-width: 480px) {
            .auth-card { padding: 28px 20px; border-radius: 12px; }
        }
    </style>
</head>
<body>
<div class="toast-container">
    @if(session('toast_success'))
    <div class="toast align-items-center text-bg-success border-0 show" role="alert" data-bs-autohide="true" data-bs-delay="4000">
        <div class="d-flex">
            <div class="toast-body">{{ session('toast_success') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif
</div>

<div class="auth-card">
    <div class="text-center mb-4">
        <div class="brand-title"><i class="bi bi-cpu-fill"></i> PcpartsVes</div>
        <p class="text-muted mt-1">Create your account</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Juan Dela Cruz" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="juan@email.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Min. 6 characters" required>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
        </div>
        <button type="submit" class="btn btn-danger w-100 fw-bold">Register</button>
    </form>
    <p class="text-center mt-3 mb-0">Already have an account? <a href="{{ route('login') }}" class="text-danger fw-semibold">Login</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>document.querySelectorAll('.toast').forEach(el => new bootstrap.Toast(el).show());</script>
</body>
</html>
