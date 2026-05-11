<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>

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
            background: #4444b7;
            color: white;
            border: none;
            border-radius: 22px;
            padding: 12px 32px;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
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
            margin-bottom: 42px;
            text-transform: uppercase;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .stat-value {
            font-size: 27px;
            font-weight: 700;
            color: #94d1d3;
            letter-spacing: 1px;
        }

        .table-card {
            background: #242467;
            padding: 24px 26px 20px;
            border-radius: 10px;
            margin-top: 25px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .student-table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            background: #343493;
        }

        .student-table th,
        .student-table td {
            border: 1px solid rgba(0, 0, 0, 0.25);
            padding: 14px 16px;
            text-align: center;
            font-size: 14px;
        }

        .student-table th {
            font-weight: 600;
            background: #303083;
        }

        .student-table td {
            color: #ffffff;
            font-weight: 500;
        }

        .student-table td.name {
            text-align: left;
            padding-left: 24px;
        }

        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 18px;
            font-size: 13px;
            font-weight: 700;
        }

        .badge-success {
            background: rgba(67, 194, 63, 0.25);
            color: #b6ffb4;
        }

        .badge-warning {
            background: rgba(230, 184, 0, 0.25);
            color: #ffe58a;
        }

        .empty-row {
            padding: 30px !important;
            color: #d6d6e7 !important;
        }

        @media (max-width: 1300px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
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

            .stat-grid {
                grid-template-columns: 1fr;
            }

            .table-card {
                overflow-x: auto;
            }

            .student-table {
                min-width: 950px;
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
                    <span>Dashboard Guru</span>
                </a>

                <a href="{{ route('guru.siswa.index') }}" class="menu-item {{ request()->routeIs('guru.siswa.*') ? 'active' : '' }}">
                    <div class="menu-icon icon-red">👔</div>
                    <span>Data Siswa</span>
                </a>

                <a href="{{ route('guru.tempat_magang') }}" class="menu-item {{ request()->routeIs('guru.tempat_magang') ? 'active' : '' }}">
                    <div class="menu-icon icon-purple">🏢</div>
                    <span>Data Pemilihan PKL</span>
                </a>

                <a href="{{ route('guru.jurusan_kuliah') }}" class="menu-item {{ request()->routeIs('guru.jurusan_kuliah') ? 'active' : '' }}">
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
        <h1 class="page-title">Dashboard Guru</h1>

        <section class="stat-grid">
            <div class="stat-card">
                <div class="stat-title">Total Siswa</div>
                <div class="stat-value">{{ $data['total_siswa'] ?? 0 }} Siswa</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Tempat Magang</div>
                <div class="stat-value">{{ $data['total_tempat_magang'] ?? 0 }} Tempat</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Prodi Kuliah</div>
                <div class="stat-value">{{ $data['total_prodi_kuliah'] ?? 0 }} Prodi</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Status SPK</div>
                <div class="stat-value">
                    {{ $data['siswa_sudah_pilih_prodi'] ?? 0 }} Prodi -
                    {{ $data['siswa_sudah_pilih_magang'] ?? 0 }} Magang
                </div>
            </div>
        </section>

        <section class="table-card">
            <h2 class="section-title">Hasil SPK Siswa</h2>

            <table class="student-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Nama Siswa</th>
                        <th>Jurusan SMK</th>
                        <th>Rekomendasi Prodi Kuliah</th>
                        <th>Rekomendasi Tempat Magang</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($hasilSpk as $siswa)
                        @php
                            $namaSiswa = $siswa->user->nama ?? $siswa->user->name ?? '-';
                            $jurusanSiswa = $siswa->jurusanSmk->nama_jurusan ?? '-';

                            $hasilProdiTerbaik = $siswa->hasilJurusan->sortBy('rank')->first();
                            $hasilMagangTerbaik = $siswa->hasilMagang->sortBy('rank')->first();

                            $namaProdi = $hasilProdiTerbaik->jurusanKuliah->nama ?? 'Belum menentukan';
                            $namaMagang = $hasilMagangTerbaik->tempatMagang->nama ?? 'Belum menentukan';

                            $sudahAdaHasil = $hasilProdiTerbaik || $hasilMagangTerbaik;
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="name">{{ $namaSiswa }}</td>
                            <td>{{ $jurusanSiswa }}</td>
                            <td>{{ $namaProdi }}</td>
                            <td>{{ $namaMagang }}</td>
                            <td>
                                @if ($sudahAdaHasil)
                                    <span class="badge badge-success">Sudah Ada Hasil</span>
                                @else
                                    <span class="badge badge-warning">Belum Ada Hasil</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-row">Belum ada hasil SPK siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>