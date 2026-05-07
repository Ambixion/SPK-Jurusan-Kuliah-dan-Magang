@extends('layouts.admin')
@section('title', 'Manajemen Tempat Magang')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <p style="color:#8892a4;font-size:0.85rem;margin:0;">Total {{ $tempatMagang->total() }} tempat magang terdaftar</p>
        <a href="{{ route('admin.tempat_magang.create') }}" class="btn-primary-custom">+ Tambah Tempat</a>
    </div>
    <div class="card-dark" style="padding:0;overflow:hidden;">
        @if ($tempatMagang->isEmpty())
        <div style="padding:40px;text-align:center;color:#8892a4;">
            <div style="font-size:2.5rem;margin-bottom:12px;">❓</div>
            Belum ada data tempat magang.
            <a href="{{ route('admin.tempat_magang.create') }}" style="color:#5b6af0;"> Tambah sekarang</a>
        </div>
        @else
            <table class="table-dark-custom">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Tempat</th>
                        <th>Skill</th>
                        <th>Bidang</th>
                        <th>Kuota</th>
                        <th>Kontak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tempatMagang as $index => $item)
                        <tr>
                            <td>{{ $tempatMagang->firstItem() + $index }}</td>
                            <td><strong>{{ $item->nama }}</strong></td>
                            <td>{{ $item->skills->pluck('jenis_skill')->join(', ') ?: '-' }}</td>
                            <td>{{ $item->bidang }}</td>
                            <td><span class="badge bg-secondary">{{ $item->kuota }}</span></td>
                            <td>{{ $item->kontak }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.tempat_magang.edit', $item->id) }}"
                                        class="btn-sm-action btn-edit">✏ Edit</a>
                                    <form method="POST" action="{{ route('admin.tempat_magang.destroy', $item->id) }}"
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
                            <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $tempatMagang->links() }}
    </div>
    @endif
@endsection
