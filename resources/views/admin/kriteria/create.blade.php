@extends('layouts.admin')
@section('title', 'Tambah Kriteria')
@section('page-title', 'Tambah Kriteria')

@section('content')
<div style="max-width:520px;">
    <div class="card-dark">
        <form method="POST" action="{{ route('admin.kriteria.store') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label-custom">Nama Kriteria <span style="color:#f87171">*</span></label>
                <input type="text" name="nama"
                    class="form-control form-control-dark @error('nama') is-invalid @enderror"
                    value="{{ old('nama') }}" placeholder="Contoh: Nilai Akademik, Jarak, dll">
                @error('nama')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label-custom">Bobot <span style="color:#f87171">*</span> <span style="color:#8892a4;font-size:0.75rem;">(0–1, total per jenis = 1)</span></label>
                <input type="number" name="weight" step="0.001" min="0" max="1"
                    class="form-control form-control-dark @error('weight') is-invalid @enderror"
                    value="{{ old('weight') }}" placeholder="Contoh: 0.3">
                @error('weight')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label-custom">Tipe <span style="color:#f87171">*</span></label>
                <select name="type" class="form-select form-select-dark @error('type') is-invalid @enderror">
                    <option value="">-- Pilih Tipe --</option>
                    <option value="benefit" {{ old('type')=='benefit'?'selected':'' }}>Benefit (semakin besar semakin baik)</option>
                    <option value="cost"    {{ old('type')=='cost'?'selected':'' }}>Cost (semakin kecil semakin baik)</option>
                </select>
                @error('type')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label-custom">Jenis <span style="color:#f87171">*</span></label>
                <select name="jenis" class="form-select form-select-dark @error('jenis') is-invalid @enderror">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="jurusan" {{ old('jenis')=='jurusan'?'selected':'' }}>Jurusan Kuliah</option>
                    <option value="magang"  {{ old('jenis')=='magang'?'selected':'' }}>Tempat Magang</option>
                </select>
                @error('jenis')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-3 mt-2">
                <button type="submit" class="btn-primary-custom">💾 Simpan</button>
                <a href="{{ route('admin.kriteria.index') }}" class="btn-secondary-custom">❌ Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
