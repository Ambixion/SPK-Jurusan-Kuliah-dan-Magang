@extends('layouts.siswa')

@section('title', 'SPK SMKN 5 Jember')

@section('content')
<h1 class="page-title">Data Informasi Siswa</h1>

<div class="card-main">

    {{-- Profile Header --}}
    <div class="profile-header">
        <div class="profile-avatar">🎓</div>
        <div>
            <div class="profile-name">{{ $siswa->user->nama ?? '-' }}</div>
            <div class="profile-sub">
                {{ $siswa->alamat ?? 'Jember' }}
                &nbsp;–&nbsp;
                {{ $siswa->jenis_kelamin ?? 'Laki-laki' }}
            </div>
            <div class="profile-badges">
                <span class="badge-pill badge-purple">
                    NISN: {{ $siswa->nisn ?? '00000000000' }}
                </span>
                <span class="badge-pill badge-white">Aktif</span>
                <span class="badge-pill badge-purple">
                    Angkatan {{ date('Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Stat Grid --}}
    <div class="grid-4" style="margin-bottom:25px;">
        <div class="stat-box">
            <div class="stat-label-sm">Kelas</div>
            <div class="stat-value blue">{{ $siswa->kelas ?? '-' }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label-sm">Semester</div>
            <div class="stat-value green">{{ $siswa->semester ?? '-' }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label-sm">Jurusan</div>
            {{-- jurusan_siswa adalah accessor di Siswa model → jurusanSmk->nama_jurusan --}}
            <div class="stat-value" style="font-size:18px;">
                {{ $siswa->jurusan_siswa }}
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label-sm">Rata-rata Rapot</div>
            <div class="stat-value orange">{{ number_format($nilaiRata, 2) }}</div>
        </div>
    </div>

    {{-- Kontak & Akademik --}}
    <div class="grid-2">
        <div class="stat-box">
            <div class="info-section-title">Kontak</div>
            <div class="info-row">
                <span class="info-key">No. Telpon/HP</span>
                <span class="info-val">{{ $siswa->no_telp ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Email Siswa</span>
                <span class="info-val">{{ $siswa->user->email ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Alamat</span>
                <span class="info-val">{{ $siswa->alamat ?? '-' }}</span>
            </div>
        </div>
        <div class="stat-box">
            <div class="info-section-title">Akademik</div>
            <div class="info-row">
                <span class="info-key">Program Studi</span>
                <span class="info-val">{{ $siswa->jurusan_siswa }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Status</span>
                <span class="info-val" style="color:#4ade80;font-weight:600;">Aktif</span>
            </div>
            <div class="info-row">
                <span class="info-key">Semester Tempuh</span>
                <span class="info-val">{{ $siswa->semester ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Nilai Rata-rata</span>
                <span class="info-val highlight">{{ number_format($nilaiRata, 2) }}</span>
            </div>
        </div>
    </div>

</div>
@endsection
