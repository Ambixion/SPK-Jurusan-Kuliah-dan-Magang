@extends('layouts.admin')
@section('title', 'Edit Jurusan SMK')
@section('page-title', 'Manajemen Jurusan')

@section('content')
{{-- SUBNAV --}}
<div style="display:flex;gap:8px;margin-bottom:24px;border-bottom:1px solid #1e2a42;">
    <a href="{{ route('admin.jurusan_kuliah.index') }}"
       style="padding:10px 20px;border-radius:10px 10px 0 0;font-weight:600;font-size:0.875rem;text-decoration:none;background:#1e2a42;color:#a0aec0;">
        🎓 Jurusan Kuliah
    </a>
    <a href="{{ route('admin.jurusan_smk.index') }}"
       style="padding:10px 20px;border-radius:10px 10px 0 0;font-weight:600;font-size:0.875rem;text-decoration:none;background:linear-gradient(135deg,#5b6af0,#7c3aed);color:#fff;">
        🏫 Jurusan SMK
    </a>
</div>

<div style="max-width:560px;">
    <div class="card-dark">
        <form method="POST" action="{{ route('admin.jurusan_smk.update', $jurusan->id) }}">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="form-label-custom">Nama Jurusan SMK <span style="color:#f87171">*</span></label>
                <input type="text" name="nama_jurusan"
                    class="form-control form-control-dark @error('nama_jurusan') is-invalid @enderror"
                    value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}">
                @error('nama_jurusan')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

                        <div class="mb-4">
                <label class="form-label-custom">Skill Terkait <span style="color:#f87171">*</span></label>
                @error('skill_ids')<div style="color:#f87171;font-size:0.8rem;margin-bottom:8px;">{{ $message }}</div>@enderror
                <div style="background:#0d1117;border:1px solid #1e2a42;border-radius:10px;padding:14px;display:flex;flex-wrap:wrap;gap:10px;">
                    @foreach($skills as $skill)
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;background:#161d2f;border:1px solid #1e2a42;border-radius:8px;padding:8px 14px;transition:border-color 0.2s;">
                        <input type="checkbox" name="skill_ids[]" value="{{ $skill->id }}"
                            {{ in_array($skill->id, old('skill_ids', $selectedSkills)) ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#5b6af0;cursor:pointer;">
                        <span style="font-size:0.875rem;color:#e2e8f0;">{{ $skill->jenis_skill }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="d-flex gap-3 mt-2">
                <button type="submit" class="btn-primary-custom">💾 Update</button>
                <a href="{{ route('admin.jurusan_smk.index') }}" class="btn-secondary-custom">❌ Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
