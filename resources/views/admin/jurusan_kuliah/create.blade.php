@extends('layouts.admin')
@section('title', 'Tambah Jurusan Kuliah')
@section('page-title', 'Tambah Jurusan Kuliah')

@section('content')
{{-- SUBNAV --}}
<div style="display:flex;gap:8px;margin-bottom:24px;border-bottom:1px solid #1e2a42;padding-bottom:0;">
    <a href="{{ route('admin.jurusan_kuliah.index') }}"
       style="padding:10px 20px;border-radius:10px 10px 0 0;font-weight:600;font-size:0.875rem;text-decoration:none;background:linear-gradient(135deg,#5b6af0,#7c3aed);color:#fff;">
        🎓 Jurusan Kuliah
    </a>
    <a href="{{ route('admin.jurusan_smk.index') }}"
       style="padding:10px 20px;border-radius:10px 10px 0 0;font-weight:600;font-size:0.875rem;text-decoration:none;background:#1e2a42;color:#a0aec0;">
        🏫 Jurusan SMK
    </a>
</div>
<div style="max-width:620px;">
    <div class="card-dark">
        <form method="POST" action="{{ route('admin.jurusan_kuliah.store') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label-custom">Nama Jurusan <span style="color:#f87171">*</span></label>
                <input type="text" name="nama" class="form-control form-control-dark @error('nama') is-invalid @enderror"
                    value="{{ old('nama') }}" placeholder="Contoh: Teknik Informatika">
                @error('nama')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label-custom">Bidang Studi <span style="color:#f87171">*</span></label>
                <input type="text" name="bidang_studi" class="form-control form-control-dark @error('bidang_studi') is-invalid @enderror"
                    value="{{ old('bidang_studi') }}" placeholder="Contoh: Teknologi, Sains">
                @error('bidang_studi')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label-custom">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="form-control form-control-dark">{{ old('deskripsi') }}</textarea>
            </div>
            @if(!empty($kriterias) && $kriterias->count())
            <div class="mb-4" style="background:#1e2a42;border-radius:10px;padding:16px;">
                <label class="form-label-custom mb-3">⚙️ Skor Kriteria</label>
                @foreach($kriterias as $kriteria)
                <div class="mb-3">
                    <label class="form-label-custom" style="font-weight:400;">{{ $kriteria->nama }}</label>
                    <input type="number" name="skor[{{ $kriteria->id }}]" min="0" max="100" step="1" value="{{ old('skor.'.$kriteria->id, 0) }}"
                        class="form-control form-control-dark @error('skor.'.$kriteria->id) is-invalid @enderror">
                    @error('skor.'.$kriteria->id)
                        <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                @endforeach
            </div>
            @endif
            <div class="d-flex gap-3 mt-2">
                <button type="submit" class="btn-primary-custom">💾 Simpan</button>
                <a href="{{ route('admin.jurusan_kuliah.index') }}" class="btn-secondary-custom">❌ Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
