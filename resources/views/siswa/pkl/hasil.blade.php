@extends('layouts.siswa')
@section('title', 'Hasil Rekomendasi PKL')
@section('content')
<h1 class="page-title">Pemilihan Tempat Praktek Kerja Lapangan</h1>

@if(session('success'))
<div class="alert-spk alert-success">{{ session('success') }}</div>
@endif

<div class="card-main">
    <div class="form-group">
        <label class="form-label">Nama Siswa</label>
        <input type="text" class="form-input" value="{{ Auth::user()->nama }}" readonly>
    </div>
    <div class="form-group">
        <label class="form-label">Jurusan</label>
        <input type="text" class="form-input" value="{{ $siswa->jurusan_siswa }}" readonly>
    </div>
    <div class="form-group">
        <label class="form-label">Nilai Rata-rata Rapot</label>
        <input type="text" class="form-input" value="{{ $nilaiRata }}" readonly>
    </div>

    @if(!$sudahMengisi)
    <div style="margin-top:20px;padding:16px 20px;background:rgba(249,115,22,0.15);
         border:1px solid rgba(249,115,22,0.3);border-radius:12px;display:flex;align-items:center;gap:12px;">
        <span style="font-size:20px;">⚠️</span>
        <div style="flex:1;">
            <div style="font-weight:700;color:#fdba74;font-size:13px;">Belum mengisi kuisoner PKL</div>
            <div style="color:rgba(255,255,255,0.6);font-size:12px;margin-top:3px;">
                Isi kuisoner PKL terlebih dahulu untuk mendapatkan rekomendasi tempat PKL.
            </div>
        </div>
        <a href="{{ route('siswa.pkl') }}"
           style="background:#f97316;color:#fff;padding:8px 18px;border-radius:20px;font-size:12px;font-weight:700;text-decoration:none;">
            Isi Sekarang →
        </a>
    </div>

    @else
    <div style="margin-top:24px;border-top:1px solid rgba(255,255,255,0.1);padding-top:20px;">
        <div class="card-title">List Hasil Tempat PKL</div>

        @foreach($hasilMagang as $hasil)
        @php
            // score sudah dalam bentuk persentase (0-100) dari SawController
            $persen     = number_format($hasil->score, 1);
            $rankColor  = match($hasil->rank) {
                1 => '#22c55e', 2 => '#4f6ef7', 3 => '#f59e0b', default => '#6b7280'
            };
        @endphp
        <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;margin-bottom:8px;
                    background:rgba(10,12,30,0.6);border:1px solid rgba(255,255,255,0.08);border-radius:12px;">
            <div style="width:34px;height:34px;border-radius:50%;background:{{ $rankColor }};
                        display:flex;align-items:center;justify-content:center;
                        font-weight:800;font-size:13px;color:#fff;flex-shrink:0;">
                {{ $hasil->rank }}
            </div>
            <div style="flex:1;">
                <div style="font-size:14px;font-weight:700;color:#fff;">
                    {{ $hasil->tempatMagang->nama }}
                </div>
                <div style="font-size:11px;color:rgba(255,255,255,0.45);margin-top:2px;">
                    {{ $hasil->tempatMagang->bidang ?? ($hasil->tempatMagang->deskripsi ? Str::limit($hasil->tempatMagang->deskripsi, 60) : '') }}
                </div>
            </div>
            <div style="font-size:22px;font-weight:800;color:{{ $rankColor }};min-width:60px;text-align:right;">
                {{ $persen }}%
            </div>
        </div>
        @endforeach

        <div style="display:flex;justify-content:flex-end;margin-top:14px;">
            <a href="{{ route('siswa.pkl') }}"
               style="background:rgba(255,255,255,0.1);color:#fff;padding:9px 20px;border-radius:20px;
                      font-size:12px;font-weight:700;text-decoration:none;border:1px solid rgba(255,255,255,0.2);">
                Isi Ulang Kuisoner
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
