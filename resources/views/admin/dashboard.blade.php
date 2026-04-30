{{-- @extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-4">
    <h3 class="mb-4">📊 Dashboard</h3>

    <div class="row">
        <!-- Total Users -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Total User</h6>
                            <h2 class="mb-0 text-primary">{{ $total_users }}</h2>
                        </div>
                        <div style="font-size: 2.5rem;">👥</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Siswa -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Total Siswa</h6>
                            <h2 class="mb-0 text-success">{{ $total_siswa }}</h2>
                        </div>
                        <div style="font-size: 2.5rem;">🎓</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Guru -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Total Guru</h6>
                            <h2 class="mb-0 text-info">{{ $total_guru }}</h2>
                        </div>
                        <div style="font-size: 2.5rem;">👨‍🏫</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Jurusan -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Total Jurusan</h6>
                            <h2 class="mb-0 text-warning">{{ $total_jurusan }}</h2>
                        </div>
                        <div style="font-size: 2.5rem;">📚</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Tempat Magang -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Total Tempat Magang</h6>
                            <h2 class="mb-0 text-danger">{{ $total_tempat_magang }}</h2>
                        </div>
                        <div style="font-size: 2.5rem;">🏢</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Kriteria -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card border-secondary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Total Kriteria</h6>
                            <h2 class="mb-0 text-secondary">{{ $total_kriteria }}</h2>
                        </div>
                        <div style="font-size: 2.5rem;">⚙️</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h5 class="mb-3">Akses Cepat</h5>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">+ Tambah User</a>
                <a href="{{ route('admin.jurusan.create') }}" class="btn btn-success btn-sm">+ Tambah Jurusan</a>
                <a href="{{ route('admin.tempat_magang.create') }}" class="btn btn-info btn-sm">+ Tambah Tempat Magang</a>
                <a href="{{ route('admin.kriteria.create') }}" class="btn btn-warning btn-sm">+ Tambah Kriteria</a>
            </div>
        </div>
    </div>
</div>
@endsection --}}
ini dashboard admin
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
