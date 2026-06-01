<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.cabinet_medical') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        :root {
            --auth-bg: #f2f5f4;
            --auth-ink: #24343a;
            --auth-muted: #6f7f86;
            --auth-accent: #34988f;
            --auth-accent-dark: #26766f;
            --auth-card: #ffffff;
        }

        body {
            background: var(--auth-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--auth-ink);
        }
        .auth-card { width: 100%; max-width: 420px; }
        .auth-card .card {
            background: var(--auth-card);
            border: 1px solid #dce5e3;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .auth-card .card-header {
            background: #203642;
            color: #fff;
            border-radius: 6px 6px 0 0 !important;
            text-align: center;
            padding: 20px;
            font-size: 1.1rem;
            font-weight: 700;
            border-bottom: 2px solid var(--auth-accent);
        }
        .brand { text-align: center; color: var(--auth-ink); margin-bottom: 20px; font-size: 1.3rem; font-weight: 700; }
        .lang-switcher { position: absolute; top: 20px; right: 20px; z-index: 1000; }
        .lang-switcher .btn { border-radius: 20px; font-weight: 600; padding: 4px 12px; font-size: 0.85rem; }
        .btn-primary {
            background: var(--auth-accent);
            border-color: var(--auth-accent);
        }
        .btn-primary:hover {
            background: var(--auth-accent-dark);
            border-color: var(--auth-accent-dark);
        }
        .btn-outline-light {
            color: var(--auth-ink);
            border-color: rgba(36,52,58,0.25);
        }
        .btn-outline-light:hover {
            background: #fff;
            color: var(--auth-accent-dark);
            border-color: #fff;
        }
        .form-control {
            border-color: #d5e2df;
            border-radius: 4px;
        }
        .form-control:focus {
            border-color: var(--auth-accent);
            box-shadow: 0 0 0 0.1rem rgba(52,152,143,0.15);
        }
    </style>
</head>
<body>
<div class="lang-switcher">
    <a href="{{ route('lang.switch', 'fr') }}" class="btn {{ app()->getLocale() == 'fr' ? 'btn-primary' : 'btn-outline-light' }}">FR</a>
    <a href="{{ route('lang.switch', 'en') }}" class="btn {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-light' }}">EN</a>
</div>
<div class="auth-card">
    <div class="brand">{{ __('messages.cabinet_medical') }}</div>
    <div class="card">
        <div class="card-header">@yield('auth-title')</div>
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            @yield('content')
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
