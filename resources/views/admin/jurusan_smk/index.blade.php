@extends('layouts.admin')
@section('title', 'Jurusan SMK')
@section('page-title', 'Manajemen Jurusan')

@section('content')
{{-- SUBNAV --}}
<div style="display:flex;gap:8px;margin-bottom:24px;border-bottom:1px solid #1e2a42;padding-bottom:0;">
    <a href="{{ route('admin.jurusan_kuliah.index') }}"
       style="padding:10px 20px;border-radius:10px 10px 0 0;font-weight:600;font-size:0.875rem;text-decoration:none;background:#1e2a42;color:#a0aec0;">
        🎓 Jurusan Kuliah
    </a>
    <a href="{{ route('admin.jurusan_smk.index') }}"
       style="padding:10px 20px;border-radius:10px 10px 0 0;font-weight:600;font-size:0.875rem;text-decoration:none;background:linear-gradient(135deg,#5b6af0,#7c3aed);color:#fff;">
        🏫 Jurusan SMK
    </a>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <p style="color:#8892a4;font-size:0.85rem;margin:0;">Total {{ $jurusan->total() }} jurusan SMK</p>
    <a href="{{ route('admin.jurusan_smk.create') }}" class="btn-primary-custom">+ Tambah Jurusan SMK</a>
</div>

<div class="card-dark" style="padding:0;overflow:hidden;">
    @if($jurusan->isEmpty())
        <div style="padding:40px;text-align:center;color:#8892a4;">
            <div style="font-size:2.5rem;margin-bottom:12px;">🏫</div>
            Belum ada data jurusan SMK.
            <a href="{{ route('admin.jurusan_smk.create') }}" style="color:#5b6af0;"> Tambah sekarang</a>
        </div>
    @else
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jurusan</th>
                    <th>Skill Terkait</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jurusan as $i => $item)
                <tr>
                    <td style="color:#8892a4;">{{ $jurusan->firstItem() + $i }}</td>
                    <td><strong>{{ $item->nama_jurusan }}</strong></td>
                    <td>
                        <div class="skill-container" style="display:flex;flex-wrap:wrap;gap:6px;">
                            @forelse($item->skills as $i => $skill)
                                <span class="badge-custom badge-magang skill-item" style="margin:0;display:{{ $i < 3 ? 'inline-flex' : 'none' }};" data-skill-index="{{ $i }}">{{ $skill->jenis_skill }}</span>
                            @empty
                                <span style="color:#4a5568;font-size:0.8rem;">Belum ada skill</span>
                            @endforelse
                            @if($item->skills->count() > 3)
                                <button type="button" class="skill-toggle-btn" style="padding:4px 12px;font-size:0.75rem;background:#5b6af0;color:#fff;border:none;border-radius:4px;cursor:pointer;" onclick="toggleSkills(this)">+{{ $item->skills->count() - 3 }} lainnya</button>
                            @endif
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.jurusan_smk.edit', $item->id) }}" class="btn-sm-action btn-edit">✏ Edit</a>
                            <form method="POST"
                                  action="{{ route('admin.jurusan_smk.destroy', $item->id) }}"
                                  class="d-inline"
                                  data-confirm-delete
                                  data-confirm-text="Yakin hapus jurusan ini?">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.skill-toggle-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const container = this.closest('.skill-container');
                const items = container.querySelectorAll('.skill-item');
                const isExpanded = this.dataset.expanded === 'true';
                
                items.forEach(item => {
                    const skillIndex = parseInt(item.dataset.skillIndex);
                    if (isExpanded) {
                        item.style.display = skillIndex >= 3 ? 'none' : 'inline-flex';
                    } else {
                        item.style.display = 'inline-flex';
                    }
                });
                
                if (isExpanded) {
                    this.dataset.expanded = 'false';
                    this.textContent = '+' + (items.length - 3) + ' lainnya';
                } else {
                    this.dataset.expanded = 'true';
                    this.textContent = 'Tampilkan lebih sedikit';
                }
            });
        });
    });
</script>
@endsection
