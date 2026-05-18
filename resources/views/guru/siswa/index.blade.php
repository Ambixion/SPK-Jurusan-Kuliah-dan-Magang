<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>

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

        .table-tools {
            display: grid;
            grid-template-columns: 1.6fr 0.9fr 0.9fr 0.9fr;
            gap: 18px;
            margin-bottom: 22px;
        }

        .search-box,
        .filter-box,
        .add-btn {
            height: 44px;
            border: none;
            outline: none;
            border-radius: 25px;
            background: #5656ea;
            color: #ffffff;
            padding: 0 18px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.25s ease;
        }

        .search-box::placeholder {
            color: #ffffff;
            opacity: 0.95;
        }

        .filter-box {
            cursor: pointer;
        }

        .filter-box option {
            background: #242467;
            color: #ffffff;
        }

        .add-btn {
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .add-btn:hover {
            background: #6a6aff;
            transform: translateY(-2px);
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

        .action-group {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }

        .action-btn {
            border: none;
            text-decoration: none;
            padding: 7px 14px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            cursor: pointer;
            background: #4444d8;
            transition: 0.2s ease;
            font-family: 'Poppins', sans-serif;
        }

        .action-btn:hover {
            background: #5c5cff;
        }

        .show-btn {
    background: #2d9cdb;
}

.show-btn:hover {
    background: #39b7ff;
}

        .delete-btn {
            background: #d83d3d;
        }

        .delete-btn:hover {
            background: #ff4d4d;
        }

        .empty-row {
            padding: 30px !important;
            color: #d6d6e7 !important;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.68);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 30px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-card {
            width: 100%;
            max-width: 780px;
            max-height: 90vh;
            overflow-y: auto;
            background: #242467;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
            animation: modalPop 0.25s ease;
        }

        @keyframes modalPop {
            from {
                transform: scale(0.95);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 26px;
        }

        .modal-title {
            font-size: 26px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .modal-close {
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 50%;
            background: #d83d3d;
            color: white;
            font-size: 22px;
            cursor: pointer;
        }

        .modal-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group.full {
            grid-column: span 2;
        }

        .form-group label {
            display: block;
            margin-bottom: 9px;
            font-weight: 600;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            height: 50px;
            border: 2px solid rgba(255,255,255,0.12);
            outline: none;
            border-radius: 12px;
            background: #343493;
            color: white;
            padding: 0 18px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #7474ff;
        }

        .form-group select {
            cursor: pointer;
            appearance: none;
            background-image: linear-gradient(45deg, transparent 50%, #ffffff 50%),
                              linear-gradient(135deg, #ffffff 50%, transparent 50%);
            background-position: calc(100% - 22px) 21px, calc(100% - 16px) 21px;
            background-size: 6px 6px, 6px 6px;
            background-repeat: no-repeat;
        }

        .form-group select option {
            background: #242467;
            color: white;
        }

        .help {
            margin-top: 7px;
            font-size: 13px;
            color: #94d1d3;
        }

        .modal-actions {
            display: flex;
            gap: 14px;
            margin-top: 10px;
        }

        .btn-cancel {
            background: #3b3b78;
        }

        .detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.detail-item {
    background: #343493;
    border: 2px solid rgba(255, 255, 255, 0.10);
    border-radius: 12px;
    padding: 14px 16px;
}

.detail-item.full {
    grid-column: span 2;
}

.detail-item span {
    display: block;
    font-size: 13px;
    color: #94d1d3;
    margin-bottom: 6px;
}

.detail-item strong {
    display: block;
    font-size: 15px;
    color: #ffffff;
    word-break: break-word;
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

            .table-tools {
                grid-template-columns: 1fr 1fr;
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

            .table-card {
                overflow-x: auto;
            }

            .student-table {
                min-width: 950px;
            }

            .table-tools {
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
        <h1 class="page-title">Data Siswa</h1>

        <section class="table-card">
            <h2 class="section-title">Data Siswa</h2>

            <div class="table-tools">
                <input type="text" id="searchInput" class="search-box" placeholder="🔍  Cari Nama Siswa">

                <select id="kelasFilter" class="filter-box">
                    <option value="">Semua Kelas</option>
                    <option value="10">Kelas 10</option>
                    <option value="11">Kelas 11</option>
                    <option value="12">Kelas 12</option>
                </select>

                <select id="jurusanFilter" class="filter-box">
                    <option value="">Semua Jurusan</option>

                    @php
                        $jurusanList = $siswas->pluck('jurusanSmk.nama_jurusan')->filter()->unique();
                    @endphp

                    @foreach ($jurusanList as $jurusan)
                        <option value="{{ $jurusan }}">{{ $jurusan }}</option>
                    @endforeach
                </select>

                <button type="button" class="add-btn" id="openCreateModal">
                    + Data Siswa
                </button>
            </div>

            <table class="student-table" id="studentTable">
                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Nama Siswa</th>
                        <th>Jurusan SMK</th>
                        <th>Nilai</th>
                        <th>Status SPK</th>
                        <th style="width: 260px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
    @forelse ($siswas as $siswa)
        @php
            $namaSiswa = $siswa->user->nama ?? $siswa->user->name ?? '-';
            $emailSiswa = $siswa->user->email ?? '-';
            $nisnSiswa = $siswa->nisn ?? '-';
            $kelasSiswa = $siswa->kelas ?? '-';
            $semesterSiswa = $siswa->semester ?? '-';
            $jurusanSiswa = $siswa->jurusanSmk->nama_jurusan ?? '-';
            $nilaiRata = $siswa->nilaiSiswa->first()->nilai ?? '-';
            $noTelp = $siswa->no_telp ?? '-';
            $alamat = $siswa->alamat ?? '-';
            $sudahMengisi = $siswa->hasilJurusan->count() > 0 || $siswa->hasilMagang->count() > 0;
        @endphp

        <tr
            data-nama="{{ strtolower($namaSiswa) }}"
            data-nisn="{{ strtolower($nisnSiswa) }}"
            data-kelas="{{ strtolower($kelasSiswa) }}"
            data-jurusan="{{ strtolower($jurusanSiswa) }}"
        >
            <td>{{ $loop->iteration }}</td>
            <td class="name">{{ $namaSiswa }}</td>
            <td>{{ $jurusanSiswa }}</td>
            <td>{{ $nilaiRata }}</td>
            <td>
                @if ($sudahMengisi)
                    <span class="badge badge-success">Sudah Mengisi</span>
                @else
                    <span class="badge badge-warning">Belum Mengisi</span>
                @endif
            </td>
            <td>
                <div class="action-group">
                    <button
                        type="button"
                        class="action-btn show-btn open-show-modal"
                        data-nama="{{ $namaSiswa }}"
                        data-email="{{ $emailSiswa }}"
                        data-nisn="{{ $nisnSiswa }}"
                        data-kelas="{{ $kelasSiswa }}"
                        data-semester="{{ $semesterSiswa }}"
                        data-jurusan="{{ $jurusanSiswa }}"
                        data-no-telp="{{ $noTelp }}"
                        data-alamat="{{ $alamat }}"
                        data-nilai="{{ $nilaiRata }}"
                        data-status="{{ $sudahMengisi ? 'Sudah Mengisi' : 'Belum Mengisi' }}"
                    >
                        Show
                    </button>

                    <button
                        type="button"
                        class="action-btn open-edit-modal"
                        data-nama="{{ $namaSiswa }}"
                        data-email="{{ $siswa->user->email ?? '' }}"
                        data-nisn="{{ $siswa->nisn ?? '' }}"
                        data-kelas="{{ $siswa->kelas ?? '' }}"
                        data-semester="{{ $siswa->semester ?? '' }}"
                        data-jurusan="{{ $siswa->jurusan_smk_id }}"
                        data-no-telp="{{ $siswa->no_telp ?? '' }}"
                        data-alamat="{{ $siswa->alamat ?? '' }}"
                        data-nilai="{{ $siswa->nilaiSiswa->first()->nilai ?? '' }}"
                        data-action="{{ route('guru.siswa.update', $siswa->id) }}"
                    >
                        Edit
                    </button>

                    <form action="{{ route('guru.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete-btn">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="empty-row">Belum ada data siswa.</td>
        </tr>
    @endforelse
</tbody>
            </table>
        </section>
    </main>
</div>


<div class="modal-overlay" id="showModal">
    <div class="modal-card">
        <div class="modal-header">
            <h2 class="modal-title">Detail Data Siswa</h2>
            <button type="button" class="modal-close" id="closeShowModal">×</button>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <span>Nama Siswa</span>
                <strong id="showNama">-</strong>
            </div>

            <div class="detail-item">
                <span>Email</span>
                <strong id="showEmail">-</strong>
            </div>

            <div class="detail-item">
                <span>NISN</span>
                <strong id="showNisn">-</strong>
            </div>

            <div class="detail-item">
                <span>No. Telepon</span>
                <strong id="showNoTelp">-</strong>
            </div>

            <div class="detail-item">
                <span>Kelas</span>
                <strong id="showKelas">-</strong>
            </div>

            <div class="detail-item">
                <span>Semester</span>
                <strong id="showSemester">-</strong>
            </div>

            <div class="detail-item">
                <span>Jurusan SMK</span>
                <strong id="showJurusan">-</strong>
            </div>

            <div class="detail-item">
                <span>Nilai Rata-rata</span>
                <strong id="showNilai">-</strong>
            </div>

            <div class="detail-item">
                <span>Status SPK</span>
                <strong id="showStatus">-</strong>
            </div>

            <div class="detail-item full">
                <span>Alamat</span>
                <strong id="showAlamat">-</strong>
            </div>
        </div>

        <div class="modal-actions">
            <button type="button" class="action-btn btn-cancel" id="cancelShowModal">Kembali</button>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH SISWA --}}
<div class="modal-overlay" id="createModal">
    <div class="modal-card">
        <div class="modal-header">
            <h2 class="modal-title">Tambah Data Siswa</h2>
            <button type="button" class="modal-close" id="closeCreateModal">×</button>
        </div>

        <form action="{{ route('guru.siswa.store') }}" method="POST">
            @csrf

            <div class="modal-form-grid">
                <div class="form-group">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama siswa" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email siswa" required>
                </div>

                <div class="form-group">
                    <label>NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="Masukkan NISN siswa">
                </div>

                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp') }}" placeholder="Contoh: 085712345678">
                </div>

                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas" required>
                        <option value="">Pilih Kelas</option>
                        <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>Kelas 10</option>
                        <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>Kelas 11</option>
                        <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>Kelas 12</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Semester</label>
                    <select name="semester" required>
                        <option value="">Pilih Semester</option>
                        <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                        <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
                        <option value="3" {{ old('semester') == '3' ? 'selected' : '' }}>Semester 3</option>
                        <option value="4" {{ old('semester') == '4' ? 'selected' : '' }}>Semester 4</option>
                        <option value="5" {{ old('semester') == '5' ? 'selected' : '' }}>Semester 5</option>
                        <option value="6" {{ old('semester') == '6' ? 'selected' : '' }}>Semester 6</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jurusan Siswa</label>
                    <select name="jurusan_smk_id" required>
                        <option value="">Pilih Jurusan</option>

                        @foreach($jurusanSmk as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ old('jurusan_smk_id') == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nilai Rata-rata</label>
                    <input type="number" step="0.01" name="nilai_rata_rata" value="{{ old('nilai_rata_rata') }}" placeholder="Contoh: 85.50" required>
                </div>

                <div class="form-group full">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat siswa">
                </div>
            </div>

            <div class="help">
                Password default siswa otomatis: <b>smkn5jember</b>
            </div>

            <div class="modal-actions">
                <button type="submit" class="action-btn">Simpan Data</button>
                <button type="button" class="action-btn btn-cancel" id="cancelCreateModal">Kembali</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT SISWA --}}
<div class="modal-overlay" id="editModal">
    <div class="modal-card">
        <div class="modal-header">
            <h2 class="modal-title">Edit Data Siswa</h2>
            <button type="button" class="modal-close" id="closeEditModal">×</button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-form-grid">
                <div class="form-group">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama" id="editNama" placeholder="Masukkan nama siswa" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="editEmail" placeholder="Masukkan email siswa" required>
                </div>

                <div class="form-group">
                    <label>NISN</label>
                    <input type="text" name="nisn" id="editNisn" placeholder="Masukkan NISN siswa">
                </div>

                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telp" id="editNoTelp" placeholder="Contoh: 085712345678">
                </div>

                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas" id="editKelas" required>
                        <option value="">Pilih Kelas</option>
                        <option value="10">Kelas 10</option>
                        <option value="11">Kelas 11</option>
                        <option value="12">Kelas 12</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Semester</label>
                    <select name="semester" id="editSemester" required>
                        <option value="">Pilih Semester</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                        <option value="3">Semester 3</option>
                        <option value="4">Semester 4</option>
                        <option value="5">Semester 5</option>
                        <option value="6">Semester 6</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jurusan Siswa</label>
                    <select name="jurusan_smk_id" id="editJurusan" required>
                        <option value="">Pilih Jurusan</option>

                        @foreach($jurusanSmk as $jurusan)
                            <option value="{{ $jurusan->id }}">
                                {{ $jurusan->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nilai Rata-rata</label>
                    <input type="number" step="0.01" name="nilai_rata_rata" id="editNilai" placeholder="Contoh: 85.50" required>
                </div>

                <div class="form-group full">
                    <label>Alamat</label>
                    <input type="text" name="alamat" id="editAlamat" placeholder="Masukkan alamat siswa">
                </div>
            </div>

            <div class="modal-actions">
                <button type="submit" class="action-btn">Simpan Perubahan</button>
                <button type="button" class="action-btn btn-cancel" id="cancelEditModal">Kembali</button>
            </div>
        </form>
    </div>
</div>

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

    createModal.addEventListener('click', function (e) {
        if (e.target === createModal) {
            hideCreateModal();
        }
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
        button.addEventListener('click', function () {
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

    editModal.addEventListener('click', function (e) {
        if (e.target === editModal) {
            closeModal();
        }
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
    const showStatus = document.getElementById('showStatus');
    const showAlamat = document.getElementById('showAlamat');

    document.querySelectorAll('.open-show-modal').forEach(button => {
        button.addEventListener('click', function () {
            showNama.textContent = this.dataset.nama || '-';
            showEmail.textContent = this.dataset.email || '-';
            showNisn.textContent = this.dataset.nisn || '-';
            showNoTelp.textContent = this.dataset.noTelp || '-';
            showKelas.textContent = this.dataset.kelas !== '-' ? 'Kelas ' + this.dataset.kelas : '-';
            showSemester.textContent = this.dataset.semester !== '-' ? 'Semester ' + this.dataset.semester : '-';
            showJurusan.textContent = this.dataset.jurusan || '-';
            showNilai.textContent = this.dataset.nilai || '-';
            showStatus.textContent = this.dataset.status || '-';
            showAlamat.textContent = this.dataset.alamat || '-';

            showModal.classList.add('show');
        });
    });

    function closeShowModalBox() {
        showModal.classList.remove('show');
    }

    closeShowModal.addEventListener('click', closeShowModalBox);
    cancelShowModal.addEventListener('click', closeShowModalBox);

    showModal.addEventListener('click', function (e) {
        if (e.target === showModal) {
            closeShowModalBox();
        }
    });
</script>

</body>
</html>
