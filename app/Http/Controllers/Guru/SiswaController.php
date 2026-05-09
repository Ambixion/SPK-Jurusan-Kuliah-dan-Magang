<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\JurusanSmk;
use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
{
    $jurusanSmk = JurusanSmk::orderBy('nama_jurusan', 'asc')->get();

    return view('guru.siswa.index', compact('jurusanSmk'));
}

    public function create()
{
    return redirect()->route('guru.siswa.index');
}

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'jurusan_smk_id' => 'required|exists:jurusan_smk,id',
        'nisn' => 'nullable|string|max:20|unique:siswa,nisn',
        'kelas' => 'nullable|string|max:50',
    ]);

    $user = User::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make('smkn5jember'),
        'role' => 'siswa',
    ]);

    Siswa::create([
        'users_id' => $user->id,
        'jurusan_smk_id' => $request->jurusan_smk_id,
        'nisn' => $request->nisn,
        'kelas' => $request->kelas,
    ]);

    return redirect()
        ->route('guru.dashboard')
        ->with('success', 'Data siswa berhasil ditambahkan.');
}

    public function show(string $id)
    {
        $siswa = Siswa::with(['user', 'jurusanSmk', 'nilaiSiswa', 'skorSiswa.kriteria'])
            ->findOrFail($id);

        $hasilJurusan = HasilJurusan::with('jurusan')
            ->where('siswa_id', $id)
            ->orderBy('rank', 'asc')
            ->get();

        $hasilMagang = HasilMagang::with('tempatMagang')
            ->where('siswa_id', $id)
            ->orderBy('rank', 'asc')
            ->get();

        return view('guru.siswa.show', compact('siswa', 'hasilJurusan', 'hasilMagang'));
    }

    public function edit(string $id)
    {
        $siswa = Siswa::with(['user', 'jurusanSmk'])->findOrFail($id);

        $jurusanSmk = JurusanSmk::orderBy('nama_jurusan', 'asc')->get();

        return view('guru.siswa.edit', compact('siswa', 'jurusanSmk'));
    }

    public function update(Request $request, string $id)
{
    $siswa = Siswa::with('user')->findOrFail($id);

    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $siswa->users_id,
        'nisn' => 'nullable|string|max:20|unique:siswa,nisn,' . $siswa->id,
        'kelas' => 'required|in:10,11,12',
        'jurusan_smk_id' => 'required|exists:jurusan_smk,id',
    ]);

    $siswa->user->update([
        'nama' => $request->nama,
        'email' => $request->email,
    ]);

    $siswa->update([
        'nisn' => $request->nisn,
        'kelas' => $request->kelas,
        'jurusan_smk_id' => $request->jurusan_smk_id,
    ]);

    return redirect()
        ->route('guru.dashboard')
        ->with('success', 'Data siswa berhasil diperbarui.');
}

    public function destroy(string $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        $siswa->user->delete();

        return redirect()
            ->route('guru.dashboard')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}