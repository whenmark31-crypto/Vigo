<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PcpartsVes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #1a1a2e; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 16px; }
        .auth-card { background: #fff; border-radius: 16px; padding: 36px 32px; width: 100%; max-width: 420px; box-shadow: 0 8px 32px rgba(0,0,0,.3); }
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
        <p class="text-muted mt-1">Sign in to your account</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="juan@email.com" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-4 form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <button type="submit" class="btn btn-danger w-100 fw-bold">Login</button>
    </form>
    <p class="text-center mt-3 mb-0">No account yet? <a href="{{ route('register') }}" class="text-danger fw-semibold">Register</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>document.querySelectorAll('.toast').forEach(el => new bootstrap.Toast(el).show());</script>
</body>
</html>
