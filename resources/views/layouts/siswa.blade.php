<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPK SMK')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg-main: #0d0f1e;
            --bg-sidebar: #13152a;
            --bg-card: rgba(255, 255, 255, 0.07);
            --bg-card-solid: #1e2140;
            --card-border: rgba(255, 255, 255, 0.1);
            --accent-blue: #4f6ef7;
            --accent-green: #22c55e;
            --accent-orange: #f97316;
            --text-primary: #ffffff;
            --text-muted: rgba(255, 255, 255, 0.55);
            --input-bg: rgba(255, 255, 255, 0.92);
            --input-text: #1a1a2e;
            --sidebar-w: 200px;
            --font: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            font-family: var(--font);
            background: var(--bg-main);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
        }

        /* ─────────────────────────────
   SIDEBAR
───────────────────────────── */

        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg-sidebar);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px 12px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 100;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 8px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 16px;
        }

        .sidebar-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f6ef7, #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .sidebar-user-name {
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }

        .sidebar-user-role {
            font-size: 10px;
            color: var(--text-muted);
        }

        .sidebar-nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            transition: all .2s;
            cursor: pointer;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #fff;
        }

        .nav-item.active {
            background: rgba(79, 110, 247, 0.18);
            color: #fff;
        }

        .nav-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .nav-icon.orange {
            background: #f97316;
        }

        .nav-icon.blue {
            background: #4f6ef7;
        }

        .nav-icon.green {
            background: #22c55e;
        }

        .sidebar-logout {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logout-btn {
            display: block;
            width: 100%;
            padding: 9px 12px;
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.25);
            border-radius: 10px;
            font-family: var(--font);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background .2s;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.28);
        }

        /* ─────────────────────────────
   MAIN
───────────────────────────── */

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            padding: 36px 40px;
            min-height: 100vh;
        }

        .page-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: .5px;
            color: #fff;
            margin-bottom: 28px;
            text-transform: uppercase;
        }

        .desktop-only {
            display: block;
        }

        /* ─────────────────────────────
   TOPBAR MOBILE
───────────────────────────── */

        .topbar-mobile {
            display: none;
        }

        .menu-toggle {
            display: none;
            background: #4f6ef7;
            color: #fff;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            font-size: 20px;
            cursor: pointer;
            flex-shrink: 0;
        }

        /* .menu-toggle.hide {
            display: none;
        } */

        .mobile-app-title {
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            letter-spacing: .5px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .mobile-app-sub {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 2px;
            font-weight: 500;
        }

        /* ─────────────────────────────
   CARD
───────────────────────────── */

        .card-main {
            background: linear-gradient(135deg, #2a2f6e 0%, #1e2255 60%, #252870 100%);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 32px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 24px;
        }

        /* ─────────────────────────────
   FORM
───────────────────────────── */

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 13px 18px;
            background: var(--input-bg);
            border: none;
            border-radius: 50px;
            font-family: var(--font);
            font-size: 14px;
            color: var(--input-text);
            outline: none;
            transition: box-shadow .2s;
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(79, 110, 247, 0.4);
        }

        .form-input[readonly],
        .form-input[disabled] {
            cursor: default;
            background: rgba(255, 255, 255, 0.88);
        }

        /* ─────────────────────────────
   PILLS
───────────────────────────── */

        .pills-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 4px;
        }

        .pill {
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all .2s;
        }

        .pill-default {
            background: rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.85);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .pill-default:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .pill-selected-blue {
            background: rgba(79, 110, 247, 0.3);
            color: #a5b4fc;
            border-color: #4f6ef7;
        }

        .pill-selected-green {
            background: rgba(34, 197, 94, 0.25);
            color: #86efac;
            border-color: #22c55e;
        }

        /* ─────────────────────────────
   STAT
───────────────────────────── */

        .stat-box {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 16px 20px;
        }

        .stat-label-sm {
            font-size: 15px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: #fff;
        }

        .stat-value.blue {
            color: #a5b4fc;
        }

        .stat-value.green {
            color: #86efac;
        }

        .stat-value.orange {
            color: #fdba74;
        }

        /* ─────────────────────────────
   BUTTON
───────────────────────────── */

        .btn-primary-spk {
            background: linear-gradient(135deg, #4f6ef7, #7c3aed);
            color: #fff;
            border: none;
            padding: 11px 26px;
            border-radius: 50px;
            font-family: var(--font);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: opacity .2s, transform .1s;
        }

        .btn-primary-spk:hover {
            opacity: .88;
            color: #fff;
            transform: translateY(-1px);
        }

        /* ─────────────────────────────
   PROFILE
───────────────────────────── */

        .profile-header {
            background: linear-gradient(135deg, #3730a3, #4f46e5);
            border-radius: 12px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 3px solid rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
        }

        .profile-name {
            font-size: 20px;
            font-weight: 800;
            color: #fff;
        }

        .profile-sub {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 3px;
        }

        .profile-badges {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .badge-pill {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-white {
            background: #fff;
            color: #3730a3;
        }

        .badge-purple {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* ─────────────────────────────
   INFO
───────────────────────────── */

        .info-section {
            margin-top: 20px;
        }

        .info-section-title {
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #fff;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            font-size: 13px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-key {
            color: var(--text-muted);
        }

        .info-val {
            color: #fff;
            font-weight: 600;
            text-align: right;
            max-width: 55%;
        }

        .info-val.highlight {
            color: #86efac;
            font-size: 16px;
            font-weight: 800;
        }

        /* ─────────────────────────────
   GRID
───────────────────────────── */

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        /* ─────────────────────────────
   ALERT
───────────────────────────── */

        .alert-spk {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(34, 197, 94, .15);
            color: #86efac;
            border: 1px solid rgba(34, 197, 94, .25);
        }

        .alert-error {
            background: rgba(239, 68, 68, .15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, .25);
        }

        /* ─────────────────────────────
   BOTTOM BUTTON
───────────────────────────── */

        .btn-bottom-right {
            display: flex;
            justify-content: flex-end;
            margin-top: 24px;
        }

        /* ─────────────────────────────
   TABLET
───────────────────────────── */

        @media (max-width: 992px) {

            .main {
                padding: 24px;
            }

            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* ─────────────────────────────
   MOBILE
───────────────────────────── */

        @media (max-width: 768px) {

            body {
                flex-direction: column;
            }

            .desktop-only {
                display: none;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform .3s ease;
                width: 240px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
                width: 100%;
                padding: 16px;
            }

            /* TOPBAR */

            .topbar-mobile {
                display: flex;
                align-items: center;
                gap: 14px;
                background: rgba(19, 21, 42, 0.95);
                border: 1px solid rgba(255, 255, 255, 0.08);
                padding: 14px 16px;
                border-radius: 16px;
                margin-bottom: 20px;
                position: sticky;
                top: 10px;
                z-index: 90;
                backdrop-filter: blur(12px);
            }

            .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .page-title {
                font-size: 18px;
                margin-bottom: 20px;
            }

            .card-main {
                padding: 20px;
                border-radius: 14px;
            }

            .card-title {
                font-size: 16px;
            }

            /* GRID MOBILE */

            .grid-2 {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .profile-header {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }

            .profile-avatar {
                width: 52px;
                height: 52px;
                font-size: 22px;
            }

            .profile-name {
                font-size: 18px;
            }

            .profile-sub {
                font-size: 12px;
            }

            .info-row {
                flex-direction: column;
                gap: 4px;
            }

            .info-val {
                max-width: 100%;
                text-align: left;
            }

            .btn-bottom-right {
                justify-content: stretch;
            }

            .btn-primary-spk {
                width: 100%;
                justify-content: center;
            }

            .form-input {
                padding: 12px 16px;
                font-size: 13px;
            }

            .stat-value {
                font-size: 22px;
            }

            .sidebar-user-name {
                font-size: 11px;
            }

            .nav-item {
                font-size: 11px;
            }
        }

        /* EXTRA SMALL */

        @media (max-width: 480px) {

            .grid-2,
            .grid-4 {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');

        // buka/tutup sidebar saja
        sidebar.classList.toggle('show');
    }

    // Tutup sidebar ketika klik halaman
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.sidebar');
        const toggle = document.querySelector('.menu-toggle');

        if (
            sidebar.classList.contains('show') &&
            !sidebar.contains(event.target) &&
            !toggle.contains(event.target)
        ) {
            sidebar.classList.remove('show');
        }
    });
</script>

<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-user">
            <div class="sidebar-avatar">
                {{ strtoupper(substr(Auth::user()->nama ?? 'U', 0, 1)) }}
            </div>
            <div>
                <div class="sidebar-user-name">{{ Auth::user()->nama ?? 'User' }}</div>
                <div class="sidebar-user-role">Student</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('siswa.dashboard') }}"
                class="nav-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                <div class="nav-icon orange">👤</div>
                Data Siswa
            </a>
            <a href="{{ route('siswa.pkl') }}" class="nav-item {{ request()->routeIs('siswa.pkl*') ? 'active' : '' }}">
                <div class="nav-icon blue">🏢</div>
                Pemilihan PKL
            </a>
            <a href="{{ route('siswa.jurusan') }}"
                class="nav-item {{ request()->routeIs('siswa.jurusan*') ? 'active' : '' }}">
                <div class="nav-icon green">🎓</div>
                Pemilihan Jurusan
            </a>
        </nav>

        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Log out</button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="main">
        {{-- @if (session('success'))
            <div class="alert-spk alert-success">{{ session('success') }}</div>
        @endif --}}
        <div class="topbar-mobile">

            <button class="menu-toggle" onclick="toggleSidebar()">
                ☰
            </button>

            <div>
                <div class="mobile-app-title">
                    SPK SMK 5 JEMBER
                </div>

                <div class="mobile-app-sub">
                    Sistem Pendukung Keputusan
                </div>
            </div>

        </div>

        @if (session('error'))
            <div class="alert-spk alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>
