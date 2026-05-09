@extends('layouts.siswa')
@section('title', 'Pemilihan Program Studi Kuliah')
@section('content')
<h1 class="page-title">Pemilihan Program Studi Kuliah</h1>

@if(session('error'))
<div class="alert-spk alert-error">{{ session('error') }}</div>
@endif

<div class="card-main">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div class="card-title" style="margin-bottom:0;">Minat Bidang Studi</div>
        <div style="display:flex;gap:6px;">
            <div style="width:28px;height:5px;border-radius:3px;background:#4f6ef7;"></div>
            <div style="width:28px;height:5px;border-radius:3px;background:rgba(255,255,255,0.2);"></div>
            <div style="width:28px;height:5px;border-radius:3px;background:rgba(255,255,255,0.2);"></div>
        </div>
    </div>

    <form action="{{ route('siswa.jurusan.store') }}" method="POST" id="formStep">
        @csrf
        <input type="hidden" name="step" value="1">

        @php $opsi = ['Sangat Setuju','Setuju','Netral','Tidak Setuju','Sangat Tidak Setuju'];
             $vals = [5,4,3,2,1]; @endphp

        @foreach($pertanyaan as $i => $soal)
        <div style="margin-bottom:16px;">
            <div style="font-size:13px;font-weight:700;color:#fff;margin-bottom:8px;">
                {{ $i+1 }}. {{ $soal }}
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:8px;">
                @foreach($opsi as $j => $o)
                <button type="button" class="pill pill-default"
                        data-q="{{ $i }}" data-val="{{ $vals[$j] }}"
                        onclick="pilih(this,{{ $i }})">{{ $o }}</button>
                @endforeach
            </div>
            <input type="hidden" name="jawaban[{{ $i }}]" id="j{{ $i }}">
        </div>
        @endforeach

        <div style="display:flex;justify-content:flex-end;margin-top:20px;">
            <button type="submit" class="btn-primary-spk">Lanjut →</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function pilih(btn, q) {
    document.querySelectorAll(`[data-q="${q}"]`).forEach(b => {
        b.classList.remove('pill-selected-blue');
        b.classList.add('pill-default');
        b.style.border = '';
    });
    btn.classList.remove('pill-default');
    btn.classList.add('pill-selected-blue');
    btn.style.border = '';
    document.getElementById('j'+q).value = btn.dataset.val;

    // Hilangkan highlight error kalau sudah dipilih
    document.getElementById('err'+q)?.remove();
}

document.getElementById('formStep').addEventListener('submit', function(e) {
    const total = {{ count($pertanyaan) }};
    const kosong = [];

    for (let i = 0; i < total; i++) {
        const val = document.getElementById('j'+i).value;
        const existing = document.getElementById('err'+i);
        if (existing) existing.remove();

        if (!val) {
            kosong.push(i + 1);
            // Highlight tombol yang belum dipilih dengan border merah
            document.querySelectorAll(`[data-q="${i}"]`).forEach(b => {
                b.style.border = '2px solid #ef4444';
            });
            // Tambah pesan error kecil
            const errEl = document.createElement('div');
            errEl.id = 'err' + i;
            errEl.style.cssText = 'color:#fca5a5;font-size:11px;margin-top:4px;';
            errEl.textContent = '⚠ Harap pilih salah satu jawaban';
            document.getElementById('j'+i).after(errEl);
        }
    }

    if (kosong.length > 0) {
        e.preventDefault();
        // Scroll ke pertanyaan pertama yang belum dijawab
        const firstQ = kosong[0] - 1;
        document.querySelectorAll(`[data-q="${firstQ}"]`)[0]
            ?.closest('div')
            ?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script>
@endpush
@endsection
