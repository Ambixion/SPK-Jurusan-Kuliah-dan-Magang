<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemilihan PKL</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #05051f;
            color: white;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 310px;
            background: #070720;
            min-height: 100vh;
            padding: 35px 34px;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 2px solid rgba(255,255,255,0.08);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 45px;
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #b8dff2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        .profile-name {
            font-weight: 700;
            font-size: 15px;
        }

        .profile-role {
            font-size: 13px;
            color: #d6d6e7;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 13px 14px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            background: #151541;
            border: 2px solid rgba(255,255,255,0.18);
            font-weight: 600;
            transition: 0.25s;
        }

        .menu-item:hover,
        .menu-item.active {
            background: #222264;
            transform: translateX(5px);
        }

        .menu-icon {
            width: 48px;
            height: 48px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .yellow { background: #e6b800; }
        .red { background: #e21414; }
        .purple { background: #4141bb; }
        .green { background: #43c23f; }

        .logout-btn {
            background: #4444b7;
            color: white;
            border: none;
            border-radius: 22px;
            padding: 12px 32px;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
        }

        .main {
            margin-left: 310px;
            width: calc(100% - 310px);
            padding: 42px 78px;
        }

        .title {
            font-size: 34px;
            font-weight: 800;
            margin-bottom: 35px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card {
            background: #242467;
            border-radius: 12px;
            padding: 26px;
        }

        .toolbar {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 18px;
            margin-bottom: 22px;
        }

        .input,
        .select {
            height: 46px;
            border: none;
            border-radius: 24px;
            background: #5656ea;
            color: white;
            padding: 0 18px;
            font-family: 'Poppins', sans-serif;
            outline: none;
            font-size: 14px;
        }

        .input::placeholder {
            color: white;
            opacity: 0.95;
        }

        .select {
            cursor: pointer;
            appearance: none;
            background-image: linear-gradient(45deg, transparent 50%, #ffffff 50%),
                              linear-gradient(135deg, #ffffff 50%, transparent 50%);
            background-position: calc(100% - 22px) 19px, calc(100% - 16px) 19px;
            background-size: 6px 6px, 6px 6px;
            background-repeat: no-repeat;
        }

        .select option {
            background: #242467;
            color: white;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: #343493;
        }

        .table th,
        .table td {
            border: 1px solid rgba(0,0,0,0.25);
            padding: 14px 16px;
            text-align: center;
            font-size: 14px;
        }

        .table th {
            background: #303083;
            font-weight: 700;
        }

        .table td {
            font-weight: 500;
        }

        .table td.text-left {
            text-align: left;
        }

        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 18px;
            font-size: 13px;
            font-weight: 700;
        }

        .badge-success {
            background: rgba(67, 194, 63, 0.25);
            color: #b6ffb4;
        }

        .badge-warning {
            background: rgba(230, 184, 0, 0.25);
            color: #ffe58a;
        }

        .empty-row {
            padding: 30px !important;
            color: #d6d6e7 !important;
        }

        @media(max-width: 900px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .wrapper {
                flex-direction: column;
            }

            .main {
                margin-left: 0;
                width: 100%;
                padding: 30px 20px;
            }

            .toolbar {
                grid-template-columns: 1fr;
            }

            .card {
                overflow-x: auto;
            }

            .table {
                min-width: 900px;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <aside class="sidebar">
        <div>
            <div class="profile">
                <div class="avatar">👨‍🏫</div>
                <div>
                    <div class="profile-name">{{ Auth::user()->nama ?? Auth::user()->name ?? 'Guru' }}</div>
                    <div class="profile-role">Teacher</div>
                </div>
            </div>

            <nav class="menu">
                <a href="{{ route('guru.dashboard') }}" class="menu-item">
                    <div class="menu-icon yellow">👤</div>
                    <span>Dashboard Guru</span>
                </a>

                 <a href="{{ route('guru.siswa.index') }}" class="menu-item {{ request()->routeIs('guru.siswa.*') ? 'active' : '' }}">
        <div class="menu-icon red">👔</div>
        <span>Data Siswa</span>
    </a>


                <a href="{{ route('guru.tempat_magang') }}" class="menu-item active">
                    <div class="menu-icon purple">🏢</div>
                    <span>Data Pemilihan PKL</span>
                </a>

                <a href="{{ route('guru.jurusan_kuliah') }}" class="menu-item">
    <div class="menu-icon green">🏫</div>
    <span>Data Pemilihan Prodi</span>
</a>
            </nav>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Log out</button>
        </form>
    </aside>

    <main class="main">
        <h1 class="title">Data Pemilihan PKL</h1>

        <section class="card">
            <div class="toolbar">
                <input type="text" id="searchInput" class="input" placeholder="🔍 Cari nama tempat magang / bidang">

                <select id="bidangFilter" class="select">
                    <option value="">Semua Bidang</option>

                    @foreach($tempatMagang->pluck('bidang')->filter()->unique() as $bidang)
                        <option value="{{ $bidang }}">{{ $bidang }}</option>
                    @endforeach
                </select>
            </div>

            <table class="table" id="magangTable">
                <thead>
                    <tr>
                        <th style="width: 70px;">No.</th>
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
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $nama }}</td>
                            <td>{{ $bidang }}</td>
                            <td>
                                @if($kuota > 0)
                                    <span class="badge badge-success">{{ $kuota }} Kuota</span>
                                @else
                                    <span class="badge badge-warning">Tidak Tersedia</span>
                                @endif
                            </td>
                            <td>{{ $kontak }}</td>
                            <td class="text-left">
                                {{ \Illuminate\Support\Str::limit($deskripsi, 80) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-row">Belum ada data tempat magang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const bidangFilter = document.getElementById('bidangFilter');
    const rows = document.querySelectorAll('#magangTable tbody tr');

    function filterTable() {
        const search = searchInput.value.toLowerCase();
        const bidangValue = bidangFilter.value.toLowerCase();

        rows.forEach(row => {
            const nama = row.dataset.nama || '';
            const bidang = row.dataset.bidang || '';

            const matchSearch = nama.includes(search) || bidang.includes(search);
            const matchBidang = bidangValue === '' || bidang === bidangValue;

            row.style.display = matchSearch && matchBidang ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    bidangFilter.addEventListener('change', filterTable);
</script>

</body>
</html>