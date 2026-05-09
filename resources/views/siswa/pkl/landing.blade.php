@extends('layouts.siswa')
@section('title', 'Pemilihan Tempat PKL')
@section('content')
<h1 class="page-title">Pemilihan Tempat Praktek Kerja Lapangan</h1>

@if(session('success'))
<div class="alert-spk alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert-spk alert-error">{{ session('error') }}</div>
@endif

<div class="card-main">
    <div class="card-title">Data Diri Siswa</div>

    {{-- Data Siswa (readonly) --}}
    <div class="form-group">
        <label class="form-label">Nama Siswa</label>
        <input type="text" class="form-input" value="{{ Auth::user()->nama }}" readonly>
    </div>

    <div class="form-group">
        <label class="form-label">Jurusan, Kelas, dan Semester</label>
        <input type="text" class="form-input"
               value="{{ $siswa->jurusan_siswa }}, {{ $siswa->kelas }}, Semester {{ $siswa->semester }}"
               readonly>
    </div>

    <div class="form-group">
        <label class="form-label">Nilai Rata-rata Rapot</label>
        <input type="text" class="form-input" value="{{ $nilaiRata }}" readonly>
    </div>

    {{-- Bidang — dari DB (dinamis) --}}
    <div class="form-group">
        <label class="form-label">
            Bidang yang Ingin Kamu Eksplorasi
            <span style="color:rgba(255,255,255,0.4);font-size:11px;margin-left:6px;">
                (opsional, pilih satu atau lebih)
            </span>
        </label>
        <div class="pills-group">
            @forelse($bidangs as $bidang)
            <button type="button"
                    class="pill pill-default"
                    data-bidang-id="{{ $bidang->id }}"
                    data-bidang-nama="{{ $bidang->nama }}"
                    onclick="toggleBidang(this)">
                {{ $bidang->nama }}
            </button>
            @empty
            <p style="color:rgba(255,255,255,0.4);font-size:12px;">
                Belum ada bidang. Admin perlu menambahkan bidang terlebih dahulu.
            </p>
            @endforelse
        </div>
    </div>

    {{-- Info sudah mengisi --}}
    @if($sudahMengisi)
    <div style="display:flex;justify-content:space-between;align-items:center;
                padding:14px 18px;background:rgba(34,197,94,0.1);
                border:1px solid rgba(34,197,94,0.25);border-radius:12px;margin-bottom:14px;">
        <div>
            <div style="font-size:13px;font-weight:700;color:#86efac;">✅ Sudah mengisi kuisoner PKL</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.55);margin-top:3px;">
                Anda bisa melihat hasil atau mengisi ulang.
            </div>
        </div>
        <a href="{{ route('siswa.pkl.hasil') }}"
           style="background:#22c55e;color:#fff;padding:8px 18px;border-radius:20px;
                  font-size:12px;font-weight:700;text-decoration:none;">
            Lihat Hasil →
        </a>
    </div>
    @endif

    <div style="display:flex;justify-content:flex-end;margin-top:20px;">
        <a id="btnKuisionerPkl" href="{{ route('siswa.pkl.kuisoner') }}" class="btn-primary-spk">
            Lanjut ke Kuisoner →
        </a>
    </div>
</div>

@push('scripts')
<script>
const baseUrl = "{{ route('siswa.pkl.kuisoner') }}";

function toggleBidang(btn) {
    btn.classList.toggle('pill-selected-green');
    btn.classList.toggle('pill-default', !btn.classList.contains('pill-selected-green'));
    updateUrl();
}

function updateUrl() {
    const bidangIds = [...document.querySelectorAll('[data-bidang-id].pill-selected-green')]
        .map(b => b.dataset.bidangId);

    const params = new URLSearchParams();
    if (bidangIds.length) params.set('bidang_ids', bidangIds.join(','));

    document.getElementById('btnKuisionerPkl').href =
        baseUrl + (params.toString() ? '?' + params.toString() : '');
}
</script>
@endpush
@endsection
