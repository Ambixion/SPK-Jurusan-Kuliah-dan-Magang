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

        .table-tools {
            display: grid;
            grid-template-columns: 1.6fr 0.9fr 0.9fr;
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
        }

        .search-box::placeholder {
            color: #ffffff;
            opacity: 0.95;
        }

        .filter-box {
            cursor: pointer;
        }

        .add-btn {
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: 0.25s ease;
        }

        .add-btn:hover {
            background: #6a6aff;
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
            padding: 7px 18px;
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
    max-width: 820px;
    background: #242467;
    border-radius: 16px;
    padding: 32px;
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

.form-group input:disabled {
    opacity: 0.75;
    cursor: not-allowed;
    background: #2b2b72;
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

            .stat-grid {
                grid-template-columns: 1fr;
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
                <a href="{{ route('guru.dashboard') }}" class="menu-item active">
                    <div class="menu-icon icon-yellow">👤</div>
                    <span>Dashboard Guru</span>
                </a>

                <a href="{{ route('guru.siswa.index') }}" class="menu-item">
                    <div class="menu-icon icon-red">👔</div>
                    <span>Tambah Data Siswa</span>
                </a>

                 <a href="{{ route('guru.tempat_magang') }}" class="menu-item active">
                    <div class="menu-icon purple">🏢</div>
                    <span>Data Pemilihan PKL</span>
                </a>

                <a href="{{ route('guru.jurusan_kuliah') }}" class="menu-item">
    <div class="menu-icon green">🏫</div>
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
            <h2 class="section-title">Data Siswa</h2>

            <div class="table-tools">
                <input type="text" id="searchInput" class="search-box" placeholder="🔍  Cari Nama / NISN">

                <select id="kelasFilter" class="filter-box">
                    <option value="">Semua Kelas</option>
                    <option value="10">Kelas 10</option>
                    <option value="11">Kelas 11</option>
                    <option value="12">Kelas 12</option>
                </select>

                <select id="jurusanFilter" class="filter-box">
                    <option value="">Semua Jurusan</option>
                    @php
                        $jurusanList = $siswaTerbaru->pluck('jurusanSmk.nama_jurusan')->filter()->unique();
                    @endphp

                    @foreach ($jurusanList as $jurusan)
                        <option value="{{ $jurusan }}">{{ $jurusan }}</option>
                    @endforeach
                </select>

                
            </div>

            <table class="student-table" id="studentTable">
                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Kelas</th>
                        <th>Jurusan SMK</th>
                        <th>Status SPK</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($siswaTerbaru as $siswa)
                        @php
                            $namaSiswa = $siswa->user->nama ?? $siswa->user->name ?? '-';
                            $nisnSiswa = $siswa->nisn ?? '-';
                            $kelasSiswa = $siswa->kelas ?? '-';
                            $jurusanSiswa = $siswa->jurusanSmk->nama_jurusan ?? '-';
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
                            <td>{{ $nisnSiswa }}</td>
                            <td>{{ $kelasSiswa !== '-' ? 'Kelas ' . $kelasSiswa : '-' }}</td>
                            <td>{{ $jurusanSiswa }}</td>
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
    class="action-btn open-edit-modal"
    data-nama="{{ $namaSiswa }}"
    data-email="{{ $siswa->user->email ?? '' }}"
    data-nisn="{{ $siswa->nisn ?? '' }}"
    data-kelas="{{ $siswa->kelas ?? '' }}"
    data-jurusan="{{ $siswa->jurusan_smk_id }}"
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
                            <td colspan="7" class="empty-row">Belum ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <section class="table-card">
            <h2 class="section-title">Hasil SPK Siswa</h2>

            <table class="student-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Nama Siswa</th>
                        <th>Rekomendasi Prodi Kuliah</th>
                        <th>Rekomendasi Tempat Magang</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($hasilSpk as $siswa)
                        @php
                            $namaSiswa = $siswa->user->nama ?? $siswa->user->name ?? '-';
                            $hasilProdiTerbaik = $siswa->hasilJurusan->sortBy('rank')->first();
                            $hasilMagangTerbaik = $siswa->hasilMagang->sortBy('rank')->first();

                            $namaProdi = $hasilProdiTerbaik->jurusanKuliah->nama ?? 'Belum menentukan';
                            $namaMagang = $hasilMagangTerbaik->tempatMagang->nama ?? 'Belum menentukan';

                            $sudahAdaHasil = $hasilProdiTerbaik || $hasilMagangTerbaik;
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="name">{{ $namaSiswa }}</td>
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
                            <td colspan="5" class="empty-row">Belum ada hasil SPK siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>
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

            const matchSearch = nama.includes(searchValue) || nisn.includes(searchValue);
            const matchKelas = kelasValue === '' || kelas === kelasValue;
            const matchJurusan = jurusanValue === '' || jurusan === jurusanValue;

            row.style.display = matchSearch && matchKelas && matchJurusan ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    kelasFilter.addEventListener('change', filterTable);
    jurusanFilter.addEventListener('change', filterTable);
</script>

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
                    <label>Password Default</label>
                    <input type="text" value="smkn5jember" disabled>
                    <div class="help">Password tidak bisa diubah dari popup ini.</div>
                </div>

                <div class="form-group">
                    <label>NISN</label>
                    <input type="text" name="nisn" id="editNisn" placeholder="Masukkan NISN siswa">
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
            </div>

            <div class="modal-actions">
                <button type="submit" class="action-btn">Simpan Perubahan</button>
                <button type="button" class="action-btn btn-cancel" id="cancelEditModal">Kembali</button>
            </div>
        </form>
    </div>
</div>

<script>
    const editModal = document.getElementById('editModal');
    const closeEditModal = document.getElementById('closeEditModal');
    const cancelEditModal = document.getElementById('cancelEditModal');
    const editForm = document.getElementById('editForm');

    const editNama = document.getElementById('editNama');
    const editEmail = document.getElementById('editEmail');
    const editNisn = document.getElementById('editNisn');
    const editKelas = document.getElementById('editKelas');
    const editJurusan = document.getElementById('editJurusan');

    document.querySelectorAll('.open-edit-modal').forEach(button => {
        button.addEventListener('click', function () {
            editForm.action = this.dataset.action;

            editNama.value = this.dataset.nama || '';
            editEmail.value = this.dataset.email || '';
            editNisn.value = this.dataset.nisn || '';
            editKelas.value = this.dataset.kelas || '';
            editJurusan.value = this.dataset.jurusan || '';

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

</body>
</html>