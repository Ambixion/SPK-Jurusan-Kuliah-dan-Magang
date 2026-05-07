@extends('layouts.admin')
@section('title', 'Jurusan Kuliah')
@section('page-title', 'Manajemen Jurusan')

@section('content')
{{-- SUBNAV --}}
<div style="display:flex;gap:8px;margin-bottom:24px;border-bottom:1px solid #1e2a42;padding-bottom:0;">
    <a href="{{ route('admin.jurusan_kuliah.index') }}"
       style="padding:10px 20px;border-radius:10px 10px 0 0;font-weight:600;font-size:0.875rem;text-decoration:none;
              background:linear-gradient(135deg,#5b6af0,#7c3aed);color:#fff;">
        🎓 Jurusan Kuliah
    </a>
    <a href="{{ route('admin.jurusan_smk.index') }}"
       style="padding:10px 20px;border-radius:10px 10px 0 0;font-weight:600;font-size:0.875rem;text-decoration:none;
              background:#1e2a42;color:#a0aec0;">
        🏫 Jurusan SMK
    </a>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <p style="color:#8892a4;font-size:0.85rem;margin:0;">Total {{ $jurusan->total() }} jurusan kuliah</p>
    <a href="{{ route('admin.jurusan_kuliah.create') }}" class="btn-primary-custom">+ Tambah Jurusan Kuliah</a>
</div>

<div class="card-dark" style="padding:0;overflow:hidden;">
    @if($jurusan->isEmpty())
        <div style="padding:40px;text-align:center;color:#8892a4;">
            <div style="font-size:2.5rem;margin-bottom:12px;">🎓</div>
            Belum ada data jurusan kuliah.
            <a href="{{ route('admin.jurusan_kuliah.create') }}" style="color:#5b6af0;"> Tambah sekarang</a>
        </div>
    @else
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jurusan</th>
                    <th>Bidang Studi</th>
                    <th>Deskripsi</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jurusan as $i => $item)
                <tr>
                    <td style="color:#8892a4;">{{ $jurusan->firstItem() + $i }}</td>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td><span class="badge-custom badge-jurusan">{{ $item->bidang_studi }}</span></td>
                    <td style="color:#8892a4;">{{ Str::limit($item->deskripsi, 40) ?: '-' }}</td>
                    <td style="text-align:right;">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.jurusan_kuliah.edit', $item->id) }}" class="btn-sm-action btn-edit">✏ Edit</a>
                            <form method="POST" action="{{ route('admin.jurusan_kuliah.destroy', $item->id) }}" class="d-inline"
                                onsubmit="return confirm('Yakin hapus jurusan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm-action btn-delete">🗑 Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:16px 20px;border-top:1px solid #1e2a42;">{{ $jurusan->links() }}</div>
    @endif
</div>
@endsection
