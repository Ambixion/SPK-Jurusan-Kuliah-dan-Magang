@extends('layouts.siswa')
@section('title', 'Pemilihan Tempat PKL')
@section('content')
<h1 class="page-title">Pemilihan Tempat Praktek Kerja Lapangan</h1>

@if(session('error'))
<div class="alert-spk alert-error">{{ session('error') }}</div>
@endif

<div class="card-main">
    {{-- Header dengan progress indicator --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div class="card-title" style="margin-bottom:0;">
            Kuisoner PKL
            <span style="font-size:12px;font-weight:400;color:rgba(255,255,255,0.5);margin-left:8px;">
                Step {{ $step }} dari {{ $totalStep }}
            </span>
        </div>
        {{-- Progress dots --}}
        <div style="display:flex;gap:6px;">
            @for($i = 1; $i <= $totalStep; $i++)
            <div style="width:28px;height:5px;border-radius:3px;
                        background:{{ $i === $step ? '#4f6ef7' : 'rgba(255,255,255,0.2)' }};
                        transition:background 0.3s;">
            </div>
            @endfor
        </div>
    </div>

    <form action="{{ route('siswa.pkl.store') }}" method="POST" id="formPklStep">
        @csrf
        <input type="hidden" name="step" value="{{ $step }}">
        <input type="hidden" name="total_step" value="{{ $totalStep }}">

        {{-- Kirim context (bidang_ids) agar bisa redirect ke step berikutnya dengan benar --}}
        @foreach(session('pkl_step_context.bidang_ids', []) as $bid)
        <input type="hidden" name="bidang_ids[]" value="{{ $bid }}">
        @endforeach

        {{-- Daftar soal untuk step ini --}}
        @foreach($stepData as $soal)
        <div class="soal-item" style="margin-bottom:20px;" id="soal-wrap-{{ $soal->id }}">
            <div style="font-size:13px;font-weight:700;color:#fff;margin-bottom:10px;">
                {{ $loop->iteration }}. {{ $soal->soal }}
                @if($soal->bidang)
                <span style="font-size:10px;color:rgba(255,255,255,0.4);margin-left:6px;">
                    [{{ $soal->bidang->nama }}]
                </span>
                @endif
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:8px;">
                @foreach($soal->opsi->sortByDesc('nilai') as $opsi)
                <button type="button"
                        class="pill pill-default"
                        data-q="{{ $soal->id }}"
                        data-opsi-id="{{ $opsi->id }}"
                        onclick="pilih(this, {{ $soal->id }})">
                    {{ $opsi->jawaban }}
                </button>
                @endforeach
            </div>
            {{-- Hidden input: key = kuisoner_id, value = opsi_id yang dipilih --}}
            <input type="hidden"
                   name="jawaban[{{ $soal->id }}]"
                   id="j{{ $soal->id }}"
                   value="">
            {{-- soal_ids untuk validasi server-side --}}
            <input type="hidden" name="soal_ids[]" value="{{ $soal->id }}">
        </div>
        @endforeach

        <div style="display:flex;justify-content:space-between;margin-top:24px;">
            @if($step > 1)
            {{-- Kembali ke step sebelumnya dengan context bidang_ids --}}
            <a href="{{ route('siswa.pkl.kuisoner', array_merge(session('pkl_step_context', []), ['step' => $step - 1])) }}"
               style="background:rgba(255,255,255,0.1);color:#fff;padding:11px 26px;
                      border-radius:50px;font-size:13px;font-weight:700;
                      text-decoration:none;border:1px solid rgba(255,255,255,0.2);">
                ← Kembali
            </a>
            @else
            <a href="{{ route('siswa.pkl') }}"
               style="background:rgba(255,255,255,0.1);color:#fff;padding:11px 26px;
                      border-radius:50px;font-size:13px;font-weight:700;
                      text-decoration:none;border:1px solid rgba(255,255,255,0.2);">
                ← Kembali
            </a>
            @endif

            <button type="submit" class="btn-primary-spk">
                @if($step === $totalStep)
                    Selesai & Lihat Hasil →
                @else
                    Lanjut →
                @endif
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function pilih(btn, soalId) {
    // Reset semua tombol di soal ini
    document.querySelectorAll(`[data-q="${soalId}"]`).forEach(b => {
        b.classList.remove('pill-selected-blue');
        b.classList.add('pill-default');
        b.style.border = '';
    });

    // Aktifkan tombol yang diklik
    btn.classList.remove('pill-default');
    btn.classList.add('pill-selected-blue');

    // Simpan opsi_id ke hidden input
    document.getElementById('j' + soalId).value = btn.dataset.opsiId;

    // Hapus highlight error jika ada
    const errEl = document.getElementById('err' + soalId);
    if (errEl) errEl.remove();
    const wrap = document.getElementById('soal-wrap-' + soalId);
    if (wrap) wrap.style.borderLeft = '';
}

document.getElementById('formPklStep').addEventListener('submit', function(e) {
    const soalIds = [...document.querySelectorAll('[name="soal_ids[]"]')]
        .map(el => el.value);

    let valid = true;
    let firstError = null;

    soalIds.forEach(soalId => {
        const val = document.getElementById('j' + soalId)?.value;
        const wrap = document.getElementById('soal-wrap-' + soalId);
        const existing = document.getElementById('err' + soalId);
        if (existing) existing.remove();

        if (!val) {
            valid = false;
            if (!firstError) firstError = wrap;

            // Highlight soal yang belum dijawab
            if (wrap) wrap.style.borderLeft = '3px solid #ef4444';

            document.querySelectorAll(`[data-q="${soalId}"]`).forEach(b => {
                b.style.border = '2px solid #ef4444';
            });

            const errEl = document.createElement('div');
            errEl.id = 'err' + soalId;
            errEl.style.cssText = 'color:#fca5a5;font-size:11px;margin-top:4px;';
            errEl.textContent = '⚠ Harap pilih salah satu jawaban';
            document.getElementById('j' + soalId)?.after(errEl);
        }
    });

    if (!valid) {
        e.preventDefault();
        firstError?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script>
@endpush
@endsection
