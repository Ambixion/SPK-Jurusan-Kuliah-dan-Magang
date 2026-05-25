<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard Guru')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* =========================================================
           RESET & ROOT
        ========================================================= */
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

            --accent-blue: #4f6ef7;
            --accent-green: #22c55e;
            --accent-orange: #f97316;
            --accent-red: #ef4444;
            --accent-purple: #7c3aed;

            --text-primary: #ffffff;
            --text-muted: rgba(255, 255, 255, 0.55);

            --border-light: rgba(255, 255, 255, 0.08);
            --bg-glass: rgba(255, 255, 255, 0.06);

            --sidebar-w: 200px;

            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 16px;

            --transition: .2s ease;

            --font: 'Plus Jakarta Sans', sans-serif;
        }

        /* =========================================================
           GLOBAL
        ========================================================= */
        body {
            font-family: var(--font);
            background: var(--bg-main);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        .text-left {
            text-align: left !important;
        }

        /* =========================================================
           REUSABLE
        ========================================================= */
        .glass-input,
        .search-input,
        .filter-select,
        .form-group input,
        .form-group select {
            width: 100%;
            height: 48px;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            background: var(--bg-glass);
            color: white;
            padding: 0 14px;
            font-family: inherit;
            font-size: 13px;
            outline: none;
            transition: .25s ease;
        }

        .glass-input:focus,
        .search-input:focus,
        .filter-select:focus,
        .form-group input:focus,
        .form-group select:focus {
            border-color: rgba(79, 110, 247, .7);
            box-shadow: 0 0 0 4px rgba(79, 110, 247, .15);
            background: rgba(255, 255, 255, .08);
        }

        .gradient-card,
        .card-main,
        .modal-card {
            background:
                linear-gradient(135deg,
                    #2a2f6e 0%,
                    #1e2255 60%,
                    #252870 100%);
            border: 1px solid rgba(255, 255, 255, .12);
        }

        .btn-base,
        .action-btn,
        .add-btn,
        .logout-btn,
        .modal-close {
            border: none;
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-base:hover,
        .action-btn:hover,
        .add-btn:hover {
            transform: translateY(-1px);
        }

        .badge-base,
        .badge-success,
        .badge-warning {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
        }

        /* =========================================================
           SIDEBAR
        ========================================================= */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg-sidebar);
            min-height: 100vh;
            padding: 20px 12px;
            display: flex;
            flex-direction: column;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 100;
            border-right: 1px solid rgba(255, 255, 255, .05);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 8px 20px;
            margin-bottom: 16px;
            border-bottom: 1px solid var(--border-light);
        }

        .sidebar-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sidebar-user-name {
            font-size: 12px;
            font-weight: 700;
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
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            transition: var(--transition);
        }

        .nav-item:hover,
        .nav-item.active {
            color: white;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, .07);
        }

        .nav-item.active {
            background: rgba(79, 110, 247, .18);
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

        .icon-orange {
            background: var(--accent-orange);
        }

        .icon-blue {
            background: var(--accent-blue);
        }

        .icon-green {
            background: var(--accent-green);
        }

        .icon-red {
            background: var(--accent-red);
        }

        .sidebar-logout {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid var(--border-light);
        }

        .logout-btn {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid rgba(239, 68, 68, .25);
            background: rgba(239, 68, 68, .15);
            color: #ef4444;
            font-size: 12px;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, .28);
        }

        /* =========================================================
           MAIN
        ========================================================= */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            padding: 36px 40px;
            overflow: hidden;
        }

        .page-title {
            font-size: 22px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 28px;
        }

        /* =========================================================
           TOPBAR MOBILE
        ========================================================= */
        .topbar-mobile,
        .menu-toggle {
            display: none;
        }

        .mobile-app-title {
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .mobile-app-sub {
            margin-top: 2px;
            font-size: 10px;
            font-weight: 500;
            color: rgba(255, 255, 255, .6);
        }

        /* =========================================================
           CARD
        ========================================================= */
        .card-main {
            border-radius: var(--radius-lg);
            padding: 24px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        /* =========================================================
           GRID
        ========================================================= */
        .grid-2,
        .modal-form-grid,
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .form-group.full,
        .detail-item.full {
            grid-column: span 2;
        }

        /* =========================================================
           STAT
        ========================================================= */
        .stat-box,
        .detail-item {
            background: rgba(255, 255, 255, .05);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
        }

        .stat-box {
            padding: 16px 20px;
        }

        .detail-item {
            padding: 14px;
        }

        .stat-label-sm,
        .detail-item span {
            display: block;
            margin-bottom: 6px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
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

        /* =========================================================
           TOOLBAR
        ========================================================= */
        .table-tools {
            display: grid;
            grid-template-columns: minmax(260px, 1.5fr) 180px 220px auto;
            gap: 14px;
            margin-bottom: 20px;
            align-items: center;
        }

        .toolbar-filter {
            display: grid;
            grid-template-columns: 1fr 220px;
            gap: 16px;
            margin-bottom: 20px;
        }

        .search-box {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            color: rgba(255, 255, 255, .55);
            pointer-events: none;
        }

        .search-input {
            padding-left: 46px;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, .45);
        }

        .filter-select {
            cursor: pointer;
            appearance: none;
            background-image:
                linear-gradient(45deg, transparent 50%, rgba(255, 255, 255, .7) 50%),
                linear-gradient(135deg, rgba(255, 255, 255, .7) 50%, transparent 50%);
            background-position:
                calc(100% - 20px) 22px,
                calc(100% - 14px) 22px;
            background-size: 6px 6px;
            background-repeat: no-repeat;
        }

        .filter-select option,
        .form-group select option {
            background: #1e2140;
            color: white;
        }

        /* =========================================================
           BUTTONS
        ========================================================= */
        .add-btn {
            height: 50px;
            padding: 0 20px;
            border-radius: var(--radius-lg);
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            color: rgb(255, 255, 255);
            font-size: 13px;
        }

        .action-group {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 8px 14px;
            font-size: 11px;
            color: white;
        }

        .show-btn {
            background: rgba(79, 110, 247, .22);
            color: #c7d2fe;
        }

        .open-edit-modal {
            background: rgba(245, 158, 11, .18);
            color: #fcd34d;
        }

        .delete-btn {
            background: rgba(239, 68, 68, .18);
            color: #fca5a5;
        }

        .btn-cancel {
            background: rgba(255, 255, 255, .1);
        }

        .submit-btn {
            width: 100%;
            height: 50px;
            background: rgba(34, 197, 94, .18);
            color: #86efac;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* =========================================================
           TABLE
        ========================================================= */
        .page-table-card,
        .dashboard-table-card {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .page-table-card {
            height: calc(100vh - 130px);
        }

        .dashboard-table-card {
            height: calc(100vh - 260px);
            margin-top: 24px;
        }

        .table-scroll,
        .table-scroll-dashboard {
            flex: 1;
            overflow: auto;
            min-height: 0;
            border-radius: var(--radius-md);
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, .2) transparent;
        }

        .table-scroll::-webkit-scrollbar,
        .table-scroll-dashboard::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .table-scroll::-webkit-scrollbar-thumb,
        .table-scroll-dashboard::-webkit-scrollbar-thumb {
            border-radius: 20px;
        }

        .table-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .2);
        }

        .table-scroll-dashboard::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg,
                    rgba(79, 110, 247, .75),
                    rgba(124, 58, 237, .75));
        }

        .student-table {
            width: 100%;
            min-width: 950px;
            border-collapse: collapse;
        }

        .student-table thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(10px);
            padding: 14px;
            text-align: center;
            font-size: 12px;
            font-weight: 700;
        }

        .student-table td {
            padding: 14px;
            border-top: 1px solid var(--border-light);
            text-align: center;
            font-size: 12px;
            color: rgba(255, 255, 255, .88);
        }

        .student-table tr:hover {
            background: rgba(255, 255, 255, .03);
        }

        .table-title {
            font-weight: 700;
        }

        .empty-data {
            padding: 40px !important;
            color: rgba(255, 255, 255, .6);
        }

        /* =========================================================
           BADGE
        ========================================================= */
        .badge-success {
            background: rgba(34, 197, 94, .18);
            color: #86efac;
        }

        .badge-warning {
            background: rgba(249, 115, 22, .18);
            color: #fdba74;
        }

        /* =========================================================
           ALERT
        ========================================================= */
        .alert-container {
            position: fixed;
            top: 20px;
            left: calc(var(--sidebar-w) + 20px);
            width: calc(100% - var(--sidebar-w) - 40px);
            z-index: 99999;
            pointer-events: none;
        }

        .alert-spk {
            width: 100%;
            padding: 16px 20px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
            animation: alertSlide .3s ease;
            transition: opacity .3s ease, transform .3s ease;
            pointer-events: auto;
        }

        @keyframes alertSlide {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: rgba(34, 197, 94, .15);
            border: 1px solid rgba(34, 197, 94, .25);
            color: #86efac;
            transition: opacity .3s ease;
        }

        .alert-error {
            background: rgba(239, 68, 68, .15);
            border: 1px solid rgba(239, 68, 68, .25);
            color: #fca5a5;
            transition: opacity .3s ease;
        }

        /* =========================================================
           MODAL
        ========================================================= */
        .modal-overlay {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(0, 0, 0, .65);
            backdrop-filter: blur(4px);
            z-index: 9999;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-card {
            width: 100%;
            max-width: 820px;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 18px;
            padding: 24px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, .2) transparent;
        }

        .modal-card::-webkit-scrollbar {
            width: 8px;
        }

        .modal-card::-webkit-scrollbar-track {
            background: transparent;
        }

        .modal-card::-webkit-scrollbar-thumb {
            border-radius: 20px;
            background: linear-gradient(135deg,
                    rgba(79, 110, 247, .75),
                    rgba(124, 58, 237, .75));
        }

        .modal-card::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg,
                    rgba(79, 110, 247, 1),
                    rgba(124, 58, 237, 1));
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 800;
        }

        .modal-close {
            width: 38px;
            height: 38px;
            background: rgba(239, 68, 68, .2);
            color: white;
            font-size: 18px;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .help {
            margin-top: 14px;
            font-size: 12px;
            color: #c7d2fe;
        }

        /* =========================================================
           TABLET
        ========================================================= */
        @media (max-width: 992px) {
            .main {
                padding: 24px;
            }

            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* =========================================================
           MOBILE
        ========================================================= */
        @media (max-width: 768px) {

            /* Layout dasar */
            body {
                flex-direction: column;
                overflow: auto;
            }

            /* Alert */
            .alert-container {
                left: 16px;
                width: calc(100% - 32px);
                top: 16px;
            }

            /* Sidebar: overlay geser dari kiri */
            .sidebar {
                width: 240px;
                transform: translateX(-100%);
                transition: transform .3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            /* Main */
            .main {
                width: 100%;
                margin-left: 0;
                padding: 16px;
                overflow: auto;
            }

            /* Topbar mobile */
            .topbar-mobile {
                display: flex;
                align-items: center;
                gap: 14px;
                position: sticky;
                top: 0;
                z-index: 90;
                margin-bottom: 20px;
                padding: 12px 16px;
                border-radius: var(--radius-lg);
                background: rgba(19, 21, 42, .95);
                border: 1px solid var(--border-light);
                backdrop-filter: blur(12px);
            }

            .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border: none;
                border-radius: var(--radius-sm);
                background: var(--accent-blue);
                color: white;
                font-size: 18px;
                cursor: pointer;
                flex-shrink: 0;
            }

            /* Judul halaman */
            .page-title {
                font-size: 16px;
                margin-bottom: 16px;
            }

            /* Card padding */
            .card-main {
                padding: 16px;
            }

            /* Grid: semua jadi 1 kolom kecuali stat */
            .grid-2,
            .modal-form-grid,
            .detail-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            /* =========================================
   DATA SISWA
   Search full
   Filter kelas & jurusan sebelahan
========================================= */
            .table-tools {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .table-tools .search-box,
            .table-tools .add-btn {
                grid-column: span 2;
            }

            /* =========================================
   SMA MAGANG / PRODI
   Search & filter sebelahan
========================================= */
            .toolbar-filter {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            /* Stat tetap 2 kolom agar ringkas */
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .form-group.full,
            .detail-item.full {
                grid-column: span 1;
            }

            /* Input & filter */
            .search-input,
            .filter-select {
                height: 44px;
                font-size: 12px;
            }

            .search-input {
                padding-left: 42px;
            }

            .search-icon {
                left: 14px;
                font-size: 12px;
            }

            /* Tombol tambah full-width */
            .add-btn {
                width: 100%;
                height: 46px;
                font-size: 12px;
            }

            /* Tabel */
            .student-table {
                min-width: 920px;
            }

            .student-table th,
            .student-table td {
                padding: 12px;
                font-size: 12px;
            }

            /* Action button lebih compact */
            .action-btn {
                padding: 6px 10px;
                font-size: 10px;
            }

            .action-group {
                gap: 5px;
            }

            /* Dashboard table card */
            .dashboard-table-card {
                height: calc(100dvh - 280px);
                /* margin-top: 16px; */
            }

            /* Stat box */
            .stat-box {
                padding: 12px 14px;
            }

            .stat-value {
                font-size: 22px;
            }

            .stat-label-sm {
                font-size: 10px;
            }

            /* Modal */
            .modal-card {
                padding: 18px;
                max-height: 85vh;
            }

            .modal-title {
                font-size: 16px;
            }

            .modal-actions {
                flex-direction: column;
                gap: 8px;
            }

            .modal-actions .btn-cancel,
            .modal-actions .submit-btn {
                width: 100%;
                justify-content: center;
            }

            /* Scrollbar tipis di mobile */
            .table-scroll-dashboard::-webkit-scrollbar {
                width: 5px;
                height: 5px;
            }
        }

        /* =========================================================
           EXTRA SMALL
        ========================================================= */
        @media (max-width: 480px) {

            .main {
                padding: 12px;
            }

            .card-main {
                padding: 14px;
            }

            .grid-2,
            .grid-4 {
                gap: 8px;
            }

            .page-title {
                font-size: 15px;
            }

            .stat-box {
                padding: 10px 12px;
            }

            .stat-value {
                font-size: 18px;
            }

            .stat-label-sm {
                font-size: 10px;
            }

            .topbar-mobile {
                padding: 10px 12px;
                margin-bottom: 16px;
            }

            .mobile-app-title {
                font-size: 13px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div class="sidebar-user">

            <div class="sidebar-avatar">
                {{ strtoupper(substr(Auth::user()->nama ?? 'G', 0, 1)) }}
            </div>

            <div>

                <div class="sidebar-user-name">
                    {{ Auth::user()->nama ?? (Auth::user()->name ?? 'Guru') }}
                </div>

                <div class="sidebar-user-role">
                    Teacher
                </div>

            </div>

        </div>

        <nav class="sidebar-nav">

            <a href="{{ route('guru.dashboard') }}"
                class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                <div class="nav-icon icon-orange">👤</div>
                Dashboard Guru
            </a>

            <a href="{{ route('guru.siswa.index') }}"
                class="nav-item {{ request()->routeIs('guru.siswa.*') ? 'active' : '' }}">
                <div class="nav-icon icon-blue">👨‍🎓</div>
                Data Siswa
            </a>

            <a href="{{ route('guru.tempat_magang') }}"
                class="nav-item {{ request()->routeIs('guru.tempat_magang') ? 'active' : '' }}">
                <div class="nav-icon icon-green">🏢</div>
                Data Pemilihan PKL
            </a>

            <a href="{{ route('guru.jurusan_kuliah') }}"
                class="nav-item {{ request()->routeIs('guru.jurusan_kuliah') ? 'active' : '' }}">
                <div class="nav-icon icon-red">🎓</div>
                Data Pemilihan Prodi
            </a>

        </nav>

        <div class="sidebar-logout">

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    Log out
                </button>
            </form>

        </div>

    </aside>

    {{-- MAIN --}}
    <main class="main">

        {{-- MOBILE TOPBAR --}}
        <div class="topbar-mobile">

            <button class="menu-toggle" onclick="toggleSidebar()">☰</button>

            <div>
                <div class="mobile-app-title">SPK SMK 5 JEMBER</div>
                <div class="mobile-app-sub">Guru</div>
            </div>

        </div>

        {{-- ALERT FLOAT --}}
        <div class="alert-container">

            @if (session('success'))
                <div class="alert-spk alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert-spk alert-error">
                    {{ session('error') }}
                </div>
            @endif

        </div>

        {{-- CONTENT --}}
        @yield('content')

    </main>

    <script>
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-spk');

            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(20px)';

                setTimeout(() => {
                    alert.remove();
                }, 300);
            });
        }, 2000);
    </script>

    <script>
        /* =========================================================
                                   SIDEBAR MOBILE
                                ========================================================= */
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('show');
        }

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

        /* =========================================================
           GLOBAL TABLE FILTER
        ========================================================= */
        function initTableFilter(config) {
            const table = document.getElementById(config.tableId);
            const searchInput = document.getElementById(config.searchId);
            const filterInput = document.getElementById(config.filterId);

            if (!table || !searchInput || !filterInput) return;

            const rows = table.querySelectorAll('tbody tr');

            function filterTable() {
                const search = searchInput.value.toLowerCase();
                const filter = filterInput.value.toLowerCase();

                rows.forEach(row => {
                    const nama = row.dataset.nama || '';
                    const bidang = row.dataset.bidang || '';

                    const matchSearch = nama.includes(search) || bidang.includes(search);
                    const matchFilter = filter === '' || bidang === filter;

                    row.style.display = matchSearch && matchFilter ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterTable);
            filterInput.addEventListener('change', filterTable);
        }
    </script>

    <script>
        const searchInput = document.getElementById('searchInput');
        const kelasFilter = document.getElementById('kelasFilter');
        const jurusanFilter = document.getElementById('jurusanFilter');
        const rows = document.querySelectorAll('#studentTable tbody tr');

        function filterTable() {
            const searchValue = searchInput.value.toLowerCase();
            const kelasValue = kelasFilter.value.toLowerCase();
            const jurusanValue = jurusanFilter.value.toLowerCase();

            rows.forEach(row => {
                const nama = row.dataset.nama || '';
                const nisn = row.dataset.nisn || '';
                const kelas = row.dataset.kelas || '';
                const jurusan = row.dataset.jurusan || '';

                const matchSearch = nama.includes(searchValue);
                const matchKelas = kelasValue === '' || kelas === kelasValue;
                const matchJurusan = jurusanValue === '' || jurusan === jurusanValue;

                row.style.display = matchSearch && matchKelas && matchJurusan ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        kelasFilter.addEventListener('change', filterTable);
        jurusanFilter.addEventListener('change', filterTable);
    </script>

    <script>
        const createModal = document.getElementById('createModal');
        const openCreateModal = document.getElementById('openCreateModal');
        const closeCreateModal = document.getElementById('closeCreateModal');
        const cancelCreateModal = document.getElementById('cancelCreateModal');

        function showCreateModal() {
            createModal.classList.add('show');
        }

        function hideCreateModal() {
            createModal.classList.remove('show');
        }

        openCreateModal.addEventListener('click', showCreateModal);
        closeCreateModal.addEventListener('click', hideCreateModal);
        cancelCreateModal.addEventListener('click', hideCreateModal);

        createModal.addEventListener('click', function(e) {
            if (e.target === createModal) hideCreateModal();
        });
    </script>

    <script>
        const editModal = document.getElementById('editModal');
        const closeEditModal = document.getElementById('closeEditModal');
        const cancelEditModal = document.getElementById('cancelEditModal');
        const editForm = document.getElementById('editForm');

        const editNama = document.getElementById('editNama');
        const editEmail = document.getElementById('editEmail');
        const editNisn = document.getElementById('editNisn');
        const editKelas = document.getElementById('editKelas');
        const editSemester = document.getElementById('editSemester');
        const editJurusan = document.getElementById('editJurusan');
        const editNilai = document.getElementById('editNilai');
        const editNoTelp = document.getElementById('editNoTelp');
        const editAlamat = document.getElementById('editAlamat');

        document.querySelectorAll('.open-edit-modal').forEach(button => {
            button.addEventListener('click', function() {
                editForm.action = this.dataset.action;

                editNama.value = this.dataset.nama || '';
                editEmail.value = this.dataset.email || '';
                editNisn.value = this.dataset.nisn || '';
                editKelas.value = this.dataset.kelas || '';
                editSemester.value = this.dataset.semester || '';
                editJurusan.value = this.dataset.jurusan || '';
                editNilai.value = this.dataset.nilai || '';
                editNoTelp.value = this.dataset.noTelp || '';
                editAlamat.value = this.dataset.alamat || '';

                editModal.classList.add('show');
            });
        });

        function closeModal() {
            editModal.classList.remove('show');
        }

        closeEditModal.addEventListener('click', closeModal);
        cancelEditModal.addEventListener('click', closeModal);

        editModal.addEventListener('click', function(e) {
            if (e.target === editModal) closeModal();
        });
    </script>

    <script>
        const showModal = document.getElementById('showModal');
        const closeShowModal = document.getElementById('closeShowModal');
        const cancelShowModal = document.getElementById('cancelShowModal');

        const showNama = document.getElementById('showNama');
        const showEmail = document.getElementById('showEmail');
        const showNisn = document.getElementById('showNisn');
        const showNoTelp = document.getElementById('showNoTelp');
        const showKelas = document.getElementById('showKelas');
        const showSemester = document.getElementById('showSemester');
        const showJurusan = document.getElementById('showJurusan');
        const showNilai = document.getElementById('showNilai');
        const showStatusProdi = document.getElementById('showStatusProdi');
        const showStatusMagang = document.getElementById('showStatusMagang');
        const showAlamat = document.getElementById('showAlamat');

        document.querySelectorAll('.open-show-modal').forEach(button => {
            button.addEventListener('click', function() {
                showNama.textContent = this.dataset.nama || '-';
                showEmail.textContent = this.dataset.email || '-';
                showNisn.textContent = this.dataset.nisn || '-';
                showNoTelp.textContent = this.dataset.noTelp || '-';
                showKelas.textContent = this.dataset.kelas !== '-' ? 'Kelas ' + this.dataset.kelas : '-';
                showSemester.textContent = this.dataset.semester !== '-' ? 'Semester ' + this.dataset
                    .semester : '-';
                showJurusan.textContent = this.dataset.jurusan || '-';
                showNilai.textContent = this.dataset.nilai || '-';
                if (showStatusProdi) {
                    showStatusProdi.textContent = this.dataset.statusProdi || '-';
                }

                if (showStatusMagang) {
                    showStatusMagang.textContent = this.dataset.statusMagang || '-';
                }
                showAlamat.textContent = this.dataset.alamat || '-';

                showModal.classList.add('show');
            });
        });

        function closeShowModalBox() {
            showModal.classList.remove('show');
        }

        closeShowModal.addEventListener('click', closeShowModalBox);
        cancelShowModal.addEventListener('click', closeShowModalBox);

        showModal.addEventListener('click', function(e) {
            if (e.target === showModal) closeShowModalBox();
        });
    </script>

    @stack('scripts')

</body>

</html>
