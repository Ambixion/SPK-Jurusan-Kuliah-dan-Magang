@extends('layouts.admin')

@section('title', 'Edit Kuisoner')
@section('page-title', 'Edit Kuisoner')

@section('content')

<div style="max-width:900px;">

    <div class="card-dark">

        <form method="POST"
            action="{{ route('admin.kuisoner.update', $kuisoner->id) }}"
            id="kuisonerForm">

            @csrf
            @method('PUT')

            {{-- SOAL --}}
            <div class="mb-4">

                <label class="form-label-custom">
                    Soal <span style="color:#f87171">*</span>
                </label>

                <textarea
                    class="form-control form-control-dark @error('soal') is-invalid @enderror"
                    name="soal"
                    rows="4"
                    placeholder="Masukkan pertanyaan kuisoner..."
                    required>{{ old('soal', $kuisoner->soal) }}</textarea>

                @error('soal')
                    <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- TYPE --}}
            <div class="mb-4">

                <label class="form-label-custom">
                    Jenis <span style="color:#f87171">*</span>
                </label>

                <select
                    class="form-select form-select-dark @error('type') is-invalid @enderror"
                    name="type"
                    required>

                    <option value="">-- Pilih Jenis --</option>

                    <option value="jurusan"
                        {{ old('type', $kuisoner->type) === 'jurusan' ? 'selected' : '' }}>
                        Jurusan Kuliah
                    </option>

                    <option value="magang"
                        {{ old('type', $kuisoner->type) === 'magang' ? 'selected' : '' }}>
                        Tempat Magang
                    </option>

                </select>

                @error('type')
                    <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- OPSI --}}
            <div class="mb-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <label class="form-label-custom mb-0">
                        Opsi Jawaban
                    </label>

                    <button
                        type="button"
                        class="btn-primary-custom"
                        id="addOpsi"
                        style="padding:8px 14px;font-size:0.8rem;">

                        + Tambah Opsi

                    </button>

                </div>

                <div id="opsiContainer">

                    @foreach($kuisoner->opsi as $index => $opsi)

                        <div class="opsi-row mb-3"
                            style="
                                background:#0d1117;
                                border:1px solid #1e2a42;
                                border-radius:12px;
                                padding:16px;
                            ">

                            <div class="row g-3">

                                <div class="col-md-8">

                                    <input
                                        type="text"
                                        class="form-control form-control-dark"
                                        name="opsi[{{ $index }}][jawaban]"
                                        placeholder="Jawaban"
                                        value="{{ $opsi->jawaban }}"
                                        required>

                                </div>

                                <div class="col-md-3">

                                    <input
                                        type="number"
                                        class="form-control form-control-dark"
                                        name="opsi[{{ $index }}][nilai]"
                                        placeholder="Nilai"
                                        value="{{ $opsi->nilai }}"
                                        required>

                                </div>

                                <div class="col-md-1">

                                    <button
                                        type="button"
                                        class="btn-sm-action btn-delete remove-opsi">

                                        🗑

                                    </button>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- ACTION --}}
            <div class="d-flex gap-3 mt-2">

                <button type="submit" class="btn-primary-custom">
                    💾 Update
                </button>

                <a href="{{ route('admin.kuisoner.index') }}"
                    class="btn-secondary-custom">

                    ❌ Batal

                </a>

            </div>

        </form>

    </div>

</div>

<script>
let opsiCount = {{ $kuisoner->opsi->count() }};

document.getElementById('addOpsi').addEventListener('click', function() {
    const container = document.getElementById('opsiContainer');

    const newRow = document.createElement('div');

    newRow.className = 'opsi-row mb-3';

    newRow.style = `
        background:#0d1117;
        border:1px solid #1e2a42;
        border-radius:12px;
        padding:16px;
    `;

    newRow.innerHTML = `
        <div class="row g-3">

            <div class="col-md-8">
                <input
                    type="text"
                    class="form-control form-control-dark"
                    name="opsi[\${opsiCount}][jawaban]"
                    placeholder="Jawaban"
                    required>
            </div>

            <div class="col-md-3">
                <input
                    type="number"
                    class="form-control form-control-dark"
                    name="opsi[\${opsiCount}][nilai]"
                    placeholder="Nilai"
                    value="0"
                    required>
            </div>

            <div class="col-md-1">
                <button
                    type="button"
                    class="btn-sm-action btn-delete remove-opsi">

                    🗑

                </button>
            </div>

        </div>
    `;

    container.appendChild(newRow);

    opsiCount++;

    newRow.querySelector('.remove-opsi').addEventListener('click', function() {
        newRow.remove();
    });
});

document.querySelectorAll('.remove-opsi').forEach(btn => {
    btn.addEventListener('click', function() {
        this.closest('.opsi-row').remove();
    });
});
</script>

@endsection
