@extends('layouts.admin')
@section('title', 'Edit Tempat Magang')
@section('page-title', 'Edit Tempat Magang')

@section('content')
<div style="max-width:760px;">
    <div class="card-dark">
        <form method="POST" action="{{ route('admin.tempat_magang.update', $tempat->id) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="form-label-custom">Nama Tempat Magang <span style="color:#f87171">*</span></label>
                <input type="text" name="nama"
                    class="form-control form-control-dark @error('nama') is-invalid @enderror"
                    value="{{ old('nama', $tempat->nama) }}">
                @error('nama')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

                        <div class="mb-4">
                <label class="form-label-custom">Skill yang Dibutuhkan <span style="color:#f87171">*</span></label>
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

            <div class="mb-4">
                <label class="form-label-custom">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    class="form-control form-control-dark">{{ old('deskripsi', $tempat->deskripsi) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label-custom">Bidang <span style="color:#f87171">*</span></label>
                <input type="text" name="bidang"
                    class="form-control form-control-dark @error('bidang') is-invalid @enderror"
                    value="{{ old('bidang', $tempat->bidang) }}">
                @error('bidang')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            @include('admin.tempat_magang.partials.location-map', [
                'latitude' => $tempat->latitude,
                'longitude' => $tempat->longitude,
            ])

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label-custom">Kuota <span style="color:#f87171">*</span></label>
                    <input type="number" name="kuota" min="1"
                        class="form-control form-control-dark @error('kuota') is-invalid @enderror"
                        value="{{ old('kuota', $tempat->kuota) }}">
                    @error('kuota')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Kontak <span style="color:#f87171">*</span></label>
                    <input type="text" name="kontak"
                        class="form-control form-control-dark @error('kontak') is-invalid @enderror"
                        value="{{ old('kontak', $tempat->kontak) }}">
                    @error('kontak')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
            </div>

            @if(!empty($kriterias) && $kriterias->count())
            <div class="mb-4" style="background:#1e2a42;border-radius:10px;padding:16px;">
                <label class="form-label-custom mb-3">⚙️ Skor Kriteria Magang</label>
                @foreach($kriterias as $kriteria)
                <div class="mb-3">
                    <label class="form-label-custom" style="font-weight:400;">{{ $kriteria->nama }}</label>
                    <input type="number" name="skor[{{ $kriteria->id }}]" min="0" max="100" step="1"
                        value="{{ old('skor.'.$kriteria->id, $skorExisting[$kriteria->id] ?? 0) }}"
                        class="form-control form-control-dark @error('skor.'.$kriteria->id) is-invalid @enderror">
                    @error('skor.'.$kriteria->id)
                        <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                @endforeach
            </div>
            @endif

            <div class="d-flex gap-3 mt-2">
                <button type="submit" class="btn-primary-custom">💾 Update</button>
                <a href="{{ route('admin.tempat_magang.index') }}" class="btn-secondary-custom">❌ Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
