@extends('layouts.admin')

@section('title', 'Edit Skill')

@section('content')
<div class="mb-4">
    <h3>🛠️ Edit Skill</h3>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.skill.update', $skill->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="jenis_skill" class="form-label">Jenis Skill <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('jenis_skill') is-invalid @enderror" id="jenis_skill" name="jenis_skill" value="{{ old('jenis_skill', $skill->jenis_skill) }}" required>
                        @error('jenis_skill')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">💾 Simpan</button>
                        <a href="{{ route('admin.skill.index') }}" class="btn btn-secondary">❌ Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
