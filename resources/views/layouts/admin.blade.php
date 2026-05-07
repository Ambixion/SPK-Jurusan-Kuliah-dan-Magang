<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-dark:    #0d1117;
            --sidebar-bg: #0f1623;
            --card-bg:    #161d2f;
            --card-hover: #1e2a42;
            --accent:     #5b6af0;
            --accent2:    #7c3aed;
            --border-color: #1e2a42;
        }
        body {
            background: var(--bg-dark);
            color: #e2e8f0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            min-height: 100vh;
            margin: 0;
        }
        .sidebar {
            width: 230px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            padding: 20px 12px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            border-right: 1px solid var(--border-color);
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px 20px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 16px;
        }
        .sidebar-brand .avatar {
            width: 40px; height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5b6af0, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .sidebar-brand .brand-name { font-weight: 700; font-size: 0.9rem; line-height:1.2; }
        .sidebar-brand .brand-role { font-size: 0.72rem; color: #8892a4; }
        .nav-item-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 4px;
            text-decoration: none;
            color: #a0aec0;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .nav-item-custom:hover { background: var(--card-hover); color: #fff; }
        .nav-item-custom.active {
            background: linear-gradient(135deg, #5b6af0, #7c3aed);
            color: #fff;
        }
        .nav-icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.08);
            flex-shrink: 0; font-size: 0.9rem;
        }
        .nav-item-custom.active .nav-icon { background: rgba(255,255,255,0.2); }
        .logout-btn { margin-top: auto; padding-top: 16px; border-top: 1px solid var(--border-color); }
        .btn-logout {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px; border-radius: 10px; border: none;
            background: rgba(239,68,68,0.1); color: #f87171;
            width: 100%; font-size: 0.875rem; font-weight: 500;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.25); color: #fca5a5; }
        .main-wrapper { flex: 1; display: flex; flex-direction: column; overflow-x: hidden; }
        .topbar {
            background: var(--sidebar-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 14px 28px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-title { font-weight: 700; font-size: 1.25rem; }
        .main-content { flex: 1; padding: 28px; }
        .card-dark { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 14px; padding: 20px; }
        .table-dark-custom { color: #e2e8f0; width: 100%; border-collapse: separate; border-spacing: 0; }
        .table-dark-custom thead th {
            background: var(--card-hover); padding: 12px 16px;
            font-size: 0.8rem; font-weight: 600; color: #8892a4;
            text-transform: uppercase; letter-spacing: 0.04em;
            border-bottom: 1px solid var(--border-color);
        }
        .table-dark-custom tbody tr { border-bottom: 1px solid var(--border-color); transition: background 0.15s; }
        .table-dark-custom tbody tr:hover { background: var(--card-hover); }
        .table-dark-custom tbody td { padding: 13px 16px; font-size: 0.88rem; vertical-align: middle; }
        .table-dark-custom tbody tr:last-child td { border-bottom: none; }
        .form-control-dark, .form-select-dark {
            background: var(--bg-dark) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 10px !important;
            color: #e2e8f0 !important;
            padding: 10px 14px !important;
            transition: border-color 0.2s !important;
        }
        .form-control-dark:focus, .form-select-dark:focus {
            border-color: #5b6af0 !important;
            box-shadow: 0 0 0 3px rgba(91,106,240,0.15) !important;
            outline: none !important;
        }
        .form-control-dark::placeholder { color: #4a5568 !important; }
        .form-control-dark.is-invalid, .form-select-dark.is-invalid { border-color: #f87171 !important; }
        .form-label-custom { color: #a0aec0; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; display: block; }
        .btn-primary-custom {
            background: linear-gradient(135deg, #5b6af0, #7c3aed);
            border: none; border-radius: 10px; color: #fff;
            padding: 10px 20px; font-weight: 600; font-size: 0.875rem;
            cursor: pointer; transition: opacity 0.2s;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-primary-custom:hover { opacity: 0.88; color: #fff; }
        .btn-secondary-custom {
            background: var(--card-hover); border: 1px solid var(--border-color);
            border-radius: 10px; color: #a0aec0; padding: 10px 20px;
            font-weight: 600; font-size: 0.875rem; cursor: pointer;
            transition: all 0.2s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-secondary-custom:hover { background: #2a3a5a; color: #e2e8f0; }
        .btn-sm-action { padding: 5px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; border: none; cursor: pointer; text-decoration: none; transition: opacity 0.2s; display: inline-block; }
        .btn-edit   { background: rgba(234,179,8,0.15); color: #fbbf24; }
        .btn-edit:hover { background: rgba(234,179,8,0.3); color: #fbbf24; }
        .btn-delete { background: rgba(239,68,68,0.15); color: #f87171; }
        .btn-delete:hover { background: rgba(239,68,68,0.3); color: #f87171; }
        .btn-view   { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .btn-view:hover { background: rgba(59,130,246,0.3); color: #60a5fa; }
        .alert-dark-success { background: rgba(34,197,94,0.12); border: 1px solid rgba(34,197,94,0.3); color: #4ade80; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; }
        .alert-dark-error   { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #f87171; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; }
        .alert-dark-warning { background: rgba(234,179,8,0.12); border: 1px solid rgba(234,179,8,0.3); color: #fbbf24; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; }
        .badge-custom { padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
        .badge-admin  { background: rgba(139,92,246,0.2); color: #a78bfa; }
        .badge-guru   { background: rgba(59,130,246,0.2); color: #60a5fa; }
        .badge-siswa  { background: rgba(34,197,94,0.2);  color: #4ade80; }
        .badge-benefit{ background: rgba(34,197,94,0.2);  color: #4ade80; }
        .badge-cost   { background: rgba(239,68,68,0.2);  color: #f87171; }
        .badge-jurusan{ background: rgba(91,106,240,0.2); color: #818cf8; }
        .badge-magang { background: rgba(245,158,11,0.2); color: #fbbf24; }
        .pagination .page-link { background: var(--card-bg); border-color: var(--border-color); color: #a0aec0; }
        .pagination .page-item.active .page-link { background: #5b6af0; border-color: #5b6af0; color: #fff; }
        .pagination .page-link:hover { background: var(--card-hover); color: #fff; }
        select[multiple].form-control-dark { min-height: 120px; }
        option { background: #0d1117; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="avatar">👤</div>
            <div>
                <div class="brand-name">{{ auth()->user()->nama ?? 'Admin' }}</div>
                <div class="brand-role">Administrator</div>
            </div>
        </div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="nav-item-custom @if(request()->routeIs('admin.dashboard')) active @endif">
                <div class="nav-icon">📊</div> Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-item-custom @if(request()->routeIs('admin.users.*')) active @endif">
                <div class="nav-icon">👥</div> Manajemen User
            </a>
            <a href="{{ route('admin.jurusan_kuliah.index') }}" class="nav-item-custom @if(request()->routeIs('admin.jurusan_kuliah.*') || request()->routeIs('admin.jurusan.*')) active @endif">
                <div class="nav-icon">🎓</div> Jurusan
            </a>
            <a href="{{ route('admin.skill.index') }}" class="nav-item-custom @if(request()->routeIs('admin.skill.*')) active @endif">
                <div class="nav-icon">🛠️</div> Skill
            </a>
            <a href="{{ route('admin.tempat_magang.index') }}" class="nav-item-custom @if(request()->routeIs('admin.tempat_magang.*')) active @endif">
                <div class="nav-icon">🏢</div> Tempat Magang
            </a>
            <a href="{{ route('admin.kuisoner.index') }}" class="nav-item-custom @if(request()->routeIs('admin.kuisoner.*')) active @endif">
                <div class="nav-icon">❓</div> Kuisoner
            </a>
            <a href="{{ route('admin.kriteria.index') }}" class="nav-item-custom @if(request()->routeIs('admin.kriteria.*')) active @endif">
                <div class="nav-icon">⚙️</div> Kriteria
            </a>
        </nav>
        <div class="logout-btn">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">🚪 Log out</button>
            </form>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <div class="topbar-title">@yield('page-title', 'Admin Panel')</div>
            <small style="color:#8892a4;">Sistem Pemilih Jurusan</small>
        </div>
        <div class="main-content">
            @if(session('success'))
                <div class="alert-dark-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-dark-error">❌ {{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-dark-warning">
                    <strong>⚠️ Terjadi Kesalahan:</strong>
                    <ul class="mb-0 mt-1" style="padding-left:16px;">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
