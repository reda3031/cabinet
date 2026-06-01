<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.cabinet_medical') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f0f2f5; }

        /* SIDEBAR */
        #sidebar {
            width: 250px;
            min-height: 100vh;
            background: #1a1f2e;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }
        #sidebar .sidebar-brand {
            padding: 20px;
            background: #141824;
            text-align: center;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            border-bottom: 1px solid #2d3447;
        }
        #sidebar .sidebar-brand span { color: #4e9af1; }
        #sidebar ul { list-style: none; padding: 20px 0; margin: 0; flex: 1; }
        #sidebar ul li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: #a0aec0;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        #sidebar ul li a:hover,
        #sidebar ul li a.active {
            background: #2d3447;
            color: #fff;
            border-left: 3px solid #4e9af1;
        }
        #sidebar ul li a i { width: 18px; text-align: center; }
        #sidebar .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid #2d3447;
            color: #a0aec0;
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
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 99;
        }
        #header .header-title { font-weight: 600; color: #1a1f2e; font-size: 1rem; }
        #header .header-user { display: flex; align-items: center; gap: 10px; }
        #header .header-user .avatar {
            width: 36px; height: 36px;
            background: #4e9af1;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 0.9rem;
        }
        #header .header-user span { color: #4a5568; font-size: 0.9rem; }

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
            color: #a0aec0;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<div id="sidebar">
    <div class="sidebar-brand">🏥 {{ __('messages.cabinet_medical') }}</div>
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> {{ __('messages.sidebar_dashboard') }}
            </a>
        </li>
        <li>
            <a href="{{ route('appointments.index') }}" class="{{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> {{ __('messages.sidebar_appointments') }}
            </a>
        </li>
        @if(Auth::check() && Auth::user()->role === 'admin')
        <li>
            <a href="{{ route('admin.doctors') }}" class="{{ request()->routeIs('admin.doctors*') ? 'active' : '' }}">
                <i class="fas fa-user-md"></i> {{ __('messages.doctors') }}
            </a>
        </li>
        <li>
            <a href="{{ route('admin.patients') }}" class="{{ request()->requestUri === route('admin.patients', [], false) || request()->routeIs('admin.patients*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> {{ __('messages.patients') }}
            </a>
        </li>
        @endif
        <li>
            <a href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt"></i> {{ __('messages.sidebar_logout') }}
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <i class="fas fa-circle text-success" style="font-size:8px"></i>
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