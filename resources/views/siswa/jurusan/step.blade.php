@extends('layouts.siswa')
@section('title', 'Kuisoner Jurusan — Step {{ $step }}')
@section('content')
<h1 class="page-title">Pemilihan Program Studi Kuliah</h1>

@if(session('error'))
<div class="alert-spk alert-error">{{ session('error') }}</div>
@endif

<div class="card-main">
    {{-- Header + progress --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <div>
            <div class="card-title" style="margin-bottom:2px;">Kuisoner Jurusan Kuliah</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.4);">
                Step {{ $step }} dari {{ $totalStep }}
                &nbsp;·&nbsp;
                {{ $stepData->count() }} pertanyaan
            </div>
        </div>
        <div style="display:flex;gap:6px;">
            @for($i = 1; $i <= $totalStep; $i++)
            <div style="width:28px;height:5px;border-radius:3px;
                        background:{{ $i < $step ? '#22c55e' : ($i === $step ? '#4f6ef7' : 'rgba(255,255,255,0.2)') }};
                        transition:background 0.3s;">
            </div>
            @endfor
        </div>
    </div>

    <form action="{{ route('siswa.jurusan.store') }}" method="POST" id="formJurusanStep">
        @csrf
        <input type="hidden" name="step" value="{{ $step }}">
        <input type="hidden" name="total_step" value="{{ $totalStep }}">

        @php $ctx = session('jurusan_step_context', []); @endphp
        @if(!empty($ctx['jurusan_kuliah_id']))
        <input type="hidden" name="jurusan_kuliah_id" value="{{ $ctx['jurusan_kuliah_id'] }}">
        @endif
        @if(!empty($ctx['bidang_ids']))
        <input type="hidden" name="bidang_ids" value="{{ $ctx['bidang_ids'] }}">
        @endif

        @foreach($stepData as $soal)
        <div class="soal-item" style="margin-bottom:22px;padding-bottom:22px;
                    border-bottom:1px solid rgba(255,255,255,0.06);"
             id="soal-wrap-{{ $soal->id }}">

            <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:10px;">
                <span style="font-size:13px;font-weight:700;color:#818cf8;min-width:24px;">
                    {{ $loop->iteration }}.
                </span>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#fff;line-height:1.5;">
                        {{ $soal->soal }}
                    </div>
                    <div style="display:flex;gap:6px;margin-top:5px;flex-wrap:wrap;">
                        @if($soal->jurusanKuliah)
                        <span style="font-size:10px;background:rgba(139,92,246,0.2);
                                     color:#c4b5fd;padding:2px 8px;border-radius:20px;
                                     border:1px solid rgba(139,92,246,0.3);">
                            🎓 {{ $soal->jurusanKuliah->nama }}
                        </span>
                        @endif
                        @if($soal->bidang)
                        <span style="font-size:10px;background:rgba(34,197,94,0.15);
                                     color:#86efac;padding:2px 8px;border-radius:20px;
                                     border:1px solid rgba(34,197,94,0.2);">
                            📂 {{ $soal->bidang->nama }}
                        </span>
                        @endif
                        @if($soal->kriteria)
                        <span style="font-size:10px;background:rgba(251,191,36,0.12);
                                     color:#fbbf24;padding:2px 8px;border-radius:20px;
                                     border:1px solid rgba(251,191,36,0.2);">
                            📊 {{ $soal->kriteria->nama }}
                        </span>
                        @endif
                        @if(!$soal->jurusan_kuliah_id && !$soal->bidang_id)
                        <span style="font-size:10px;background:rgba(148,163,184,0.12);
                                     color:rgba(255,255,255,0.4);padding:2px 8px;border-radius:20px;
                                     border:1px solid rgba(255,255,255,0.1);">
                            🌐 Umum
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <div style="display:flex;flex-wrap:wrap;gap:8px;padding-left:34px;">
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

            <input type="hidden" name="jawaban[{{ $soal->id }}]" id="j{{ $soal->id }}" value="">
            <input type="hidden" name="soal_ids[]" value="{{ $soal->id }}">
        </div>
        @endforeach

        <div style="display:flex;justify-content:space-between;margin-top:24px;">
            @if($step > 1)
            <a href="{{ route('siswa.jurusan.kuisoner', array_merge(session('jurusan_step_context', []), ['step' => $step - 1])) }}"
               style="background:rgba(255,255,255,0.08);color:#fff;padding:11px 26px;
                      border-radius:50px;font-size:13px;font-weight:700;
                      text-decoration:none;border:1px solid rgba(255,255,255,0.15);">
                ← Kembali
            </a>
            @else
            <a href="{{ route('siswa.jurusan') }}"
               style="background:rgba(255,255,255,0.08);color:#fff;padding:11px 26px;
                      border-radius:50px;font-size:13px;font-weight:700;
                      text-decoration:none;border:1px solid rgba(255,255,255,0.15);">
                ← Kembali
            </a>
            @endif

            <button type="submit" class="btn-primary-spk">
                @if($step === $totalStep) Selesai & Lihat Hasil → @else Lanjut → @endif
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function pilih(btn, soalId) {
    document.querySelectorAll(`[data-q="${soalId}"]`).forEach(b => {
        b.classList.remove('pill-selected-blue');
        b.classList.add('pill-default');
        b.style.border = '';
    });
    btn.classList.remove('pill-default');
    btn.classList.add('pill-selected-blue');
    document.getElementById('j' + soalId).value = btn.dataset.opsiId;

    document.getElementById('soal-wrap-' + soalId).style.borderLeft = '';
    document.getElementById('err' + soalId)?.remove();
}

document.getElementById('formJurusanStep').addEventListener('submit', function(e) {
    const soalIds = [...document.querySelectorAll('[name="soal_ids[]"]')].map(el => el.value);
    let valid = true, firstError = null;

    soalIds.forEach(id => {
        const val  = document.getElementById('j' + id)?.value;
        const wrap = document.getElementById('soal-wrap-' + id);
        document.getElementById('err' + id)?.remove();

        if (!val) {
            valid = false;
            if (!firstError) firstError = wrap;
            if (wrap) wrap.style.borderLeft = '3px solid #ef4444';
            document.querySelectorAll(`[data-q="${id}"]`).forEach(b => b.style.border = '2px solid #ef4444');

            const errEl = document.createElement('p');
            errEl.id = 'err' + id;
            errEl.style.cssText = 'color:#fca5a5;font-size:11px;margin:4px 0 0 34px;';
            errEl.textContent = '⚠ Harap pilih salah satu jawaban';
            document.getElementById('j' + id)?.after(errEl);
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
