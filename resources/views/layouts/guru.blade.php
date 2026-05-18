<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard Guru')</title>

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

            --accent-blue: #4f6ef7;
            --accent-green: #22c55e;
            --accent-orange: #f97316;
            --accent-red: #ef4444;

            --text-primary: #ffffff;
            --text-muted: rgba(255, 255, 255, 0.55);

            --sidebar-w: 200px;

            --font: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            font-family: var(--font);
            background: var(--bg-main);
            color: var(--text-primary);

            min-height: 100vh;

            display: flex;

            overflow: hidden;
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

            margin-bottom: 16px;

            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-avatar {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: linear-gradient(135deg, #4f6ef7, #7c3aed);

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

            text-decoration: none;

            color: var(--text-muted);

            font-size: 12px;
            font-weight: 600;

            transition: .2s ease;
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

            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logout-btn {
            width: 100%;

            padding: 10px 12px;

            border: 1px solid rgba(239, 68, 68, 0.25);

            border-radius: 10px;

            background: rgba(239, 68, 68, 0.15);

            color: #ef4444;

            font-family: inherit;
            font-size: 12px;
            font-weight: 600;

            cursor: pointer;

            transition: .2s ease;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.28);
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

            letter-spacing: .5px;

            text-transform: uppercase;

            margin-bottom: 28px;
        }

        /* =========================================================
           MOBILE TOPBAR
        ========================================================= */

        .topbar-mobile {
            display: none;
        }

        .menu-toggle {
            display: none;

            width: 42px;
            height: 42px;

            border: none;
            border-radius: 10px;

            background: var(--accent-blue);
            color: white;

            font-size: 20px;

            cursor: pointer;

            flex-shrink: 0;
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

            color: rgba(255, 255, 255, 0.6);
        }

        /* =========================================================
           CARD
        ========================================================= */

        .card-main {
            background:
                linear-gradient(135deg,
                    #2a2f6e 0%,
                    #1e2255 60%,
                    #252870 100%);

            border: 1px solid rgba(255, 255, 255, 0.12);

            border-radius: 16px;

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

        /* =========================================================
           STAT
        ========================================================= */

        .stat-box {
            padding: 16px 20px;

            border-radius: 12px;

            background: rgba(255, 255, 255, 0.07);

            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-label-sm {
            margin-bottom: 8px;

            font-size: 13px;
            font-weight: 600;

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
           GLOBAL TABLE PAGE
        ========================================================= */

        .page-table-card {
            display: flex;
            flex-direction: column;

            height: calc(100vh - 130px);

            overflow: hidden;
        }

        /* =========================================================
           FILTER
        ========================================================= */

        .toolbar-filter {
            display: grid;
            grid-template-columns: 1fr 220px;

            gap: 16px;

            margin-bottom: 20px;

            flex-shrink: 0;
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

        .search-input,
        .filter-select {
            width: 100%;
            height: 50px;

            border: 1px solid rgba(255, 255, 255, .08);

            border-radius: 16px;

            background: rgba(255, 255, 255, .06);

            backdrop-filter: blur(12px);

            color: white;

            padding: 0 16px;

            font-size: 13px;
            font-weight: 500;
            font-family: inherit;

            outline: none;

            transition: .25s ease;
        }

        .search-input {
            padding-left: 46px;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, .45);
        }

        .search-input:focus,
        .filter-select:focus {
            border-color: rgba(79, 110, 247, .7);

            box-shadow:
                0 0 0 4px rgba(79, 110, 247, .15);

            background: rgba(255, 255, 255, .08);
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

            background-size:
                6px 6px,
                6px 6px;

            background-repeat: no-repeat;
        }

        .filter-select option {
            background: #1e2140;
            color: white;
        }

        /* =========================================================
           TABLE
        ========================================================= */

        .dashboard-table-card {

            margin-top: 24px;

            display: flex;
            flex-direction: column;

            height: calc(100vh - 260px);

            overflow: hidden;
        }

        .table-scroll,
        .table-scroll-dashboard {
            flex: 1;

            overflow: auto;

            min-height: 0;

            border-radius: 14px;

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
            background: rgba(255, 255, 255, .2);

            border-radius: 20px;
        }

        .table-scroll-dashboard::-webkit-scrollbar-thumb {

            background: linear-gradient(135deg,
                    rgba(79, 110, 247, .75),
                    rgba(124, 58, 237, .75));

            border-radius: 20px;
        }

        .table-scroll-dashboard::-webkit-scrollbar-thumb:hover {

            background: linear-gradient(135deg,
                    rgba(99, 122, 255, .95),
                    rgba(139, 92, 246, .95));
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

            background: rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(10px);

            padding: 14px;

            font-size: 12px;
            font-weight: 700;

            text-align: center;
        }

        .student-table td {
            padding: 14px;

            border-top: 1px solid rgba(255, 255, 255, 0.08);

            font-size: 12px;

            text-align: center;

            color: rgba(255, 255, 255, 0.88);
        }

        .student-table tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .text-left {
            text-align: left !important;
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

        .badge-success,
        .badge-warning {
            padding: 6px 14px;

            border-radius: 50px;

            font-size: 11px;
            font-weight: 700;
        }

        .badge-success {
            background: rgba(34, 197, 94, 0.18);
            color: #86efac;
        }

        .badge-warning {
            background: rgba(249, 115, 22, 0.18);
            color: #fdba74;
        }

        /* =========================================================
           ALERT
        ========================================================= */

        .alert-spk {
            margin-bottom: 20px;

            padding: 12px 18px;

            border-radius: 10px;

            font-size: 13px;
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

            body {
                flex-direction: column;

                overflow: auto;
            }

            .sidebar {
                width: 240px;

                transform: translateX(-100%);

                transition: transform .3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;

                width: 100%;

                padding: 16px;

                overflow: auto;
            }

            .topbar-mobile {
                display: flex;
                align-items: center;
                gap: 14px;

                background: rgba(19, 21, 42, 0.95);

                border: 1px solid rgba(255, 255, 255, 0.08);

                border-radius: 16px;

                padding: 14px 16px;

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
                padding: 18px;

                border-radius: 14px;
            }

            .grid-2,
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);

                gap: 12px;
            }

            .stat-box {
                padding: 14px;
            }

            .stat-label-sm {
                font-size: 11px;
            }

            .stat-value {
                font-size: 20px;
            }

            .page-table-card {
                height: calc(100dvh - 140px);
            }

            .toolbar-filter {
                grid-template-columns: 1fr;

                gap: 10px;
            }

            .search-input,
            .filter-select {
                height: 44px;

                border-radius: 14px;

                font-size: 12px;
            }

            .search-input {
                padding-left: 42px;
            }

            .search-icon {
                left: 14px;

                font-size: 12px;
            }

            .student-table {
                min-width: 920px;
            }

            .student-table th,
            .student-table td {
                padding: 12px;

                font-size: 12px;
            }

            .dashboard-table-card {

                height: calc(100dvh - 280px);

                padding: 16px !important;
            }

            .table-scroll-dashboard::-webkit-scrollbar {
                height: 7px;
                width: 7px;
            }
        }

        /* =========================================================
           EXTRA SMALL
        ========================================================= */

        @media (max-width: 480px) {

            .grid-2,
            .grid-4 {
                gap: 10px;
            }

            .main {
                padding: 14px;
            }

            .card-main {
                padding: 16px;
            }

            .page-title {
                font-size: 17px;
            }

            .stat-box {
                padding: 12px;
            }

            .stat-value {
                font-size: 17px;
            }

            .stat-label-sm {
                font-size: 10px;
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

            <button class="menu-toggle" onclick="toggleSidebar()">
                ☰
            </button>

            <div>

                <div class="mobile-app-title">
                    SPK SMK 5 JEMBER
                </div>

                <div class="mobile-app-sub">
                    Guru
                </div>

            </div>

        </div>

        {{-- ALERT --}}
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

        {{-- CONTENT --}}
        @yield('content')

    </main>

    <script>
        /* =========================================================
                                   SIDEBAR MOBILE
                                ========================================================= */

        function toggleSidebar() {

            const sidebar =
                document.querySelector('.sidebar');

            sidebar.classList.toggle('show');
        }

        document.addEventListener('click', function(event) {

            const sidebar =
                document.querySelector('.sidebar');

            const toggle =
                document.querySelector('.menu-toggle');

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

            const table =
                document.getElementById(config.tableId);

            const searchInput =
                document.getElementById(config.searchId);

            const filterInput =
                document.getElementById(config.filterId);

            if (
                !table ||
                !searchInput ||
                !filterInput
            ) return;

            const rows =
                table.querySelectorAll('tbody tr');

            function filterTable() {

                const search =
                    searchInput.value.toLowerCase();

                const filter =
                    filterInput.value.toLowerCase();

                rows.forEach(row => {

                    const nama =
                        row.dataset.nama || '';

                    const bidang =
                        row.dataset.bidang || '';

                    const matchSearch =
                        nama.includes(search) ||
                        bidang.includes(search);

                    const matchFilter =
                        filter === '' ||
                        bidang === filter;

                    row.style.display =
                        matchSearch && matchFilter ?
                        '' :
                        'none';
                });
            }

            searchInput.addEventListener(
                'input',
                filterTable
            );

            filterInput.addEventListener(
                'change',
                filterTable
            );
        }
    </script>

    @stack('scripts')

</body>

</html>
