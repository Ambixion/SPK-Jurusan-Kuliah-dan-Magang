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
                    Prodi:
                    <span style="color:#86efac; font-weight:700;">
                        {{ $data['siswa_sudah_pilih_prodi'] ?? 0 }} Sudah
                    </span>
                    /
                    <span style="color:#fbbf24; font-weight:700;">
                        {{ $data['siswa_belum_pilih_prodi'] ?? 0 }} Belum
                    </span>
                </div>

                <div style="font-size: 13px; color: rgba(255,255,255,.75);">
                    Magang:
                    <span style="color:#86efac; font-weight:700;">
                        {{ $data['siswa_sudah_pilih_magang'] ?? 0 }} Sudah
                    </span>
                    /
                    <span style="color:#fbbf24; font-weight:700;">
                        {{ $data['siswa_belum_pilih_magang'] ?? 0 }} Belum
                    </span>
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
                            $namaSiswa = $siswa->user->nama ?? ($siswa->user->name ?? '-');

                            $jurusanSiswa = $siswa->jurusanSmk->nama_jurusan ?? '-';

                            $hasilProdiTerbaik = $siswa->hasilJurusan->sortBy('rank')->first();

                            $hasilMagangTerbaik = $siswa->hasilMagang->sortBy('rank')->first();

                            $namaProdi = $hasilProdiTerbaik->jurusanKuliah->nama ?? 'Belum menentukan';

                            $namaMagang = $hasilMagangTerbaik->tempatMagang->nama ?? 'Belum menentukan';

                            $sudahAdaHasilProdi = !is_null($hasilProdiTerbaik);

                            $sudahAdaHasilMagang = !is_null($hasilMagangTerbaik);
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
                                <div style="display:flex; flex-direction:column; gap:6px; align-items:center;">

                                    @if ($sudahAdaHasilProdi)
                                        <span class="badge-success">
                                            Prodi: Sudah Ada Hasil
                                        </span>
                                    @else
                                        <span class="badge-warning">
                                            Prodi: Belum Ada Hasil
                                        </span>
                                    @endif

                                    @if ($sudahAdaHasilMagang)
                                        <span class="badge-success">
                                            Magang: Sudah Ada Hasil
                                        </span>
                                    @else
                                        <span class="badge-warning">
                                            Magang: Belum Ada Hasil
                                        </span>
                                    @endif

                                </div>
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
