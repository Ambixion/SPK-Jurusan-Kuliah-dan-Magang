@extends('layouts.admin')
@section('title', 'Kriteria')
@section('page-title', 'Kriteria Penilaian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p style="color:#8892a4;font-size:0.85rem;margin:0;">Total {{ $kriterias->total() }} kriteria terdaftar</p>
    <a href="{{ route('admin.kriteria.create') }}" class="btn-primary-custom">+ Tambah Kriteria</a>
</div>

<div class="card-dark" style="padding:0; overflow:hidden;">
    @if($kriterias->isEmpty())
        <div style="padding:40px; text-align:center; color:#8892a4;">
            <div style="font-size:2.5rem; margin-bottom:12px;">⚙️</div>
            Belum ada data kriteria.
            <a href="{{ route('admin.kriteria.create') }}" style="color:#5b6af0;"> Tambah sekarang</a>
        </div>
    @else
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kriteria</th>
                    <th>Bobot</th>
                    <th>Tipe</th>
                    <th>Jenis</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriterias as $i => $k)
                <tr>
                    <td style="color:#8892a4;">{{ $kriterias->firstItem() + $i }}</td>
                    <td><strong>{{ $k->nama }}</strong></td>
                    <td style="color:#5b6af0; font-weight:600;">{{ $k->weight }}</td>
                    <td><span class="badge-custom {{ $k->type === 'benefit' ? 'badge-benefit' : 'badge-cost' }}">{{ ucfirst($k->type) }}</span></td>
                    <td><span class="badge-custom {{ $k->jenis === 'jurusan' ? 'badge-jurusan' : 'badge-magang' }}">{{ ucfirst($k->jenis) }}</span></td>
                    <td style="text-align:right;">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.kriteria.edit', $k->id) }}" class="btn-sm-action btn-edit">✏ Edit</a>
                            <form method="POST" action="{{ route('admin.kriteria.destroy', $k->id) }}" class="d-inline"
                                onsubmit="return confirm('Yakin hapus kriteria ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm-action btn-delete">🗑 Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:16px 20px; border-top:1px solid #1e2a42;">
            {{ $kriterias->links() }}
        </div>
    @endif
</div>
@endsection
