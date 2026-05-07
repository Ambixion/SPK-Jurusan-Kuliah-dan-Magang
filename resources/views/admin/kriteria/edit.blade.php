@extends('layouts.admin')
@section('title', 'Edit Kriteria')
@section('page-title', 'Edit Kriteria')

@section('content')
<div style="max-width:520px;">
    <div class="card-dark">
        <form method="POST" action="{{ route('admin.kriteria.update', $kriteria->id) }}">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="form-label-custom">Nama Kriteria <span style="color:#f87171">*</span></label>
                <input type="text" name="nama"
                    class="form-control form-control-dark @error('nama') is-invalid @enderror"
                    value="{{ old('nama', $kriteria->nama) }}">
                @error('nama')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label-custom">Bobot <span style="color:#f87171">*</span></label>
                <input type="number" name="weight" step="0.001" min="0" max="1"
                    class="form-control form-control-dark @error('weight') is-invalid @enderror"
                    value="{{ old('weight', $kriteria->weight) }}">
                @error('weight')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label-custom">Tipe <span style="color:#f87171">*</span></label>
                <select name="type" class="form-select form-select-dark @error('type') is-invalid @enderror">
                    <option value="benefit" {{ old('type',$kriteria->type)=='benefit'?'selected':'' }}>Benefit</option>
                    <option value="cost"    {{ old('type',$kriteria->type)=='cost'?'selected':'' }}>Cost</option>
                </select>
                @error('type')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label-custom">Jenis <span style="color:#f87171">*</span></label>
                <select name="jenis" class="form-select form-select-dark @error('jenis') is-invalid @enderror">
                    <option value="jurusan" {{ old('jenis',$kriteria->jenis)=='jurusan'?'selected':'' }}>Jurusan Kuliah</option>
                    <option value="magang"  {{ old('jenis',$kriteria->jenis)=='magang'?'selected':'' }}>Tempat Magang</option>
                </select>
                @error('jenis')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-3 mt-2">
                <button type="submit" class="btn-primary-custom">💾 Update</button>
                <a href="{{ route('admin.kriteria.index') }}" class="btn-secondary-custom">❌ Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
