<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.cabinet_medical') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        :root {
            --main-bg: #f2f5f4;
            --sidebar-bg: #203642;
            --sidebar-dark: #182b35;
            --sidebar-hover: #2d4652;
            --accent: #34988f;
            --accent-dark: #26766f;
            --ink: #263238;
            --muted: #6c757d;
            --line: #dee5e3;
        }

        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: var(--main-bg); color: var(--ink); }

        .btn { border-radius: 4px; font-weight: 500; }
        .btn-primary,
        .btn-primary:focus {
            background: var(--accent);
            border-color: var(--accent);
            box-shadow: none;
        }
        .btn-primary:hover {
            background: var(--accent-dark);
            border-color: var(--accent-dark);
        }
        .btn-outline-primary {
            color: var(--accent-dark);
            border-color: var(--accent);
        }
        .btn-outline-primary:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }
        .bg-primary { background-color: var(--accent) !important; }
        .text-primary { color: var(--accent-dark) !important; }
        .card {
            border-radius: 6px;
            border: 1px solid var(--line) !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06) !important;
        }
        .card-header {
            border-bottom: 1px solid var(--line);
            border-radius: 6px 6px 0 0 !important;
        }
        .form-control {
            border-color: #d6dddb;
            border-radius: 4px;
        }
        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.1rem rgba(52, 152, 143, 0.15);
        }
        .table thead th {
            background: #edf2f1;
            border-bottom: 1px solid var(--line);
            color: #405057;
            font-size: 0.85rem;
        }
        .table-hover tbody tr:hover { background-color: #f8faf9; }
        .modal-content { border-radius: 6px; }

        /* SIDEBAR */
        #sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }
        #sidebar .sidebar-brand {
            padding: 20px;
            background: var(--sidebar-dark);
            text-align: center;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        #sidebar .sidebar-brand span { color: #8fd7d2; }
        #sidebar ul { list-style: none; padding: 20px 0; margin: 0; flex: 1; }
        #sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #bdd1d5;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background 0.15s;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        #sidebar ul li a:hover,
        #sidebar ul li a.active {
            background: transparent;
            color: #fff;
        }
        #sidebar .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
            color: #bdd1d5;
            font-size: 0.8rem;
        }

        /* HEADER */
        #header {
            margin-left: 250px;
            height: 60px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 99;
        }
        #header .header-title { font-weight: 600; color: var(--ink); font-size: 1rem; }
        #header .header-user { display: flex; align-items: center; gap: 10px; }
        #header .header-user .avatar {
            width: 36px; height: 36px;
            background: var(--accent);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 0.9rem;
        }
        #header .header-user span { color: var(--muted); font-size: 0.9rem; }

        /* MAIN CONTENT */
        #main-content {
            margin-left: 250px;
            padding: 24px;
            min-height: calc(100vh - 60px - 50px);
        }

        /* FOOTER */
        #footer {
            margin-left: 250px;
            background: #fff;
            text-align: center;
            padding: 14px;
            font-size: 0.8rem;
            color: var(--muted);
            border-top: 1px solid var(--line);
        }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<div id="sidebar">
    <div class="sidebar-brand">{{ __('messages.cabinet_medical') }}</div>
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                {{ __('messages.sidebar_dashboard') }}
            </a>
        </li>
        <li>
            <a href="{{ route('appointments.index') }}" class="{{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                {{ __('messages.sidebar_appointments') }}
            </a>
        </li>
        @if(Auth::check() && Auth::user()->role === 'admin')
        <li>
            <a href="{{ route('admin.doctors') }}" class="{{ request()->routeIs('admin.doctors*') ? 'active' : '' }}">
                {{ __('messages.doctors') }}
            </a>
        </li>
        <li>
            <a href="{{ route('admin.patients') }}" class="{{ request()->requestUri === route('admin.patients', [], false) || request()->routeIs('admin.patients*') ? 'active' : '' }}">
                {{ __('messages.patients') }}
            </a>
        </li>
        @endif
        <li>
            <a href="{{ route('logout') }}">
                {{ __('messages.sidebar_logout') }}
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        {{ Auth::check() ? Auth::user()->role : __('messages.guest') }}
    </div>
</div>

{{-- HEADER --}}
<div id="header">
    <div class="header-title">@yield('page-title', 'Tableau de bord')</div>
    <div class="d-flex align-items-center gap-2 mr-3">
    <a href="{{ route('lang.switch', 'fr') }}" class="btn btn-sm {{ app()->getLocale() == 'fr' ? 'btn-primary' : 'btn-outline-secondary' }}">FR</a>
    <a href="{{ route('lang.switch', 'en') }}" class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-secondary' }}">EN</a>
</div>
    <div class="header-user">
        @auth
        <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <span>{{ Auth::user()->name }}</span>
        @endauth
    </div>
</div>

{{-- CONTENU PRINCIPAL --}}
<div id="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            {{ $errors->first() }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @yield('content')
</div>

{{-- FOOTER --}}
<div id="footer">
    &copy; {{ date('Y') }} {{ __('messages.cabinet_medical') }} — {{ __('messages.all_rights_reserved') }}
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
