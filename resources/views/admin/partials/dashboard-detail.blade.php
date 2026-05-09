@if(($detailKey ?? null) && ($detailItems ?? null))
    @php
        $headers = ['No'];
        if ($detailKey === 'kriteria') {
            $headers = ['No', 'Nama Kriteria', 'Bobot', 'Tipe', 'Jenis'];
        } elseif ($detailKey === 'jurusan_kuliah') {
            $headers = ['No', 'Nama Jurusan', 'Bidang Studi', 'Deskripsi'];
        } elseif ($detailKey === 'jurusan_smk') {
            $headers = ['No', 'Nama Jurusan', 'Skill Terkait'];
        } elseif ($detailKey === 'tempat_magang') {
            $headers = ['No', 'Nama Tempat', 'Bidang', 'Kuota', 'Kontak', 'Skill'];
        } elseif ($detailKey === 'users') {
            $headers = ['No', 'Nama', 'Email', 'Role'];
        } elseif ($detailKey === 'siswa') {
            $headers = ['No', 'Nama', 'Jurusan SMK', 'Email'];
        } elseif ($detailKey === 'guru') {
            $headers = ['No', 'Nama', 'Email'];
        }
    @endphp

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
            <table class="table-dark-custom table-cards-mobile">
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
                            <td data-label="{{ $headers[0] ?? 'No' }}" style="color:#8892a4;">{{ $i + 1 }}</td>
                            @if($detailKey === 'kriteria')
                                <td data-label="{{ $headers[1] ?? 'Nama Kriteria' }}"><strong>{{ $row->nama }}</strong></td>
                                <td data-label="{{ $headers[2] ?? 'Bobot' }}" style="color:#5b6af0;font-weight:600;">{{ $row->weight }}</td>
                                <td data-label="{{ $headers[3] ?? 'Tipe' }}"><span class="badge-custom {{ $row->type === 'benefit' ? 'badge-benefit' : 'badge-cost' }}">{{ ucfirst($row->type) }}</span></td>
                                <td data-label="{{ $headers[4] ?? 'Jenis' }}"><span class="badge-custom {{ $row->jenis === 'jurusan' ? 'badge-jurusan' : 'badge-magang' }}">{{ ucfirst($row->jenis) }}</span></td>
                            @elseif($detailKey === 'jurusan_kuliah')
                                <td data-label="{{ $headers[1] ?? 'Nama Jurusan' }}"><strong>{{ $row->nama }}</strong></td>
                                <td data-label="{{ $headers[2] ?? 'Bidang Studi' }}"><span class="badge-custom badge-jurusan">{{ $row->bidang_studi }}</span></td>
                                <td data-label="{{ $headers[3] ?? 'Deskripsi' }}" style="color:#8892a4;">{{ \Illuminate\Support\Str::limit($row->deskripsi, 60) ?: '-' }}</td>
                            @elseif($detailKey === 'jurusan_smk')
                                <td data-label="{{ $headers[1] ?? 'Nama Jurusan' }}"><strong>{{ $row->nama_jurusan }}</strong></td>
                                <td data-label="{{ $headers[2] ?? 'Skill Terkait' }}">
                                    @forelse($row->skills as $skill)
                                        <span class="badge-custom badge-magang" style="margin:2px;">{{ $skill->jenis_skill }}</span>
                                    @empty
                                        <span style="color:#4a5568;font-size:0.8rem;">Belum ada skill</span>
                                    @endforelse
                                </td>
                            @elseif($detailKey === 'tempat_magang')
                                <td data-label="{{ $headers[1] ?? 'Nama Tempat' }}"><strong>{{ $row->nama }}</strong></td>
                                <td data-label="{{ $headers[2] ?? 'Bidang' }}">{{ $row->bidang ?: '-' }}</td>
                                <td data-label="{{ $headers[3] ?? 'Kuota' }}"><span class="badge-custom badge-magang">{{ $row->kuota }}</span></td>
                                <td data-label="{{ $headers[4] ?? 'Kontak' }}" style="color:#8892a4;">{{ $row->kontak ?: '-' }}</td>
                                <td data-label="{{ $headers[5] ?? 'Skill' }}">
                                    @forelse($row->skills as $skill)
                                        <span class="badge-custom badge-magang" style="margin:2px;">{{ $skill->jenis_skill }}</span>
                                    @empty
                                        <span style="color:#4a5568;font-size:0.8rem;">Belum ada skill</span>
                                    @endforelse
                                </td>
                            @elseif($detailKey === 'users')
                                <td data-label="{{ $headers[1] ?? 'Nama' }}"><strong>{{ $row->nama }}</strong></td>
                                <td data-label="{{ $headers[2] ?? 'Email' }}" style="color:#8892a4;">{{ $row->email }}</td>
                                <td data-label="{{ $headers[3] ?? 'Role' }}"><span class="badge-custom badge-{{ $row->role }}">{{ ucfirst($row->role) }}</span></td>
                            @elseif($detailKey === 'siswa')
                                <td data-label="{{ $headers[1] ?? 'Nama' }}"><strong>{{ $row->user->nama ?? '-' }}</strong></td>
                                <td data-label="{{ $headers[2] ?? 'Jurusan SMK' }}">
                                    <span class="badge-custom badge-jurusan">
                                        {{ $row->jurusanSmk->nama_jurusan ?? '-' }}
                                    </span>
                                </td>
                                <td data-label="{{ $headers[3] ?? 'Email' }}" style="color:#8892a4;">{{ $row->user->email ?? '-' }}</td>
                            @elseif($detailKey === 'guru')
                                <td data-label="{{ $headers[1] ?? 'Nama' }}"><strong>{{ $row->user->nama ?? '-' }}</strong></td>
                                <td data-label="{{ $headers[2] ?? 'Email' }}" style="color:#8892a4;">{{ $row->user->email ?? '-' }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endif

