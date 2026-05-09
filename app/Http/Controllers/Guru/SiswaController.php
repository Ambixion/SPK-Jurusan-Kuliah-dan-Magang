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
        $siswas = Siswa::with(['user', 'jurusanSmk'])->latest()->paginate(10);
        return view('guru.siswa.index', compact('siswas'));
    }

    public function create()
    {
        $jurusanList = JurusanSmk::orderBy('nama_jurusan')->get();
        return view('guru.siswa.create', compact('jurusanList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:6',
            'jurusan_smk_id' => 'required|exists:jurusan_smk,id',
            'kelas'          => 'nullable|string|max:20',
            'semester'       => 'nullable|integer|min:1|max:6',
            'no_telp'        => 'nullable|string|max:20',
            'alamat'         => 'nullable|string',
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        Siswa::create([
            'users_id'       => $user->id,
            'jurusan_smk_id' => $request->jurusan_smk_id,
            'kelas'          => $request->kelas,
            'semester'       => $request->semester,
            'no_telp'        => $request->no_telp,
            'alamat'         => $request->alamat,
        ]);

        return redirect()->route('guru.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $siswa = Siswa::with(['user', 'jurusanSmk', 'nilaiSiswa', 'skorSiswa.kriteria'])->findOrFail($id);
        $hasilJurusan = HasilJurusan::with('jurusan')->where('siswa_id', $id)->orderBy('rank')->get();
        $hasilMagang  = HasilMagang::with('tempatMagang')->where('siswa_id', $id)->orderBy('rank')->get();

        return view('guru.siswa.show', compact('siswa', 'hasilJurusan', 'hasilMagang'));
    }

    public function edit(string $id)
    {
        $siswa       = Siswa::with(['user', 'jurusanSmk'])->findOrFail($id);
        $jurusanList = JurusanSmk::orderBy('nama_jurusan')->get();
        return view('guru.siswa.edit', compact('siswa', 'jurusanList'));
    }

    public function update(Request $request, string $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        $request->validate([
            'nama'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $siswa->users_id,
            'jurusan_smk_id' => 'required|exists:jurusan_smk,id',
            'kelas'          => 'nullable|string|max:20',
            'semester'       => 'nullable|integer|min:1|max:6',
            'no_telp'        => 'nullable|string|max:20',
            'alamat'         => 'nullable|string',
        ]);

        $siswa->user->update([
            'nama'  => $request->nama,
            'email' => $request->email,
        ]);

        $siswa->update([
            'jurusan_smk_id' => $request->jurusan_smk_id,
            'kelas'          => $request->kelas,
            'semester'       => $request->semester,
            'no_telp'        => $request->no_telp,
            'alamat'         => $request->alamat,
        ]);

        return redirect()->route('guru.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        $siswa->user->delete(); // cascade delete siswa juga

        return redirect()->route('guru.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
