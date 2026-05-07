@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
{{-- BIG STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div style="background:linear-gradient(135deg,#5b6af0,#7c3aed);border-radius:16px;padding:24px;">
            <div style="color:rgba(255,255,255,0.7);font-size:0.85rem;margin-bottom:8px;">Total Jurusan Kuliah</div>
            <div style="font-size:2.4rem;font-weight:700;color:#fff;line-height:1;">
                {{ $total_jurusan ?? 0 }} <span style="font-size:1rem;font-weight:400;opacity:0.8;">Prodi</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background:linear-gradient(135deg,#1e40af,#5b6af0);border-radius:16px;padding:24px;">
            <div style="color:rgba(255,255,255,0.7);font-size:0.85rem;margin-bottom:8px;">Total Jurusan SMK</div>
            <div style="font-size:2.4rem;font-weight:700;color:#fff;line-height:1;">
                {{ $total_jurusan_smk ?? 0 }} <span style="font-size:1rem;font-weight:400;opacity:0.8;">Jurusan</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background:linear-gradient(135deg,#7c3aed,#a855f7);border-radius:16px;padding:24px;">
            <div style="color:rgba(255,255,255,0.7);font-size:0.85rem;margin-bottom:8px;">Total Tempat Magang</div>
            <div style="font-size:2.4rem;font-weight:700;color:#fff;line-height:1;">
                {{ $total_tempat_magang ?? 0 }} <span style="font-size:1rem;font-weight:400;opacity:0.8;">Tempat</span>
            </div>
        </div>
    </div>
</div>

{{-- SMALLER STAT CARDS --}}
<div class="row g-3">
    <div class="col-md-3">
        <div class="card-dark d-flex align-items-center gap-3">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(139,92,246,0.2);display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">👥</div>
            <div>
                <div style="color:#8892a4;font-size:0.78rem;margin-bottom:2px;">Total User</div>
                <div style="font-size:1.8rem;font-weight:700;color:#fff;line-height:1;">{{ $total_user ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-dark d-flex align-items-center gap-3">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(34,197,94,0.2);display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">🎓</div>
            <div>
                <div style="color:#8892a4;font-size:0.78rem;margin-bottom:2px;">Total Siswa</div>
                <div style="font-size:1.8rem;font-weight:700;color:#fff;line-height:1;">{{ $total_siswa ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-dark d-flex align-items-center gap-3">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(59,130,246,0.2);display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">👨‍🏫</div>
            <div>
                <div style="color:#8892a4;font-size:0.78rem;margin-bottom:2px;">Total Guru</div>
                <div style="font-size:1.8rem;font-weight:700;color:#fff;line-height:1;">{{ $total_guru ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-dark d-flex align-items-center gap-3">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(245,158,11,0.2);display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">⚙️</div>
            <div>
                <div style="color:#8892a4;font-size:0.78rem;margin-bottom:2px;">Total Kriteria</div>
                <div style="font-size:1.8rem;font-weight:700;color:#fff;line-height:1;">{{ $total_kriteria ?? 0 }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
