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

    {{-- Data Siswa readonly --}}
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

    {{-- Skill dari jurusan SMK siswa — OTOMATIS dari DB, tidak hardcode --}}
    <div class="form-group">
        <label class="form-label">
            Skill yang Kamu Miliki
            @if($jurusanSmk)
            <span style="font-size:11px;color:rgba(255,255,255,0.45);font-weight:400;margin-left:6px;">
                (dari jurusan {{ $jurusanSmk->nama_jurusan }})
            </span>
            @endif
        </label>

        @if($skillJurusan->isEmpty())
        <div style="color:rgba(255,255,255,0.4);font-size:12px;padding:10px 0;">
            Belum ada skill terdaftar untuk jurusan ini.
            <a href="#" style="color:#818cf8;">Hubungi admin.</a>
        </div>
        @else
        <div class="pills-group" id="skillGroup">
            @foreach($skillJurusan as $skill)
            <button type="button"
                    class="pill pill-selected-green"  {{-- default: semua skill jurusan aktif --}}
                    data-skill-id="{{ $skill->id }}"
                    onclick="toggleSkill(this)">
                {{ $skill->jenis_skill }}
            </button>
            @endforeach
        </div>
        <p style="font-size:11px;color:rgba(255,255,255,0.4);margin-top:6px;">
            Klik untuk aktifkan/nonaktifkan skill. Soal kuisoner akan disesuaikan.
        </p>
        @endif
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

function toggleSkill(btn) {
    btn.classList.toggle('pill-selected-green');
    btn.classList.toggle('pill-default', !btn.classList.contains('pill-selected-green'));
    updateUrl();
}

function updateUrl() {
    const skillIds = [...document.querySelectorAll('#skillGroup [data-skill-id].pill-selected-green')]
        .map(b => b.dataset.skillId);

    const params = new URLSearchParams();
    if (skillIds.length) params.set('skill_ids', skillIds.join(','));

    document.getElementById('btnKuisionerPkl').href =
        baseUrl + (params.toString() ? '?' + params.toString() : '');
}

// Init URL dengan semua skill yang aktif saat load
updateUrl();
</script>
@endpush
@endsection
