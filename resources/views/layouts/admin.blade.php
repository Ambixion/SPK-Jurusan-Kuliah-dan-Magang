<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar {
            flex-shrink: 0;
        }
        .main-content {
            flex: 1;
            overflow-y: auto;
        }
        .sidebar {
            background-color: #f8f9fa;
            min-height: calc(100vh - 56px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-3">
        <span class="navbar-brand mb-0 h1">Admin Panel - Sistem Pemilih Jurusan</span>
        <div class="d-flex align-items-center gap-3">
            <small class="text-light">{{ auth()->user()->nama ?? 'Admin' }}</small>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row" style="min-height: calc(100vh - 56px);">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-3">
                <div class="list-group">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action @if(request()->routeIs('admin.dashboard')) active @endif">
                        📊 Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action @if(request()->routeIs('admin.users.*')) active @endif">
                        👥 Manajemen User
                    </a>
                    <a href="{{ route('admin.jurusan.index') }}" class="list-group-item list-group-item-action @if(request()->routeIs('admin.jurusan.*')) active @endif">
                        🎓 Jurusan
                    </a>
                    <a href="{{ route('admin.tempat_magang.index') }}" class="list-group-item list-group-item-action @if(request()->routeIs('admin.tempat_magang.*')) active @endif">
                        🏢 Tempat Magang
                    </a>
                    <a href="{{ route('admin.kriteria.index') }}" class="list-group-item list-group-item-action @if(request()->routeIs('admin.kriteria.*')) active @endif">
                        ⚙️ Kriteria
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Terjadi Kesalahan:</strong>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
