@extends('layouts.admin')

@section('title', 'Edit Jurusan Kuliah')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card-dark">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.jurusan_kuliah.update', $jurusan->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label-custom">Nama Jurusan <span style="color:#f87171">*</span></label>
                        <input type="text" name="nama" class="form-control form-control-dark @error('nama') is-invalid @enderror" value="{{ old('nama', $jurusan->nama) }}">
                        @error('nama')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Bidang Studi <span style="color:#f87171">*</span></label>
                        <input type="text" name="bidang_studi" class="form-control form-control-dark @error('bidang_studi') is-invalid @enderror" value="{{ old('bidang_studi', $jurusan->bidang_studi) }}">
                        @error('bidang_studi')<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-control form-control-dark">{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>
                    </div>

                    @if(!empty($kriterias))
                        <div class="card p-3 mb-3" style="background:#1e2a42;border-radius:10px;">
                            <h6 class="mb-3" style="color:#e2e8f0;">Skor Kriteria</h6>
                            @foreach($kriterias as $kriteria)
                                <div class="mb-2">
                                    <label class="form-label-custom" style="font-weight:400;">{{ $kriteria->nama }}</label>
                                    <input type="number" name="skor[{{ $kriteria->id }}]" min="0" max="100" step="1" value="{{ old('skor.'.$kriteria->id, $skorExisting[$kriteria->id] ?? 0) }}" class="form-control form-control-dark @error('skor.'.$kriteria->id) is-invalid @enderror">
                                    @error('skor.'.$kriteria->id)<div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
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
    </div>
</div>
@endsection
