<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Guru' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #05051f;
            color: #ffffff;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
            background: #05051f;
        }

        .sidebar {
            width: 310px;
            min-height: 100vh;
            background: #070720;
            border-right: 2px solid rgba(255, 255, 255, 0.08);
            padding: 35px 34px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            left: 0;
            top: 0;
        }

        .profile-box {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 45px;
        }

        .profile-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #b8dff2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        .profile-name {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.2;
        }

        .profile-role {
            font-size: 13px;
            color: #d6d6e7;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 13px 14px;
            border: 2px solid rgba(255, 255, 255, 0.18);
            border-radius: 10px;
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: 0.25s ease;
            background: #151541;
        }

        .menu-item:hover,
        .menu-item.active {
            transform: translateX(5px);
            background: #222264;
            border-color: rgba(255, 255, 255, 0.35);
        }

        .menu-icon {
            width: 48px;
            height: 48px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .icon-yellow { background: #e6b800; }
        .icon-red { background: #e21414; }
        .icon-purple { background: #4141bb; }
        .icon-green { background: #43c23f; }

        .logout-form {
            margin-top: 40px;
        }

        .logout-btn {
            border: none;
            background: #4444b7;
            color: #ffffff;
            padding: 12px 32px;
            border-radius: 22px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.25s ease;
            font-family: 'Poppins', sans-serif;
        }

        .logout-btn:hover {
            background: #5757d8;
        }

        .main-content {
            margin-left: 310px;
            width: calc(100% - 310px);
            padding: 42px 78px;
        }

        .page-title {
            font-size: 34px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 35px;
            text-transform: uppercase;
        }

        .card {
            background: #242467;
            border-radius: 12px;
            padding: 26px;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: linear-gradient(135deg, #3f3fc4, #5c5cff);
            border-radius: 9px;
            padding: 22px 26px;
            min-height: 122px;
        }

        .stat-title {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 700;
            color: #94d1d3;
            letter-spacing: 2px;
        }

        .toolbar {
            display: grid;
            grid-template-columns: 1.5fr 1fr 0.8fr;
            gap: 18px;
            margin-bottom: 22px;
        }

        .input-control,
        .select-control {
            width: 100%;
            height: 46px;
            border: none;
            outline: none;
            border-radius: 24px;
            background: #5656ea;
            color: #ffffff;
            padding: 0 18px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }

        .input-control::placeholder {
            color: #ffffff;
            opacity: 0.9;
        }

        .select-control {
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .form-input,
        .form-select {
            width: 100%;
            height: 50px;
            border: 2px solid rgba(255, 255, 255, 0.12);
            outline: none;
            border-radius: 12px;
            background: #343493;
            color: #ffffff;
            padding: 0 18px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: #7474ff;
        }

        .form-input::placeholder {
            color: #bdbde7;
        }

        .form-help {
            margin-top: 7px;
            font-size: 13px;
            color: #94d1d3;
        }

        .alert-success {
            background: rgba(67, 194, 63, 0.18);
            color: #b6ffb4;
            border: 1px solid rgba(67, 194, 63, 0.35);
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: rgba(226, 20, 20, 0.18);
            color: #ffbdbd;
            border: 1px solid rgba(226, 20, 20, 0.35);
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .error-text {
            margin-top: 7px;
            font-size: 13px;
            color: #ffbdbd;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: #343493;
            overflow: hidden;
        }

        .table th,
        .table td {
            border: 1px solid rgba(0, 0, 0, 0.25);
            padding: 14px 16px;
            text-align: center;
            font-size: 14px;
        }

        .table th {
            font-weight: 600;
            background: #303083;
        }

        .table td {
            color: #ffffff;
            font-weight: 500;
        }

        .table td.text-left {
            text-align: left;
        }

        .btn {
            border: none;
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            cursor: pointer;
            background: #4444d8;
            transition: 0.2s ease;
            font-family: 'Poppins', sans-serif;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .btn:hover {
            background: #5c5cff;
        }

        .btn-primary {
            background: #5656ea;
        }

        .btn-danger {
            background: #d83d3d;
        }

        .btn-danger:hover {
            background: #ff4d4d;
        }

        .btn-warning {
            background: #e6b800;
            color: #101027;
        }

        .btn-warning:hover {
            background: #ffd12d;
        }

        .btn-secondary {
            background: #3b3b78;
        }

        .btn-secondary:hover {
            background: #505096;
        }

        .action-group {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .form-actions {
            display: flex;
            gap: 14px;
            margin-top: 28px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .detail-item {
            background: #343493;
            border-radius: 12px;
            padding: 18px 20px;
        }

        .detail-label {
            color: #bdbde7;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
        }

        .empty-row {
            padding: 30px !important;
            color: #d6d6e7 !important;
        }

        .pagination-wrapper {
            margin-top: 22px;
        }

        .pagination-wrapper nav {
            color: white;
        }

        @media (max-width: 1100px) {
            .sidebar {
                width: 250px;
                padding: 28px 22px;
            }

            .main-content {
                margin-left: 250px;
                width: calc(100% - 250px);
                padding: 35px 35px;
            }

            .toolbar {
                grid-template-columns: 1fr;
            }

            .stat-grid,
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-wrapper {
                flex-direction: column;
            }

            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 28px 20px;
            }

            .page-title {
                font-size: 25px;
            }

            .card {
                overflow-x: auto;
            }

            .table {
                min-width: 850px;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div>
            <div class="profile-box">
                <div class="profile-avatar">👨‍🏫</div>
                <div>
                    <div class="profile-name">
                        {{ Auth::user()->nama ?? Auth::user()->name ?? 'Guru' }}
                    </div>
                    <div class="profile-role">Teacher</div>
                </div>
            </div>

            <nav class="menu">
                <a href="{{ route('guru.dashboard') }}" class="menu-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    <div class="menu-icon icon-yellow">👤</div>
                    <span>Data Guru</span>
                </a>

                <a href="{{ route('guru.siswa.index') }}" class="menu-item {{ request()->routeIs('guru.siswa.*') ? 'active' : '' }}">
                    <div class="menu-icon icon-red">👔</div>
                    <span>Edit Data Siswa</span>
                </a>

                <a href="#" class="menu-item">
                    <div class="menu-icon icon-purple">🏢</div>
                    <span>Data Pemilihan PKL</span>
                </a>

                <a href="#" class="menu-item">
                    <div class="menu-icon icon-green">🏫</div>
                    <span>Data Pemilihan Prodi</span>
                </a>
            </nav>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">Log out</button>
        </form>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>
</div>

@yield('scripts')

</body>
</html>