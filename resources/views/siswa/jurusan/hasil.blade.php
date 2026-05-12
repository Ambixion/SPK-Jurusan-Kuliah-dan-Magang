@extends('layouts.siswa')
@section('title', 'Hasil Rekomendasi Jurusan')
@section('content')
<h1 class="page-title">Pemilihan Program Studi Kuliah</h1>

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
            <div style="font-weight:700;color:#fdba74;font-size:13px;">Belum mengisi kuisoner</div>
            <div style="color:rgba(255,255,255,0.6);font-size:12px;margin-top:3px;">
                Isi kuisoner terlebih dahulu untuk mendapatkan hasil rekomendasi jurusan kuliah.
            </div>
        </div>
        <a href="{{ route('siswa.jurusan') }}"
           style="background:#f97316;color:#fff;padding:8px 18px;border-radius:20px;font-size:12px;font-weight:700;text-decoration:none;">
            Isi Sekarang →
        </a>
    </div>

    @else
    <div style="margin-top:24px;border-top:1px solid rgba(255,255,255,0.1);padding-top:20px;">
        <div class="card-title">List Hasil Program Studi Kuliah</div>

        @foreach($hasilJurusan as $hasil)
        @php
            // score sudah dalam bentuk persentase (0-100) dari SawController
            $persen    = number_format($hasil->score, 1);
            $rankColor = match($hasil->rank) {
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
                    {{ $hasil->jurusan->nama }}
                </div>
                <div style="font-size:11px;color:rgba(255,255,255,0.45);margin-top:2px;">
                    {{ $hasil->jurusan->bidang_studi ?? '' }}
                </div>
            </div>
            <div style="font-size:22px;font-weight:800;color:{{ $rankColor }};min-width:60px;text-align:right;">
                {{ $persen }}%
            </div>
            <button onclick="showInfo({{ $hasil->jurusan->id }})"
                    style="background:rgba(79,110,247,0.2);color:#a5b4fc;border:1px solid rgba(79,110,247,0.35);
                           padding:7px 18px;border-radius:20px;font-size:12px;font-weight:700;cursor:pointer;">
                Info
            </button>
        </div>
        @endforeach

        <div style="display:flex;justify-content:flex-end;margin-top:14px;">
            <a href="{{ route('siswa.jurusan') }}"
               style="background:rgba(255,255,255,0.1);color:#fff;padding:9px 20px;border-radius:20px;
                      font-size:12px;font-weight:700;text-decoration:none;border:1px solid rgba(255,255,255,0.2);">
                Isi Ulang Kuisoner
            </a>
        </div>
    </div>
    @endif
</div>

{{-- Modal Info Jurusan --}}
<div id="modalInfo" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.75);
     z-index:999;align-items:center;justify-content:center;">
    <div style="background:#1e2140;border:1px solid rgba(255,255,255,0.15);border-radius:16px;
                padding:28px;max-width:420px;width:90%;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
            <div id="mTitle" style="font-size:15px;font-weight:800;color:#fff;"></div>
            <button onclick="closeModal()"
                    style="background:none;border:none;color:rgba(255,255,255,0.5);font-size:20px;cursor:pointer;">✕</button>
        </div>
        <div id="mBody" style="color:rgba(255,255,255,0.7);font-size:13px;line-height:1.7;"></div>
    </div>
</div>

@push('scripts')
<script>
const jData = {
    @foreach($hasilJurusan as $h)
    {{ $h->jurusan->id }}: {
        nama: "{{ addslashes($h->jurusan->nama) }}",
        deskripsi: "{{ addslashes($h->jurusan->deskripsi ?? '-') }}",
        bidang: "{{ addslashes($h->jurusan->bidang_studi ?? '-') }}",
        skor: "{{ number_format($h->score, 1) }}%"
    },
    @endforeach
};
function showInfo(id) {
    const d = jData[id]; if (!d) return;
    document.getElementById('mTitle').textContent = d.nama;
    document.getElementById('mBody').innerHTML = `
        <p style="margin-bottom:10px;">${d.deskripsi}</p>
        <div style="display:flex;justify-content:space-between;padding:6px 0;border-top:1px solid rgba(255,255,255,0.1);">
            <span style="color:rgba(255,255,255,0.5);">Bidang Studi</span>
            <span style="color:#fff;font-weight:600;">${d.bidang}</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding:6px 0;">
            <span style="color:rgba(255,255,255,0.5);">Skor SAW</span>
            <span style="color:#86efac;font-weight:700;">${d.skor}</span>
        </div>`;
    document.getElementById('modalInfo').style.display = 'flex';
}
function closeModal() { document.getElementById('modalInfo').style.display = 'none'; }
document.getElementById('modalInfo').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endpush
@endsection
