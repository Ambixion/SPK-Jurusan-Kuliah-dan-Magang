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
                            <td>
                                <div class="skill-container" style="display:flex;flex-wrap:wrap;gap:6px;">
                                    @forelse($item->skills as $i => $skill)
                                        <span class="badge-custom badge-magang skill-item" style="margin:0;display:{{ $i < 3 ? 'inline-flex' : 'none' }};white-space:nowrap;" data-skill-index="{{ $i }}">{{ $skill->jenis_skill }}</span>
                                    @empty
                                        <span style="color:#4a5568;font-size:0.8rem;">Belum ada skill</span>
                                    @endforelse
                                    @if($item->skills->count() > 3)
                                        <button type="button" class="skill-toggle-btn" style="padding:4px 12px;font-size:0.75rem;background:#5b6af0;color:#fff;border:none;border-radius:4px;cursor:pointer;white-space:nowrap;" onclick="toggleSkills(this)">+{{ $item->skills->count() - 3 }} lainnya</button>
                                    @endif
                                </div>
                            </td>
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
