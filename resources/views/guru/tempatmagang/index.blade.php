@extends('layouts.guru')

@section('title', 'Data Pemilihan PKL')

@section('content')

    <h1 class="page-title">
        Data Pemilihan PKL
    </h1>

    <div class="card-main page-table-card">

        {{-- FILTER --}}
        <div class="toolbar-filter">

            <div class="search-box">

                <div class="search-icon">
                    🔍
                </div>

                <input
                    type="text"
                    id="searchInput"
                    class="search-input"
                    placeholder="Cari nama tempat magang / bidang..."
                >

            </div>

            <select id="bidangFilter" class="filter-select">

                <option value="">
                    Semua Bidang
                </option>

                @foreach($tempatMagang->pluck('bidang')->filter()->unique() as $bidang)

                    <option value="{{ $bidang }}">
                        {{ $bidang }}
                    </option>

                @endforeach

            </select>

        </div>

        {{-- TABLE --}}
        <div class="table-scroll">

            <table class="student-table" id="magangTable">

                <thead>
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>Nama Tempat Magang</th>
                        <th>Bidang</th>
                        <th>Kuota</th>
                        <th>Kontak</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($tempatMagang as $item)

                        @php
                            $nama = $item->nama ?? '-';
                            $bidang = $item->bidang ?? '-';
                            $kuota = $item->kuota ?? 0;
                            $kontak = $item->kontak ?? '-';
                            $deskripsi = $item->deskripsi ?? '-';
                        @endphp

                        <tr
                            data-nama="{{ strtolower($nama) }}"
                            data-bidang="{{ strtolower($bidang) }}"
                        >

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-left table-title">
                                {{ $nama }}
                            </td>

                            <td>

                                <span class="badge-success">
                                    {{ $bidang }}
                                </span>

                            </td>

                            <td>

                                @if($kuota > 0)

                                    <span class="badge-success">
                                        {{ $kuota }}
                                    </span>

                                @else

                                    <span class="badge-warning">
                                        Tidak Tersedia
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $kontak }}
                            </td>

                            <td class="text-left">
                                {{ \Illuminate\Support\Str::limit($deskripsi, 80) }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="empty-data">

                                Belum ada data tempat magang.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection

@push('scripts')

<script>

    initTableFilter({
        tableId: 'magangTable',
        searchId: 'searchInput',
        filterId: 'bidangFilter'
    });

</script>

@endpush

