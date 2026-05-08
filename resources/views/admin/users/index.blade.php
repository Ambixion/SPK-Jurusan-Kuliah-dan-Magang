@extends('layouts.admin')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p style="color:#8892a4;font-size:0.85rem;margin:0;">Total {{ $users->total() }} user terdaftar</p>
    <a href="{{ route('admin.users.create') }}" class="btn-primary-custom">+ Tambah User</a>
</div>

<div class="card-dark" style="padding:0;overflow:hidden;">
    <table class="table-dark-custom">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th style="text-align:right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $user)
            <tr>
                <td style="color:#8892a4;">{{ $users->firstItem() + $i }}</td>
                <td><strong>{{ $user->nama }}</strong></td>
                <td style="color:#8892a4;">{{ $user->email }}</td>
                <td><span class="badge-custom badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                <td style="text-align:right;">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-sm-action btn-edit">✏ Edit</a>
                        <form method="POST"
                              action="{{ route('admin.users.destroy', $user->id) }}"
                              class="d-inline"
                              data-confirm-delete
                              data-confirm-text="Yakin hapus user ini?">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-sm-action btn-delete">🗑 Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:40px;color:#8892a4;">Belum ada user.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="padding:16px 20px;border-top:1px solid #1e2a42;">{{ $users->links() }}</div>
@endsection
