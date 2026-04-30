@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Manajemen User</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">+ Tambah User</a>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr><td colspan="5">Total: {{ $users->count() }}</td></tr>
        @foreach($users as $i => $user)
        <tr>
            <td>{{ $users->firstItem() + $i }}</td>
            <td>{{ $user->nama }}</td>
            <td>{{ $user->email }}</td>
            <td><span class="badge bg-secondary">{{ $user->role }}</span></td>
            <td>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="d-inline"
                    onsubmit="return confirm('Yakin hapus user ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endsection
