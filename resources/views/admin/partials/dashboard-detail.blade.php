@if(($detailKey ?? null) && ($detailItems ?? null))
    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
        <div style="font-weight:700;color:#fff;">{{ $detailTitle ?? 'Detail Data' }}</div>
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary-custom">Tutup</a>
    </div>

    <div class="card-dark mb-3" style="padding:14px 16px;display:inline-flex;">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex gap-2 align-items-center" data-dashboard-detail-search>
            <input type="hidden" name="detail" value="{{ $detailKey }}">
            <input type="text"
                   name="q"
                   value="{{ $q ?? '' }}"
                   class="form-control-dark"
                   placeholder="Search..."
                   style="max-width:360px;">
            <button type="submit" class="btn-primary-custom">Cari</button>
            @if(($q ?? '') !== '')
                <a href="{{ route('admin.dashboard', ['detail' => $detailKey]) }}" class="btn-secondary-custom">Reset</a>
            @endif
        </form>
    </div>

    <div class="card-dark" style="padding:0;overflow:hidden;">
        @if($detailItems->isEmpty())
            <div style="padding:40px;text-align:center;color:#8892a4;">
                Tidak ada data untuk ditampilkan.
            </div>
        @else
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th style="width:80px;">No</th>
                        @if($detailKey === 'kriteria')
                            <th>Nama Kriteria</th>
                            <th>Bobot</th>
                            <th>Tipe</th>
                            <th>Jenis</th>
                        @elseif($detailKey === 'jurusan_kuliah')
                            <th>Nama Jurusan</th>
                            <th>Bidang Studi</th>
                            <th>Deskripsi</th>
                        @elseif($detailKey === 'jurusan_smk')
                            <th>Nama Jurusan</th>
                            <th>Skill Terkait</th>
                        @elseif($detailKey === 'tempat_magang')
                            <th>Nama Tempat</th>
                            <th>Bidang</th>
                            <th>Kuota</th>
                            <th>Kontak</th>
                            <th>Skill</th>
                        @elseif($detailKey === 'users')
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                        @elseif($detailKey === 'siswa')
                            <th>Nama</th>
                            <th>Jurusan SMK</th>
                            <th>Email</th>
                        @elseif($detailKey === 'guru')
                            <th>Nama</th>
                            <th>Email</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($detailItems as $i => $row)
                        <tr>
                            <td style="color:#8892a4;">{{ $i + 1 }}</td>
                            @if($detailKey === 'kriteria')
                                <td><strong>{{ $row->nama }}</strong></td>
                                <td style="color:#5b6af0;font-weight:600;">{{ $row->weight }}</td>
                                <td><span class="badge-custom {{ $row->type === 'benefit' ? 'badge-benefit' : 'badge-cost' }}">{{ ucfirst($row->type) }}</span></td>
                                <td><span class="badge-custom {{ $row->jenis === 'jurusan' ? 'badge-jurusan' : 'badge-magang' }}">{{ ucfirst($row->jenis) }}</span></td>
                            @elseif($detailKey === 'jurusan_kuliah')
                                <td><strong>{{ $row->nama }}</strong></td>
                                <td><span class="badge-custom badge-jurusan">{{ $row->bidang_studi }}</span></td>
                                <td style="color:#8892a4;">{{ \Illuminate\Support\Str::limit($row->deskripsi, 60) ?: '-' }}</td>
                            @elseif($detailKey === 'jurusan_smk')
                                <td><strong>{{ $row->nama_jurusan }}</strong></td>
                                <td>
                                    @forelse($row->skills as $skill)
                                        <span class="badge-custom badge-magang" style="margin:2px;">{{ $skill->jenis_skill }}</span>
                                    @empty
                                        <span style="color:#4a5568;font-size:0.8rem;">Belum ada skill</span>
                                    @endforelse
                                </td>
                            @elseif($detailKey === 'tempat_magang')
                                <td><strong>{{ $row->nama }}</strong></td>
                                <td>{{ $row->bidang ?: '-' }}</td>
                                <td><span class="badge-custom badge-magang">{{ $row->kuota }}</span></td>
                                <td style="color:#8892a4;">{{ $row->kontak ?: '-' }}</td>
                                <td>
                                    @forelse($row->skills as $skill)
                                        <span class="badge-custom badge-magang" style="margin:2px;">{{ $skill->jenis_skill }}</span>
                                    @empty
                                        <span style="color:#4a5568;font-size:0.8rem;">Belum ada skill</span>
                                    @endforelse
                                </td>
                            @elseif($detailKey === 'users')
                                <td><strong>{{ $row->nama }}</strong></td>
                                <td style="color:#8892a4;">{{ $row->email }}</td>
                                <td><span class="badge-custom badge-{{ $row->role }}">{{ ucfirst($row->role) }}</span></td>
                            @elseif($detailKey === 'siswa')
                                <td><strong>{{ $row->user->nama ?? '-' }}</strong></td>
                                <td>
                                    <span class="badge-custom badge-jurusan">
                                        {{ $row->jurusanSmk->nama_jurusan ?? '-' }}
                                    </span>
                                </td>
                                <td style="color:#8892a4;">{{ $row->user->email ?? '-' }}</td>
                            @elseif($detailKey === 'guru')
                                <td><strong>{{ $row->user->nama ?? '-' }}</strong></td>
                                <td style="color:#8892a4;">{{ $row->user->email ?? '-' }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endif

