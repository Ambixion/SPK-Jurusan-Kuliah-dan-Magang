@extends('layouts.admin')

@section('title', 'Tambah Kuisoner')
@section('page-title', 'Tambah Kuisoner')

@section('content')

<div style="max-width:900px;">

    <div class="card-dark">

        <form method="POST"
            action="{{ route('admin.kuisoner.store') }}"
            id="kuisonerForm">

            @csrf

            {{-- SOAL --}}
            <div class="mb-4">

                <label class="form-label-custom">
                    Soal <span style="color:#f87171">*</span>
                </label>

                <textarea
                    name="soal"
                    rows="4"
                    placeholder="Masukkan pertanyaan kuisoner..."
                    class="form-control form-control-dark @error('soal') is-invalid @enderror"
                    required>{{ old('soal') }}</textarea>

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
                    name="type"
                    class="form-select form-select-dark @error('type') is-invalid @enderror"
                    required>

                    <option value="">-- Pilih Jenis --</option>

                    <option value="jurusan"
                        {{ old('type') === 'jurusan' ? 'selected' : '' }}>
                        Jurusan Kuliah
                    </option>

                    <option value="magang"
                        {{ old('type') === 'magang' ? 'selected' : '' }}>
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
                        id="addOpsi"
                        class="btn-primary-custom"
                        style="padding:8px 14px;font-size:0.8rem;">

                        + Tambah Opsi

                    </button>

                </div>

                <div id="opsiContainer">

                    <div class="opsi-row"
                        style="
                            background:#0d1117;
                            border:1px solid #1e2a42;
                            border-radius:12px;
                            padding:16px;
                            margin-bottom:14px;
                        ">

                        <div class="row g-3">

                            <div class="col-md-7">

                                <label class="form-label-custom">
                                    Jawaban
                                </label>

                                <input
                                    type="text"
                                    class="form-control form-control-dark"
                                    name="opsi[0][jawaban]"
                                    placeholder="Contoh: Sangat Tertarik"
                                    required>

                            </div>

                            <div class="col-md-3">

                                <label class="form-label-custom">
                                    Nilai
                                </label>

                                <input
                                    type="number"
                                    class="form-control form-control-dark"
                                    name="opsi[0][nilai]"
                                    value="0"
                                    required>

                            </div>

                            <div class="col-md-2 d-flex align-items-end">

                                <button
                                    type="button"
                                    class="btn-sm-action btn-delete remove-opsi w-100">

                                    🗑 Hapus

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ACTION --}}
            <div class="d-flex gap-3 mt-2">

                <button type="submit" class="btn-primary-custom">
                    💾 Simpan
                </button>

                <a href="{{ route('admin.kuisoner.index') }}"
                    class="btn-secondary-custom">

                    ❌ Batal

                </a>

            </div>

        </form>

    </div>

</div>

@push('scripts')
<script>

let opsiCount = 1;

document.getElementById('addOpsi').addEventListener('click', function () {

    const container = document.getElementById('opsiContainer');

    const newRow = document.createElement('div');

    newRow.className = 'opsi-row';

    newRow.style = `
        background:#0d1117;
        border:1px solid #1e2a42;
        border-radius:12px;
        padding:16px;
        margin-bottom:14px;
    `;

    newRow.innerHTML = `

        <div class="row g-3">

            <div class="col-md-7">

                <label class="form-label-custom">
                    Jawaban
                </label>

                <input
                    type="text"
                    class="form-control form-control-dark"
                    name="opsi[${opsiCount}][jawaban]"
                    placeholder="Contoh: Sangat Tertarik"
                    required>

            </div>

            <div class="col-md-3">

                <label class="form-label-custom">
                    Nilai
                </label>

                <input
                    type="number"
                    class="form-control form-control-dark"
                    name="opsi[${opsiCount}][nilai]"
                    value="0"
                    required>

            </div>

            <div class="col-md-2 d-flex align-items-end">

                <button
                    type="button"
                    class="btn-sm-action btn-delete remove-opsi w-100">

                    🗑 Hapus

                </button>

            </div>

        </div>
    `;

    container.appendChild(newRow);

    opsiCount++;

    attachRemoveEvent();
});

function attachRemoveEvent() {

    document.querySelectorAll('.remove-opsi').forEach(btn => {

        btn.onclick = function () {

            const allRows = document.querySelectorAll('.opsi-row');

            if (allRows.length > 1) {
                this.closest('.opsi-row').remove();
            }

        };

    });

}

attachRemoveEvent();

</script>
@endpush

@endsection
