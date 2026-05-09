@extends('layouts.siswa')
@section('title', 'Pemilihan Program Studi Kuliah')
@section('content')
<h1 class="page-title">Pemilihan Program Studi Kuliah</h1>

@if(session('success'))
<div class="alert-spk alert-success">{{ session('success') }}</div>
@endif

<div class="card-main">
    <div class="card-title">Data Diri Siswa</div>

    <div class="form-group">
        <label class="form-label">Nama Siswa</label>
        <input type="text" class="form-input" value="{{ Auth::user()->nama }}" readonly>
    </div>
    <div class="form-group">
        <label class="form-label">Jurusan, Kelas, dan Semester</label>
        <input type="text" class="form-input" value="{{ $siswa->jurusan_siswa }}" readonly>
    </div>
    <div class="form-group">
        <label class="form-label">Nilai Rata-rata Rapot</label>
        <input type="text" class="form-input" value="{{ $nilaiRata }}" readonly>
    </div>

    {{-- Tujuan Setelah Lulus --}}
    <div class="form-group">
        <label class="form-label">Tujuan Setelah Lulus</label>
        <div class="pills-group" id="tujuanGroup">
            @foreach(['Langsung Kerja', 'Kuliah', 'Belum Yakin'] as $opt)
            <button type="button" class="pill pill-default"
                    data-val="{{ $opt }}" onclick="pilihTujuan(this)">
                {{ $opt }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- Bidang Eksplorasi — muncul setelah pilih Kuliah/Belum Yakin --}}
    <div class="form-group" id="bidangGroup" style="display:none;">
        <label class="form-label">Bidang yang Ingin Kamu Eksplorasi</label>
        <div class="pills-group">
            @foreach(['Teknologi', 'Bisnis', 'Kreatif', 'Pertanian', 'Peternakan', 'Perikanan', 'Teknik'] as $opt)
            <button type="button" class="pill pill-default pill-multi"
                    data-bidang="{{ $opt }}" onclick="toggleBidang(this)">
                {{ $opt }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- Info sudah mengisi --}}
    @if($sudahMengisi)
    <div id="infoSudahMengisi"
         style="display:none;justify-content:space-between;align-items:center;
                padding:14px 18px;background:rgba(34,197,94,0.1);
                border:1px solid rgba(34,197,94,0.25);border-radius:12px;margin-top:16px;">
        <div>
            <div style="font-size:13px;font-weight:700;color:#86efac;">✅ Sudah mengisi kuisoner</div>
            <div style="font-size:11px;color:rgba(255,255,255,0.55);margin-top:3px;">
                Anda bisa melihat hasil atau mengisi ulang.
            </div>
        </div>
        <a href="{{ route('siswa.jurusan.hasil') }}"
           style="background:#22c55e;color:#fff;padding:8px 18px;border-radius:20px;
                  font-size:12px;font-weight:700;text-decoration:none;">
            Lihat Hasil →
        </a>
    </div>
    @endif

    {{-- Tombol Lanjut ke Kuisoner --}}
    <div id="btnKuisionerArea" style="display:none;margin-top:20px;">
        <div style="display:flex;justify-content:flex-end;">
            <a id="btnKuisoner" href="{{ route('siswa.jurusan.kuisoner') }}"
               class="btn-primary-spk">
                Lanjut ke Kuisoner →
            </a>
        </div>
    </div>

    {{-- Kalau pilih Langsung Kerja --}}
    <div id="btnLangsungKerja" style="display:none;margin-top:20px;">
        <div style="padding:16px 18px;background:rgba(249,115,22,0.12);
                    border:1px solid rgba(249,115,22,0.3);border-radius:12px;margin-bottom:14px;">
            <div style="font-size:13px;font-weight:700;color:#fdba74;margin-bottom:4px;">
                💼 Kamu memilih Langsung Kerja
            </div>
            <div style="font-size:12px;color:rgba(255,255,255,0.6);">
                Kami arahkan ke pemilihan tempat PKL yang sesuai untukmu.
            </div>
        </div>
        <div style="display:flex;justify-content:flex-end;">
            <a href="{{ route('siswa.pkl') }}"
               class="btn-primary-spk"
               style="background:linear-gradient(135deg,#f97316,#ef4444);">
                Pilih Tempat PKL →
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
const sudahMengisi = {{ $sudahMengisi ? 'true' : 'false' }};

function pilihTujuan(btn) {
    document.querySelectorAll('#tujuanGroup .pill').forEach(b => {
        b.classList.remove('pill-selected-blue');
        b.classList.add('pill-default');
    });
    btn.classList.remove('pill-default');
    btn.classList.add('pill-selected-blue');

    const val = btn.dataset.val;
    const bidangGroup       = document.getElementById('bidangGroup');
    const btnKuisionerArea  = document.getElementById('btnKuisionerArea');
    const btnLangsungKerja  = document.getElementById('btnLangsungKerja');
    const infoSudah         = document.getElementById('infoSudahMengisi');

    if (val === 'Langsung Kerja') {
        bidangGroup.style.display      = 'none';
        btnKuisionerArea.style.display = 'none';
        btnLangsungKerja.style.display = 'block';
        if (infoSudah) infoSudah.style.display = 'none';
    } else {
        btnLangsungKerja.style.display  = 'none';
        bidangGroup.style.display       = 'block';
        btnKuisionerArea.style.display  = 'block';
        if (infoSudah) infoSudah.style.display = 'flex';
    }
}

function toggleBidang(btn) {
    if (btn.classList.contains('pill-selected-green')) {
        btn.classList.remove('pill-selected-green');
        btn.classList.add('pill-default');
    } else {
        btn.classList.remove('pill-default');
        btn.classList.add('pill-selected-green');
    }

    // Update URL tombol kuisoner dengan bidang yang dipilih
    const bidangs = [...document.querySelectorAll('[data-bidang].pill-selected-green')]
        .map(b => b.dataset.bidang);
    const base = "{{ route('siswa.jurusan.kuisoner') }}";
    document.getElementById('btnKuisoner').href =
        base + (bidangs.length ? '?bidang=' + bidangs.join(',') : '');
}
</script>
@endpush
@endsection
