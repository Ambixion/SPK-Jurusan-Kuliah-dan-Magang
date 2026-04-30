<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\NilaiSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Psy\Util\Str;

class NilaiController extends Controller
{
    public function index() {
        $nilais = NilaiSiswa::with(['siswa_user'])->latest()->paginate(10);
        return view('guru.nilai.index', compact('nilais'));
    }

    public function create() {
        $siswas = Siswa::with('user')->get();
        return view('guru.nilai.create', compact('siswas'));
    }

    public function store(Request $request) {
        $request->validate([
            'siswa_id'       => 'required|exists:siswa,id',
            'mata_pelajaran' => 'required|string|max:255',
            'nilai'          => 'required|numeric|min:0|max:100',
            'semester'       => 'required|integer|min:1|max:12',
            'tahun_ajaran'   => 'required|integer|min:2000|max:2100',
        ]);

        NilaiSiswa::create($request->only([
            'siswa_id', 'mata_pelajaran', 'nilai', 'semester', 'tahun_ajaran'
        ]));

        return redirect()->route('guru.nilai.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function show(string $id) {
        $nilai = NilaiSiswa::with(['siswa.user'])->findOrFail($id);
        return view('guru.nilai.show', compact('nilai'));
    }

    public function edit(string $id) {
        $nilai = NilaiSiswa::findOrFail($id);
        $siswas = Siswa::with('user')->get();
        return view('guru.nilai.edit', compact('nilai', 'siswas'));
    }

    public function update(Request $request, string $id) {
        $nilai = NilaiSiswa::findOrFail($id);

        $request->validate([
            'siswa_id'       => 'required|exists:siswa,id',
            'mata_pelajaran' => 'required|string|max:255',
            'nilai'          => 'required|numeric|min:0|max:100',
            'semester'       => 'required|integer|min:1|max:12',
            'tahun_ajaran'   => 'required|integer|min:2000|max:2100',
        ]);

        $nilai->update($request->only([
            'siswa_id', 'mata_pelajaran', 'nilai', 'semester', 'tahun_ajaran'
        ]));

        return redirect()->route('guru.nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(string $id) {
        NilaiSiswa::findOrFail($id)->delete();

        return redirect()->route('guru.nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }
}
