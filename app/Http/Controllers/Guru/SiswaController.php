<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\JurusanSmk;
use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use App\Models\NilaiSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
{
    $siswas = Siswa::with([
        'user',
        'jurusanSmk',
        'hasilJurusan.jurusan',
        'hasilMagang.tempatMagang',
        'nilaiSiswa',
    ])
    ->latest()
    ->get();

    $jurusanSmk = JurusanSmk::orderBy('nama_jurusan', 'asc')->get();

    return view('guru.siswa.index', compact('siswas', 'jurusanSmk'));
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
        'nisn' => 'nullable|string|max:20|unique:siswa,nisn',
        'kelas' => 'required|in:10,11,12',
        'semester' => 'required|integer|in:1,2,3,4,5,6',
        'jurusan_smk_id' => 'required|exists:jurusan_smk,id',
         'no_telp' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:500',
        'nilai_rata_rata' => 'required|numeric|min:0|max:100',
    ]);

    $user = User::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make('smkn5jember'),
        'role' => 'siswa',
    ]);

    $siswa = Siswa::create([
        'users_id' => $user->id,
        'jurusan_smk_id' => $request->jurusan_smk_id,
        'nisn' => $request->nisn,
        'kelas' => $request->kelas,
        'semester' => $request->semester,
        'no_telp' => $request->no_telp,
        'alamat' => $request->alamat,
    ]);

    NilaiSiswa::create([
        'siswa_id' => $siswa->id,
        'mata_pelajaran' => 'Rata-rata',
        'nilai' => $request->nilai_rata_rata,
         'semester' => $request->semester,
        'tahun_ajaran' => date('Y'),
    ]);

    return redirect()
        ->route('guru.siswa.index')
        ->with('success', 'Data siswa dan nilai rata-rata berhasil ditambahkan.');
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
        'semester' => 'required|integer|in:1,2,3,4,5,6',
        'jurusan_smk_id' => 'required|exists:jurusan_smk,id',
        'no_telp' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:500',
         'nilai_rata_rata' => 'required|numeric|min:0|max:100',
    ]);

    $siswa->user->update([
        'nama' => $request->nama,
        'email' => $request->email,
    ]);

    $siswa->update([
        'nisn' => $request->nisn,
        'kelas' => $request->kelas,
        'semester' => $request->semester,
        'jurusan_smk_id' => $request->jurusan_smk_id,
        'no_telp' => $request->no_telp,
        'alamat' => $request->alamat,
    ]);

    NilaiSiswa::updateOrCreate(
        [
            'siswa_id' => $siswa->id,
            'mata_pelajaran' => 'Rata-rata',
        ],
        [
            'nilai' => $request->nilai_rata_rata,
            'semester' => $request->semester,
            'tahun_ajaran' => date('Y'),
        ]
    );

    return redirect()
        ->route('guru.siswa.index')
        ->with('success', 'Data siswa berhasil diperbarui.');
}

    public function destroy(string $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        $siswa->user->delete();

        return redirect()
            ->route('guru.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}