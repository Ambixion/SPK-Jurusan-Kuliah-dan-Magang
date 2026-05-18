@extends('layouts.guru')

@section('content')
    <h1 class="page-title">
        Dashboard Guru
    </h1>

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
                            $namaSiswa = $siswa->user->nama ?? ($siswa->user->name ?? '-');
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
@endsection
