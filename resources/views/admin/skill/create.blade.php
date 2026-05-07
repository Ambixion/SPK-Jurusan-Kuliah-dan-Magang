@extends('layouts.admin')

@section('title', 'Tambah Skill')
@section('page-title', 'Tambah Skill')

@section('content')

<div style="max-width:700px;">

    <div class="card-dark">

        <form method="POST" action="{{ route('admin.skill.store') }}">
            @csrf

            <div class="mb-4">

                <label class="form-label-custom">
                    Jenis Skill <span style="color:#f87171">*</span>
                </label>

                <input
                    type="text"
                    name="jenis_skill"
                    value="{{ old('jenis_skill') }}"
                    placeholder="Contoh: Web Development, Database, UI/UX"

                    class="form-control form-control-dark
                    @error('jenis_skill') is-invalid @enderror">

                @error('jenis_skill')
                    <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="d-flex gap-3 mt-2">

                <button type="submit" class="btn-primary-custom">
                    💾 Simpan
                </button>

                <a href="{{ route('admin.skill.index') }}"
                    class="btn-secondary-custom">
                    ❌ Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
