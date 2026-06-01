<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.cabinet_medical') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background: #1a1f2e; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { width: 100%; max-width: 420px; }
        .auth-card .card { border: none; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); }
        .auth-card .card-header { background: #4e9af1; color: #fff; border-radius: 16px 16px 0 0 !important; text-align: center; padding: 20px; font-size: 1.1rem; font-weight: 700; }
        .brand { text-align: center; color: #fff; margin-bottom: 20px; font-size: 1.3rem; font-weight: 700; }
        .lang-switcher { position: absolute; top: 20px; right: 20px; z-index: 1000; }
        .lang-switcher .btn { border-radius: 20px; font-weight: 600; padding: 4px 12px; font-size: 0.85rem; }
    </style>
</head>
<body>
<div class="lang-switcher">
    <a href="{{ route('lang.switch', 'fr') }}" class="btn {{ app()->getLocale() == 'fr' ? 'btn-primary' : 'btn-outline-light' }}">FR</a>
    <a href="{{ route('lang.switch', 'en') }}" class="btn {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-light' }}">EN</a>
</div>
<div class="auth-card">
    <div class="brand">🏥 {{ __('messages.cabinet_medical') }}</div>
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