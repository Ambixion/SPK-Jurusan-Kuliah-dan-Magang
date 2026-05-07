@extends('layouts.admin')
@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('content')
<div style="max-width:560px;">
    <div class="card-dark">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="mb-4">
                <label class="form-label-custom">Nama <span style="color:#f87171">*</span></label>
                <input type="text" name="nama"
                    class="form-control form-control-dark @error('nama') is-invalid @enderror"
                    value="{{ old('nama') }}" placeholder="Nama lengkap">
                @error('nama')<div class="invalid-feedback" style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label-custom">Email <span style="color:#f87171">*</span></label>
                <input type="email" name="email"
                    class="form-control form-control-dark @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="email@contoh.com">
                @error('email')<div class="invalid-feedback" style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label-custom">Password <span style="color:#f87171">*</span></label>
                <input type="password" name="password"
                    class="form-control form-control-dark @error('password') is-invalid @enderror"
                    placeholder="Minimal 6 karakter">
                @error('password')<div class="invalid-feedback" style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label-custom">Konfirmasi Password <span style="color:#f87171">*</span></label>
                <input type="password" name="password_confirmation"
                    class="form-control form-control-dark"
                    placeholder="Ulangi password">
            </div>

            <div class="mb-4">
                <label class="form-label-custom">Role <span style="color:#f87171">*</span></label>
                <select name="role" class="form-select form-select-dark @error('role') is-invalid @enderror">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru"  {{ old('role') == 'guru'  ? 'selected' : '' }}>Guru</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
                @error('role')<div class="invalid-feedback" style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

<div id="siswa-field"
    style="{{ old('role') == 'siswa' ? '' : 'display:none;' }}"
    class="mb-4">

    <label class="form-label-custom">
        Jurusan Siswa <span style="color:#f87171">*</span>
    </label>

    <select name="jurusan_smk_id"
        class="form-select form-select-dark @error('jurusan_smk_id') is-invalid @enderror">

        <option value="">-- Pilih Jurusan --</option>

        @foreach($jurusans as $jurusan)
            <option value="{{ $jurusan->id }}"
                {{ old('jurusan_smk_id') == $jurusan->id ? 'selected' : '' }}>

                {{ $jurusan->nama_jurusan }}

            </option>
        @endforeach

    </select>

    @error('jurusan_smk_id')
        <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">
            {{ $message }}
        </div>
    @enderror
</div>

            <div class="d-flex gap-3 mt-2">
                <button type="submit" class="btn-primary-custom">💾 Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="btn-secondary-custom">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const roleSelect = document.querySelector('select[name="role"]');
    const siswaField = document.getElementById('siswa-field');
    function toggleSiswa() {
        siswaField.style.display = roleSelect.value === 'siswa' ? 'block' : 'none';
    }
    roleSelect.addEventListener('change', toggleSiswa);
    toggleSiswa();
</script>
@endpush
@endsection
