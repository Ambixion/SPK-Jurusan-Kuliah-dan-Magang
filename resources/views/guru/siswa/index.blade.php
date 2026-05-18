@extends('layouts.guru')

@section('title', 'Data Siswa')

@section('content')

    <h1 class="page-title">
        Data Siswa
    </h1>

    <div class="card-main page-table-card">

        <div class="toolbar-filter">

            <div class="search-box">

                <span class="search-icon">
                    🔍
                </span>

                <input type="text" id="searchInput" class="search-input" placeholder="Cari nama siswa...">

            </div>

            <select id="kelasFilter" class="filter-select">

                <option value="">
                    Semua Kelas
                </option>

                <option value="10">
                    Kelas 10
                </option>

                <option value="11">
                    Kelas 11
                </option>

                <option value="12">
                    Kelas 12
                </option>

            </select>

        </div>

        <div class="table-tools">

            <select id="jurusanFilter" class="filter-select">

                <option value="">
                    Semua Jurusan
                </option>

                @php
                    $jurusanList = $siswas->pluck('jurusanSmk.nama_jurusan')->filter()->unique();
                @endphp

                @foreach ($jurusanList as $jurusan)
                    <option value="{{ $jurusan }}">
                        {{ $jurusan }}
                    </option>
                @endforeach

            </select>

            <button type="button" class="add-btn" id="openCreateModal">

                + Data Siswa

            </button>

        </div>

        <div class="dashboard-table-card">

            <div class="table-scroll-dashboard">

                <table class="student-table" id="studentTable">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Siswa</th>
                            <th>Jurusan SMK</th>
                            <th>Nilai</th>
                            <th>Status SPK</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($siswas as $siswa)
                            @php
                                $namaSiswa = $siswa->user->nama ?? ($siswa->user->name ?? '-');
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

                            <tr data-nama="{{ strtolower($namaSiswa) }}" data-nisn="{{ strtolower($nisnSiswa) }}"
                                data-kelas="{{ strtolower($kelasSiswa) }}" data-jurusan="{{ strtolower($jurusanSiswa) }}">

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td class="text-left table-title">
                                    {{ $namaSiswa }}
                                </td>

                                <td>
                                    {{ $jurusanSiswa }}
                                </td>

                                <td>
                                    {{ $nilaiRata }}
                                </td>

                                <td>
                                    @if ($sudahMengisi)
                                        <span class="badge-success">
                                            Sudah Mengisi
                                        </span>
                                    @else
                                        <span class="badge-warning">
                                            Belum Mengisi
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="action-group">

                                        <button type="button" class="action-btn show-btn open-show-modal"
                                            data-nama="{{ $namaSiswa }}" data-email="{{ $emailSiswa }}"
                                            data-nisn="{{ $nisnSiswa }}" data-kelas="{{ $kelasSiswa }}"
                                            data-semester="{{ $semesterSiswa }}" data-jurusan="{{ $jurusanSiswa }}"
                                            data-no-telp="{{ $noTelp }}" data-alamat="{{ $alamat }}"
                                            data-nilai="{{ $nilaiRata }}"
                                            data-status="{{ $sudahMengisi ? 'Sudah Mengisi' : 'Belum Mengisi' }}">

                                            Show

                                        </button>

                                        <button type="button" class="action-btn open-edit-modal"
                                            data-nama="{{ $namaSiswa }}" data-email="{{ $siswa->user->email ?? '' }}"
                                            data-nisn="{{ $siswa->nisn ?? '' }}" data-kelas="{{ $siswa->kelas ?? '' }}"
                                            data-semester="{{ $siswa->semester ?? '' }}"
                                            data-jurusan="{{ $siswa->jurusan_smk_id }}"
                                            data-no-telp="{{ $siswa->no_telp ?? '' }}"
                                            data-alamat="{{ $siswa->alamat ?? '' }}"
                                            data-nilai="{{ $siswa->nilaiSiswa->first()->nilai ?? '' }}"
                                            data-action="{{ route('guru.siswa.update', $siswa->id) }}">

                                            Edit

                                        </button>

                                        <form action="{{ route('guru.siswa.destroy', $siswa->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="action-btn delete-btn">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="empty-data">
                                    Belum ada data siswa.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

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

            {{-- <div class="modal-actions">
                <button type="button" class="action-btn btn-cancel" id="cancelShowModal">Kembali</button>
            </div> --}}
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
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            placeholder="Masukkan nama siswa" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="Masukkan email siswa" required>
                    </div>

                    <div class="form-group">
                        <label>NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}"
                            placeholder="Masukkan NISN siswa">
                    </div>

                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                            placeholder="Contoh: 085712345678">
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

                            @foreach ($jurusanSmk as $jurusan)
                                <option value="{{ $jurusan->id }}"
                                    {{ old('jurusan_smk_id') == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nilai Rata-rata</label>
                        <input type="number" step="0.01" name="nilai_rata_rata"
                            value="{{ old('nilai_rata_rata') }}" placeholder="Contoh: 85.50" required>
                    </div>

                    <div class="form-group full">
                        <label>Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}"
                            placeholder="Masukkan alamat siswa">
                    </div>
                </div>

                <div class="help">
                    Password default siswa otomatis: <b>smkn5jember</b>
                </div>

                <div class="modal-actions">
                    <button type="button" class="action-btn submit-btn">Simpan Data</button>

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

                            @foreach ($jurusanSmk as $jurusan)
                                <option value="{{ $jurusan->id }}">
                                    {{ $jurusan->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nilai Rata-rata</label>
                        <input type="number" step="0.01" name="nilai_rata_rata" id="editNilai"
                            placeholder="Contoh: 85.50" required>
                    </div>

                    <div class="form-group full">
                        <label>Alamat</label>
                        <input type="text" name="alamat" id="editAlamat" placeholder="Masukkan alamat siswa">
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="action-btn submit-btn">Simpan Perubahan</button>

                </div>
            </form>
        </div>
    </div>

@endsection



