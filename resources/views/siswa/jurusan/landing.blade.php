@extends('layouts.siswa')
@section('title', 'Pemilihan Program Studi Kuliah')
@section('content')
<h1 class="page-title">Pemilihan Program Studi Kuliah</h1>

@if(session('success'))
<div class="alert-spk alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert-spk alert-error">{{ session('error') }}</div>
@endif

<div class="card-main">
    <div class="card-title">Data Diri Siswa</div>

    <div class="form-group">
        <label class="form-label">Nama Siswa</label>
        <input type="text" class="form-input" value="{{ Auth::user()->nama }}" readonly>
    </div>
    <div class="form-group">
        <label class="form-label">Jurusan, Kelas, dan Semester</label>
        <input type="text" class="form-input"
               value="{{ $siswa->jurusan_siswa }}, Kelas {{ $siswa->kelas }}, Semester {{ $siswa->semester }}"
               readonly>
    </div>
    <div class="form-group">
        <label class="form-label">Nilai Rata-rata Rapot</label>
        <input type="text" class="form-input" value="{{ $nilaiRata }}" readonly>
    </div>

    {{-- Tujuan Setelah Lulus --}}
    <div class="form-group">
        <label class="form-label">Tujuan Setelah Lulus</label>
        <div class="pills-group" id="tujuanGroup">
            <button type="button" class="pill pill-default" data-val="Kuliah" onclick="pilihTujuan(this)">
                🎓 Kuliah
            </button>
            <button type="button" class="pill pill-default" data-val="Kerja" onclick="pilihTujuan(this)">
                💼 Langsung Kerja
            </button>
        </div>
    </div>

    {{-- ── PANEL KULIAH ─────────────────────────────────────────────────── --}}
    <div id="panelKuliah" style="display:none;">

        {{-- Step 1: Pilih Jurusan Kuliah yang diminati dari DB --}}
        <div class="form-group">
            <label class="form-label">
                Jurusan Kuliah yang Diminati
                <span style="font-size:11px;color:rgba(255,255,255,0.4);font-weight:400;margin-left:6px;">
                    (opsional)
                </span>
            </label>
            @if($jurusanList->isEmpty())
            <p style="color:rgba(255,255,255,0.4);font-size:12px;">
                Belum ada jurusan kuliah. Hubungi admin.
            </p>
            @else
            <div class="pills-group" id="jurusanGroup">
                @foreach($jurusanList as $jk)
                <button type="button"
                        class="pill pill-default"
                        data-jurusan-id="{{ $jk->id }}"
                        data-bidang-ids="{{ $jk->bidangs->pluck('id')->implode(',') }}"
                        onclick="pilihJurusan(this)">
                    {{ $jk->nama }}
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Step 2: Bidang dari DB — muncul setelah pilih jurusan atau tampil semua --}}
        <div class="form-group">
            <label class="form-label">
                Bidang yang Ingin Dieksplorasi
                <span style="font-size:11px;color:rgba(255,255,255,0.4);font-weight:400;margin-left:6px;">
                    (otomatis dari jurusan pilihan)
                </span>
            </label>
            @if($bidangs->isEmpty())
            <p style="color:rgba(255,255,255,0.4);font-size:12px;">
                Belum ada bidang. Hubungi admin.
            </p>
            @else
            <div class="pills-group" id="bidangGroup">
                @foreach($bidangs as $bidang)
                <button type="button"
                        class="pill pill-default"
                        data-bidang-id="{{ $bidang->id }}"
                        onclick="toggleBidang(this)"
                        style="display:inline-flex;">
                    {{ $bidang->nama }}
                </button>
                @endforeach
            </div>
            <p id="infoBidang" style="font-size:11px;color:rgba(255,255,255,0.4);margin-top:6px;display:block;">
                Klik bidang untuk aktifkan/nonaktifkan.
            </p>
            @endif
        </div>

        {{-- Info sudah mengisi --}}
        @if($sudahMengisi)
        <div style="display:flex;justify-content:space-between;align-items:center;
                    padding:14px 18px;background:rgba(34,197,94,0.1);
                    border:1px solid rgba(34,197,94,0.25);border-radius:12px;margin-bottom:14px;">
            <div>
                <div style="font-size:13px;font-weight:700;color:#86efac;">✅ Sudah mengisi kuisoner</div>
                <div style="font-size:11px;color:rgba(255,255,255,0.55);margin-top:3px;">
                    Lihat hasil atau isi ulang.
                </div>
            </div>
            <a href="{{ route('siswa.jurusan.hasil') }}"
               style="background:#22c55e;color:#fff;padding:8px 18px;border-radius:20px;
                      font-size:12px;font-weight:700;text-decoration:none;">
                Lihat Hasil →
            </a>
        </div>
        @endif

        <div style="display:flex;justify-content:flex-end;margin-top:20px;">
            <a id="btnKuisoner" href="{{ route('siswa.jurusan.kuisoner') }}" class="btn-primary-spk">
                Lanjut ke Kuisoner →
            </a>
        </div>
    </div>

    {{-- ── PANEL LANGSUNG KERJA ─────────────────────────────────────────── --}}
    <div id="panelKerja" style="display:none;margin-top:20px;">
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
const baseUrl   = "{{ route('siswa.jurusan.kuisoner') }}";
let selectedJurusanId = null;

