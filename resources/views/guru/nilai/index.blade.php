@extends('layouts.guru')

@section('title', 'Data Pemilihan PKL')

@section('content')

    <h1 class="page-title">
        Data Pemilihan PKL
    </h1>

    {{-- STAT --}}
    <div class="grid-3-pkl">

        <div class="stat-box">
            <div class="stat-label-sm">
                Total Tempat Magang
            </div>

            <div class="stat-value blue">
                {{ $tempatMagang->total() }}
            </div>
        </div>

        <div class="stat-box">
            <div class="stat-label-sm">
                Total Bidang
            </div>

            <div class="stat-value green">
                {{ $tempatMagang->pluck('bidang')->filter()->unique()->count() }}
            </div>
        </div>

        <div class="stat-box">
            <div class="stat-label-sm">
                Total Kuota
            </div>

            <div class="stat-value orange">
                {{ $tempatMagang->sum('kuota') }}
            </div>
        </div>

    </div>

    {{-- CARD --}}
    <div class="card-main pkl-card">

        <div class="card-title">
            List Tempat Magang
        </div>

        {{-- FILTER --}}
        <div class="toolbar-pkl">

            <div class="search-box">

                <div class="search-icon">
                    🔍
                </div>

                <input
                    type="text"
                    id="searchInput"
                    class="search-input"
                    placeholder="Cari tempat magang..."
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
                        <th style="width:70px;">No</th>
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
                                {{ $tempatMagang->firstItem() + $loop->index }}
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
                                        {{ $kuota }} Orang
                                    </span>

                                @else

                                    <span class="badge-warning">
                                        Belum Ada
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

        {{-- PAGINATION --}}
        <div class="pagination-wrap">
            {{ $tempatMagang->links() }}
        </div>

    </div>

@endsection

@push('styles')
<style>

    /* =========================================
       GRID STAT
    ========================================= */

    .grid-3-pkl {

        display: grid;
        grid-template-columns: repeat(3, 1fr);

        gap: 14px;

        margin-bottom: 20px;
    }

    /* =========================================
       CARD
    ========================================= */

    .pkl-card {

        display: flex;
        flex-direction: column;

        gap: 18px;

        overflow: hidden;
    }

    /* =========================================
       FILTER
    ========================================= */

    .toolbar-pkl {

        display: grid;
        grid-template-columns: 1fr 220px;

        gap: 14px;
    }

    .search-box {
        position: relative;
    }

    .search-icon {

        position: absolute;

        left: 16px;
        top: 50%;

        transform: translateY(-50%);

        font-size: 13px;

        color: rgba(255,255,255,.45);

        pointer-events: none;
    }

    .search-input,
    .filter-select {

        width: 100%;
        height: 50px;

        border-radius: 14px;

        border: 1px solid rgba(255,255,255,.08);

        background: rgba(255,255,255,.06);

        color: white;

        outline: none;

        font-family: inherit;
        font-size: 13px;
        font-weight: 500;

        transition: .25s ease;

        backdrop-filter: blur(10px);
    }

    .search-input {

        padding-left: 44px;
        padding-right: 14px;
    }

    .filter-select {

        padding: 0 16px;

        cursor: pointer;

        appearance: none;

        background-image:
            linear-gradient(45deg, transparent 50%, rgba(255,255,255,.7) 50%),
            linear-gradient(135deg, rgba(255,255,255,.7) 50%, transparent 50%);

        background-position:
            calc(100% - 20px) 22px,
            calc(100% - 14px) 22px;

        background-size:
            6px 6px,
            6px 6px;

        background-repeat: no-repeat;
    }

    .filter-select option {
        background: #1f2244;
        color: white;
    }

    .search-input::placeholder {
        color: rgba(255,255,255,.45);
    }

    .search-input:focus,
    .filter-select:focus {

        border-color: rgba(79,110,247,.7);

        box-shadow:
            0 0 0 4px rgba(79,110,247,.15);

        background: rgba(255,255,255,.08);
    }

    /* =========================================
       TABLE
    ========================================= */

    .table-scroll {

        width: 100%;

        overflow-x: auto;

        border-radius: 14px;

        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,.2) transparent;
    }

    .table-scroll::-webkit-scrollbar {
        height: 7px;
    }

    .table-scroll::-webkit-scrollbar-thumb {

        background: rgba(255,255,255,.2);

        border-radius: 20px;
    }

    .student-table {

        width: 100%;
        min-width: 980px;

        border-collapse: collapse;
    }

    .student-table thead th {

        position: sticky;
        top: 0;

        z-index: 5;
    }

    .table-title {
        font-weight: 700;
    }

    .text-left {
        text-align: left !important;
    }

    .empty-data {

        padding: 40px !important;

        color: rgba(255,255,255,.6);
    }

    /* =========================================
       PAGINATION
    ========================================= */

    .pagination-wrap {

        margin-top: 4px;
    }

    .pagination-wrap nav {
        color: white;
    }

    /* =========================================
       MOBILE
    ========================================= */

    @media (max-width: 768px) {

        .grid-3-pkl {

            grid-template-columns: repeat(2, 1fr);

            gap: 12px;
        }

        .toolbar-pkl {

            grid-template-columns: 1fr 145px;

            gap: 10px;
        }

        .search-input,
        .filter-select {

            height: 44px;

            font-size: 12px;

            border-radius: 12px;
        }

        .search-input {
            padding-left: 40px;
        }

        .search-icon {

            left: 14px;

            font-size: 12px;
        }

        .student-table {

            min-width: 900px;
        }

        .pagination-wrap {

            overflow-x: auto;
        }
    }

    @media (max-width: 480px) {

        .grid-3-pkl {

            grid-template-columns: 1fr 1fr;
        }

        .toolbar-pkl {

            grid-template-columns: 1fr 120px;
        }

        .stat-value {

            font-size: 18px;
        }
    }

</style>
@endpush

@push('scripts')
<script>

    const searchInput =
        document.getElementById('searchInput');

    const bidangFilter =
        document.getElementById('bidangFilter');

    const rows =
        document.querySelectorAll('#magangTable tbody tr');

    function filterTable() {

        const search =
            searchInput.value.toLowerCase();

        const bidangValue =
            bidangFilter.value.toLowerCase();

        rows.forEach(row => {

            const nama =
                row.dataset.nama || '';

            const bidang =
                row.dataset.bidang || '';

            const matchSearch =
                nama.includes(search) ||
                bidang.includes(search);

            const matchBidang =
                bidangValue === '' ||
                bidang === bidangValue;

            row.style.display =
                matchSearch && matchBidang
                ? ''
                : 'none';
        });
    }

    searchInput.addEventListener(
        'input',
        filterTable
    );

    bidangFilter.addEventListener(
        'change',
        filterTable
    );

</script>
@endpush
