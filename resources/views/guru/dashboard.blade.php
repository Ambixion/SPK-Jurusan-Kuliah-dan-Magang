@extends('layouts.guru')

@section('title', 'Dashboard Guru')

@section('content')

<h1 class="page-title">
    Dashboard Guru
</h1>

{{-- STATISTIK --}}
<section class="grid-4">

    <div class="stat-box">
        <div class="stat-label-sm">
            Total Siswa
        </div>

        <div class="stat-value blue">
            {{ $data['total_siswa'] ?? 0 }}
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-label-sm">
            Tempat Magang
        </div>

        <div class="stat-value green">
            {{ $data['total_tempat_magang'] ?? 0 }}
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-label-sm">
            Prodi Kuliah
        </div>

        <div class="stat-value orange">
            {{ $data['total_prodi_kuliah'] ?? 0 }}
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-label-sm">
            Status SPK
        </div>

        <div style="margin-top: 10px; line-height: 1.7;">

            <div style="font-size: 13px; color: rgba(255,255,255,.75);">
                {{ $data['siswa_sudah_pilih_prodi'] ?? 0 }}
                Siswa Sudah Pilih Prodi
            </div>

            <div style="font-size: 13px; color: rgba(255,255,255,.75);">
                {{ $data['siswa_sudah_pilih_magang'] ?? 0 }}
                Siswa Sudah Pilih Magang
            </div>

        </div>
    </div>

</section>

{{-- TABLE HASIL SPK --}}
<div class="card-main dashboard-table-card">

    <div class="card-title">
        Hasil SPK Siswa
    </div>

    <div class="table-scroll-dashboard">

        <table class="student-table">

            <thead>

                <tr>
                    <th style="width:70px;">No</th>
                    <th>Nama Siswa</th>
                    <th>Jurusan SMK</th>
                    <th>Rekomendasi Prodi</th>
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

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td style="text-align:left; font-weight:600;">
                            {{ $namaSiswa }}
                        </td>

                        <td>
                            {{ $jurusanSiswa }}
                        </td>

                        <td>
                            {{ $namaProdi }}
                        </td>

                        <td>
                            {{ $namaMagang }}
                        </td>

                        <td>

                            @if ($sudahAdaHasil)

                                <span class="badge-success">
                                    Sudah Ada Hasil
                                </span>

                            @else

                                <span class="badge-warning">
                                    Belum Ada Hasil
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" style="padding:30px;">

                            <div style="color: rgba(255,255,255,.6);">
                                Belum ada hasil SPK siswa.
                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