function pilihTujuan(btn) {
    document.querySelectorAll('#tujuanGroup .pill').forEach(b => {
        b.classList.remove('pill-selected-blue');
        b.classList.add('pill-default');
    });
    btn.classList.remove('pill-default');
    btn.classList.add('pill-selected-blue');

    const val = btn.dataset.val;
    document.getElementById('panelKuliah').style.display = val === 'Kuliah' ? 'block' : 'none';
    document.getElementById('panelKerja').style.display  = val === 'Kerja'  ? 'block' : 'none';
}

function pilihJurusan(btn) {
    // Toggle: klik lagi untuk deselect
    const isSelected = btn.classList.contains('pill-selected-blue');

    document.querySelectorAll('#jurusanGroup .pill').forEach(b => {
        b.classList.remove('pill-selected-blue');
        b.classList.add('pill-default');
    });

    if (!isSelected) {
        btn.classList.remove('pill-default');
        btn.classList.add('pill-selected-blue');
        selectedJurusanId = btn.dataset.jurusanId;

        // Highlight bidang yang relevan dengan jurusan ini
        const bidangIds = btn.dataset.bidangIds
            ? btn.dataset.bidangIds.split(',').filter(Boolean)
            : [];
        highlightBidang(bidangIds);
    } else {
        selectedJurusanId = null;
        highlightBidang([]); // Tampilkan semua bidang tanpa highlight
    }

    updateUrl();
}

function highlightBidang(bidangIds) {
    const pills = document.querySelectorAll('#bidangGroup [data-bidang-id]');
    const info  = document.getElementById('infoBidang');

    pills.forEach(btn => {
        btn.style.display = 'inline-flex';
        if (bidangIds.length > 0 && bidangIds.includes(btn.dataset.bidangId)) {
            btn.classList.add('pill-selected-green');
            btn.classList.remove('pill-default');
        } else {
            btn.classList.remove('pill-selected-green');
            btn.classList.add('pill-default');
        }
    });

    if (info) info.style.display = 'block';
    updateUrl();
}

function toggleBidang(btn) {
    btn.classList.toggle('pill-selected-green');
    btn.classList.toggle('pill-default', !btn.classList.contains('pill-selected-green'));
    updateUrl();
}

function updateUrl() {
    const params = new URLSearchParams();

    if (selectedJurusanId) params.set('jurusan_kuliah_id', selectedJurusanId);

    const bidangIds = [...document.querySelectorAll('#bidangGroup [data-bidang-id].pill-selected-green')]
        .map(b => b.dataset.bidangId);
    if (bidangIds.length) params.set('bidang_ids', bidangIds.join(','));

    const btn = document.getElementById('btnKuisoner');
    if (btn) btn.href = baseUrl + (params.toString() ? '?' + params.toString() : '');
}
</script>
@endpush
@endsection
