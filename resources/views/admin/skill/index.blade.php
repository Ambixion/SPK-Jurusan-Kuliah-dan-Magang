@extends('layouts.admin')
@section('title', 'Manajemen Skill')
@section('page-title', 'Manajemen Skill')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p style="color:#8892a4;font-size:0.85rem;margin:0;">Total {{ $skills->total() }} skill terdaftar</p>
        <a href="{{ route('admin.skill.create') }}" class="btn-primary-custom">+ Tambah Skill</a>
    </div>
    <div class="card-dark" style="padding:0;overflow:hidden;">
        @if ($skills->isEmpty())
            <div style="padding:40px;text-align:center;color:#8892a4;">
                <div style="font-size:2.5rem;margin-bottom:12px;">🛠️</div>
                Belum ada data skill.
                <a href="{{ route('admin.skill.create') }}" style="color:#5b6af0;"> Tambah sekarang</a>
            </div>
        @else
            <table class="table-dark-custom">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Jenis Skill</th>
                        <th>Digunakan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($skills as $index => $skill)
                        <tr>
                            <td>{{ $skills->firstItem() + $index }}</td>
                            <td>{{ $skill->jenis_skill }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $skill->tempatMagang()->count() + $skill->jurusanSmk()->count() }} tempat
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.skill.edit', $skill->id) }}" class="btn-sm-action btn-edit">✏
                                        Edit</a>
                                    <form method="POST" action="{{ route('admin.skill.destroy', $skill->id) }}"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm-action btn-delete"
                                            onclick="return confirm('Yakin ingin menghapus?')">🗑 Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $skills->links() }}
    </div>
    @endif
@endsection
