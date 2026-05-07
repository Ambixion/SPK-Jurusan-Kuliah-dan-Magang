@extends('layouts.admin')
@section('title', 'Manajemen Kuisoner')
@section('page-title', 'Manajemen Kuisoner')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p style="color:#8892a4;font-size:0.85rem;margin:0;">Total {{ $kuisoner->total() }} soal terdaftar</p>
    <a href="{{ route('admin.kuisoner.create') }}" class="btn-primary-custom">+ Tambah Kuisoner</a>
</div>

<div class="card-dark" style="padding:0;overflow:hidden;">
    @if($kuisoner->isEmpty())
        <div style="padding:40px;text-align:center;color:#8892a4;">
            <div style="font-size:2.5rem;margin-bottom:12px;">❓</div>
            Belum ada data kuisoner.
            <a href="{{ route('admin.kuisoner.create') }}" style="color:#5b6af0;"> Tambah sekarang</a>
        </div>
    @else
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Soal</th>
                    <th>Jenis</th>
                    <th>Opsi</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kuisoner as $i => $item)
                <tr>
                    <td style="color:#8892a4;">{{ $kuisoner->firstItem() + $i }}</td>
                    <td style="max-width:380px;">{{ Str::limit($item->soal, 70) }}</td>
                    <td>
                        <span class="badge-custom {{ $item->type === 'jurusan' ? 'badge-jurusan' : 'badge-magang' }}">
                            {{ ucfirst($item->type) }}
                        </span>
                    </td>
                    <td>
                        <span style="color:#8892a4;font-size:0.85rem;">{{ $item->opsi->count() }} opsi</span>
                    </td>
                    <td style="text-align:right;">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.kuisoner.edit', $item->id) }}" class="btn-sm-action btn-edit">✏ Edit</a>
                            <form method="POST" action="{{ route('admin.kuisoner.destroy', $item->id) }}" class="d-inline"
                                onsubmit="return confirm('Yakin hapus soal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm-action btn-delete">🗑 Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:16px 20px;border-top:1px solid #1e2a42;">
            {{ $kuisoner->links() }}
        </div>
    @endif
</div>
@endsection
