@extends('layouts.guru')

@section('title', 'Data Pemilihan Prodi')

@section('content')

    <h1 class="page-title">
        Data Pemilihan Prodi
    </h1>

    <div class="card-main page-table-card">

        {{-- FILTER --}}
        <div class="toolbar-filter">

            <div class="search-box">

                <div class="search-icon">
                    🔍
                </div>

                <input type="text" id="searchInput" class="search-input" placeholder="Cari nama prodi atau bidang studi...">

            </div>

            <select id="bidangFilter" class="filter-select">

                <option value="">
                    Semua Bidang Studi
                </option>

                @foreach ($jurusanKuliah->pluck('bidang_studi')->filter()->unique() as $bidang)
                    <option value="{{ $bidang }}">
                        {{ $bidang }}
                    </option>
                @endforeach

            </select>

        </div>

        {{-- TABLE --}}
        <div class="table-scroll">

            <div class="table-scroll-horizontal">

                <table class="student-table" id="prodiTable">

                    <thead>

                        <tr>

                            <th style="width:70px;">
                                No
                            </th>

                            <th>
                                Nama Program Studi
                            </th>

                            <th>
                                Bidang Studi
                            </th>

                            <th>
                                Deskripsi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($jurusanKuliah as $item)
                            @php
                                $nama = $item->nama ?? '-';
                                $bidang = $item->bidang_studi ?? '-';
                                $deskripsi = $item->deskripsi ?? '-';
                            @endphp

                            <tr data-nama="{{ strtolower($nama) }}" data-bidang="{{ strtolower($bidang) }}">

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td style="text-align:left; font-weight:600;">
                                    {{ $nama }}
                                </td>

                                <td>

                                    <span class="badge-success">
                                        {{ $bidang }}
                                    </span>

                                </td>

                                <td style="text-align:left;">
                                    {{ \Illuminate\Support\Str::limit($deskripsi, 100) }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" style="padding:30px;">

                                    <div style="color: rgba(255,255,255,.6);">
                                        Belum ada data jurusan kuliah.
                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        initTableFilter({
            tableId: 'prodiTable',
            searchId: 'searchInput',
            filterId: 'bidangFilter'
        });
    </script>
@endpush
