<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa</title>

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
        }

        .card {
            background: #242467;
            border-radius: 12px;
            padding: 32px;
            max-width: 880px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group.full {
            grid-column: span 2;
        }

        label {
            display: block;
            margin-bottom: 9px;
            font-weight: 600;
        }

        input,
        select {
            width: 100%;
            height: 50px;
            border: 2px solid rgba(255,255,255,0.12);
            outline: none;
            border-radius: 12px;
            background: #343493;
            color: white;
            padding: 0 18px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }

        input:focus,
        select:focus {
            border-color: #7474ff;
        }

        input::placeholder {
            color: #bdbde7;
        }

        input:disabled {
            opacity: 0.8;
            cursor: not-allowed;
            background: #2b2b72;
        }

        select {
            cursor: pointer;
            appearance: none;
            background-image: linear-gradient(45deg, transparent 50%, #ffffff 50%),
                              linear-gradient(135deg, #ffffff 50%, transparent 50%);
            background-position: calc(100% - 22px) 21px, calc(100% - 16px) 21px;
            background-size: 6px 6px, 6px 6px;
            background-repeat: no-repeat;
        }

        select option {
            background: #242467;
            color: white;
        }

        .help {
            margin-top: 7px;
            font-size: 13px;
            color: #94d1d3;
        }

        .error {
            color: #ffbdbd;
            margin-top: 7px;
            font-size: 13px;
        }

        .alert {
            background: rgba(226, 20, 20, 0.18);
            color: #ffbdbd;
            border: 1px solid rgba(226, 20, 20, 0.35);
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            max-width: 880px;
        }

        .actions {
            display: flex;
            gap: 14px;
            margin-top: 28px;
        }

        .btn {
            border: none;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 22px;
            color: white;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            background: #5656ea;
            transition: 0.2s;
        }

        .btn:hover {
            background: #6a6aff;
        }

        .btn-secondary {
            background: #3b3b78;
        }

        .btn-secondary:hover {
            background: #4d4d96;
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

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: span 1;
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
                    <span>Data Guru</span>
                </a>

                <a href="{{ route('guru.siswa.index') }}" class="menu-item active">
                    <div class="menu-icon red">👔</div>
                    <span>Tambah Data Siswa</span>
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
        <h1 class="title">Tambah Data Siswa</h1>

        @if ($errors->any())
            <div class="alert">
                Data belum valid. Cek kembali input yang kamu isi.
            </div>
        @endif

        <section class="card">
            <form action="{{ route('guru.siswa.store') }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama siswa" required>

                        @error('nama')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email siswa" required>

                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Password Default</label>
                        <input type="text" value="smkn5jember" disabled>
                        <div class="help">Password siswa dibuat otomatis dan tidak bisa diubah dari form ini.</div>
                    </div>

                    <div class="form-group">
                        <label>NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="Masukkan NISN siswa">

                        @error('nisn')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Kelas</label>
                        <select name="kelas" required>
                            <option value="">Pilih Kelas</option>
                            <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>Kelas 10</option>
                            <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>Kelas 11</option>
                            <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>Kelas 12</option>
                        </select>

                        @error('kelas')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Jurusan Siswa</label>
                        <select name="jurusan_smk_id" required>
                            <option value="">Pilih Jurusan</option>

                            @foreach($jurusanSmk as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ old('jurusan_smk_id') == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>

                        @error('jurusan_smk_id')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn">Simpan Data</button>
                    <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </section>
    </main>
</div>

</body>
</html>