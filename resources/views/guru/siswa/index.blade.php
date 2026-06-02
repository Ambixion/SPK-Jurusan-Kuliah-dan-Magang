@extends('layouts.guru')

@section('title', 'Data Siswa')

@section('content')

    <h1 class="page-title">
        Data Siswa
    </h1>

    <div class="card-main page-table-card">

        <div class="table-tools">

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

                                $hasilProdiTerbaik = $siswa->hasilJurusan->sortBy('rank')->first();
                                $hasilMagangTerbaik = $siswa->hasilMagang->sortBy('rank')->first();

                                $sudahAdaHasilProdi = !is_null($hasilProdiTerbaik);
                                $sudahAdaHasilMagang = !is_null($hasilMagangTerbaik);

                                $namaProdi =
                                    $hasilProdiTerbaik && $hasilProdiTerbaik->jurusan
                                        ? $hasilProdiTerbaik->jurusan->nama
                                        : 'Belum menentukan';

                                $namaMagang =
                                    $hasilMagangTerbaik && $hasilMagangTerbaik->tempatMagang
                                        ? $hasilMagangTerbaik->tempatMagang->nama
                                        : 'Belum menentukan';
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
                                    <div style="display:flex; flex-direction:column; gap:6px; align-items:center;">

                                        @if ($sudahAdaHasilProdi)
                                            <span class="badge-success">
                                                Prodi: {{ $namaProdi }}
                                            </span>
                                        @else
                                            <span class="badge-warning">
                                                Prodi: Belum Ada Hasil
                                            </span>
                                        @endif

                                        @if ($sudahAdaHasilMagang)
                                            <span class="badge-success">
                                                Magang: {{ $namaMagang }}
                                            </span>
                                        @else
                                            <span class="badge-warning">
                                                Magang: Belum Ada Hasil
                                            </span>
                                        @endif

                                    </div>
                                </td>
                                <td>
                                    <div class="action-group">

                                        {{-- TOMBOL SHOW --}}
                                        <button type="button" class="action-btn show-btn open-show-modal"
                                            data-nama="{{ $namaSiswa }}" data-email="{{ $emailSiswa }}"
                                            data-nisn="{{ $nisnSiswa }}" data-kelas="{{ $kelasSiswa }}"
                                            data-semester="{{ $semesterSiswa }}" data-jurusan="{{ $jurusanSiswa }}"
                                            data-no-telp="{{ $noTelp }}" data-alamat="{{ $alamat }}"
                                            data-nilai="{{ $nilaiRata }}"
                                            data-status-prodi="{{ $sudahAdaHasilProdi ? $namaProdi : 'Belum Ada Hasil' }}"
                                            data-status-magang="{{ $sudahAdaHasilMagang ? $namaMagang : 'Belum Ada Hasil' }}">
                                            Show
                                        </button>

                                        {{-- TOMBOL EDIT --}}
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

                                        {{-- FORM HAPUS --}}
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


    {{-- ============================================================
         MODAL SHOW / DETAIL SISWA
    ============================================================ --}}
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
                    <span>Hasil SPK Prodi</span>
                    <strong id="showStatusProdi">-</strong>
                </div>

                <div class="detail-item">
                    <span>Hasil SPK Magang</span>
                    <strong id="showStatusMagang">-</strong>
                </div>

                <div class="detail-item full">
                    <span>Alamat</span>
                    <strong id="showAlamat">-</strong>
                </div>

            </div>

            {{--
                Tombol Kembali WAJIB ada (tidak boleh di-comment).
                JS di layouts.guru mereferensikan id="cancelShowModal".
                Jika elemen ini tidak ada, addEventListener akan throw error
                dan seluruh JS modal di halaman ini ikut gagal.
            --}}
            <div class="modal-actions">
                <button type="button" class="action-btn btn-cancel" id="cancelShowModal">
                    Kembali
                </button>
            </div>

        </div>
    </div>


    {{-- ============================================================
         MODAL TAMBAH SISWA
    ============================================================ --}}
    <div class="modal-overlay" id="createModal">
        <div class="modal-card">

            <div class="modal-header">
                <h2 class="modal-title">Tambah Data Siswa</h2>
                <button type="button" class="modal-close" id="closeCreateModal">×</button>
            </div>

            <form action="{{ route('guru.siswa.store') }}" method="POST">
                @csrf
                <input type="hidden" name="form_type" value="create">

                @if ($errors->any() && old('form_type') === 'create')
                    <div class="alert-container modal-alert-container">
                        <div class="alert-spk alert-error modal-alert">{{ $errors->first() }}</div>
                    </div>
                @endif

                <div class="modal-form-grid">

                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            placeholder="Masukkan nama siswa" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
    placeholder="Contoh: siswa@gmail.com"
    pattern="^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$"
    title="Masukkan email dengan format yang benar, contoh: siswa@gmail.com"
    required>
                    </div>

                    <div class="form-group">
                        <label>NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}"
                            placeholder="Masukkan NISN siswa" inputmode="numeric" pattern="[0-9]*"
                            minlength="10" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                            placeholder="Contoh: 085712345678" inputmode="numeric" pattern="[0-9]*"
                            minlength="10" maxlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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

                    {{--
                        type="submit" WAJIB — tanpa ini tombol tidak akan
                        mengirim form meskipun berada di dalam <form>.
                    --}}
                    <button type="submit" class="action-btn submit-btn">
                        Simpan Data
                    </button>

                    {{--
                        id="cancelCreateModal" WAJIB ada.
                        JS di layouts.guru mereferensikan elemen ini.
                        Tanpanya addEventListener akan throw error.
                    --}}
                    <button type="button" class="action-btn btn-cancel" id="cancelCreateModal">
                        Kembali
                    </button>

                </div>

            </form>

        </div>
    </div>


    {{-- ============================================================
         MODAL EDIT SISWA
    ============================================================ --}}
    <div class="modal-overlay" id="editModal">
        <div class="modal-card">

            <div class="modal-header">
                <h2 class="modal-title">Edit Data Siswa</h2>
                <button type="button" class="modal-close" id="closeEditModal">×</button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="edit">

                <div class="modal-form-grid">

                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <input type="text" name="nama" id="editNama" placeholder="Masukkan nama siswa" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="editEmail"
    placeholder="Contoh: siswa@gmail.com"
    pattern="^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$"
    title="Masukkan email dengan format yang benar, contoh: siswa@gmail.com"
    required>
                    </div>

                    <div class="form-group">
                        <label>NISN</label>
                        <input type="text" name="nisn" id="editNisn" placeholder="Masukkan NISN siswa"
                            inputmode="numeric" pattern="[0-9]*"
                            minlength="10" maxlength="10"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="no_telp" id="editNoTelp" placeholder="Contoh: 085712345678"
                            inputmode="numeric" pattern="[0-9]*"
                            minlength="10" maxlength="12"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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

                    {{--
                        type="submit" WAJIB — tanpa ini form edit tidak akan terkirim.
                    --}}
                    <button type="submit" class="action-btn submit-btn">
                        Simpan Perubahan
                    </button>

                    {{--
                        id="cancelEditModal" WAJIB ada.
                        JS di layouts.guru mereferensikan elemen ini.
                    --}}
                    <button type="button" class="action-btn btn-cancel" id="cancelEditModal">
                        Kembali
                    </button>

                </div>

            </form>

        </div>
    </div>

@endsection
