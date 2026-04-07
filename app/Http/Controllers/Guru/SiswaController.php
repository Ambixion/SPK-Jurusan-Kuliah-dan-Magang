<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index() {
        $siswas = Siswa::with('user')->latest()->paginate(10);
        return view('guru.siswa.index', compact('siswas'));
    }

    public function create() {
        return view('guru.siswa.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'jurusan_siswa' => 'required|string|max:255',
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        Siswa::create([
            'users_id' => $user->id,
            'jurusan_siswa' => $request->jurusan_siswa,
        ]);

        return redirect()->route('guru.nilai.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(string $id) {
        $siswa = Siswa::with(['user', 'nilaiSiswa', 'skorSiswa.kriteria'])->findOrFail($id);
        $hasilJurusan = HasilJurusan::with('jurusan')->where('siswa_id', $id)->orderBy('rank')->get();
        $hasilMagang = HasilMagang::with('tempatMagang')->where('siswa_id', $id)->orderBy('rank')->get();

        return view('guru.siswa.show', compact('siswa', 'hasilJurusan', 'hasilMagang'));
    }

    public function edit(string $id) {
        $siswa = Siswa::with('user')->findOrFail($id);
        return view('guru.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, string $id) {
        $siswa = Siswa::with('user')->findOrFail($id);

        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $siswa->users_id,
            'jurusan_siswa' => 'required|string|max:255',
        ]);

        $siswa->user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        $siswa->update([
            'jurusan_siswa' => $request->jurusan_siswa,
        ]);

        return redirect()->route('guru.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(string $id) {
        $siswa = Siswa::with('user')->findOrFail($id);
        $siswa->user->delete(); //cascade delete siswa juga

        return redirect()->route('guru.nilai.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
