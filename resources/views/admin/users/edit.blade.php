@extends('layouts.admin')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
    <div style="max-width:560px;">
        <div class="card-dark">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="form-label-custom">Nama <span style="color:#f87171">*</span></label>
                    <input type="text" name="nama"
                        class="form-control form-control-dark @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $user->nama) }}">
                    @error('nama')
                        <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="form-label-custom">Email <span style="color:#f87171">*</span></label>
                    <input type="email" name="email"
                        class="form-control form-control-dark @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="form-label-custom">Password <span style="color:#8892a4;font-size:0.75rem;">(kosongkan jika
                            tidak ingin mengubah)</span></label>
                    <input type="password" name="password"
                        class="form-control form-control-dark @error('password') is-invalid @enderror"
                        placeholder="Password baru">
                    @error('password')
                        <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="form-label-custom">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-dark"
                        placeholder="Ulangi password baru">
                </div>
                <div class="mb-4">
                    <label class="form-label-custom">Role <span style="color:#f87171">*</span></label>
                    <select name="role" class="form-select form-select-dark @error('role') is-invalid @enderror">
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>
                    @error('role')
                        <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div id="siswa-field" style="{{ old('role', $user->role) == 'siswa' ? '' : 'display:none;' }}"
                    class="mb-4">

                    <label class="form-label-custom">
                        Jurusan Siswa <span style="color:#f87171">*</span>
                    </label>

                    <select name="jurusan_smk_id"
                        class="form-select form-select-dark @error('jurusan_smk_id') is-invalid @enderror">

                        <option value="">-- Pilih Jurusan --</option>

                        @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}"
                                {{ old('jurusan_smk_id', optional($user->siswa)->jurusan_smk_id) == $jurusan->id ? 'selected' : '' }}>

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
                    <button type="submit" class="btn-primary-custom">💾 Update</button>
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary-custom">❌ Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
