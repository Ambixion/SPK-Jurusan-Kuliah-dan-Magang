<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurusanKuliah;
use App\Models\Kriteria;
use App\Models\SkorJurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index() {
        $jurusan = JurusanKuliah::latest()->paginate(10);
        return view('admin.jurusan.index', compact('jurusan'));
    }

    public function create() {
        $kriterias = Kriteria::where('jenis', 'jurusan')->get();
        return view('admin.jurusan.create', compact('kriterias'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'bidang_studi'=> 'required|string|max:255',
            'skor'        => 'nullable|array',
            'skor.*'      => 'nullable|integer|min:0|max:100',
        ]);

        $jurusan = JurusanKuliah::create($request->only([
            'nama', 'deskripsi', 'bidang_studi'
        ]));

        //simpan skor pre kriteria
        if ($request->filled('skor')) {
            foreach ($request->skor as $kriteria_id => $score) {
                SkorJurusan::updateOrCreate(
                    ['jurusan_kuliah_id' => $jurusan->id, 'kriteria_id' => $kriteria_id],
                    ['score' => $score]
                );
            }
        }

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function show(string $id) {
        $jurusan = JurusanKuliah::with(['skorJurusan.kriteria'])->findOrFail($id);
        return view('admin.jurusan.show', compact('jurusan'));
    }

    public function edit(string $id) {
        $jurusan = JurusanKuliah::with('skorJurusan')->findOrFail($id);
        $kriterias = Kriteria::where('jenis', 'jurusan')->get();

        //map skor yang sudah ada yaitu kriteria_id -> score
        $skorExisting = $jurusan->skorJurusan->pluck('score', 'kriteria_id');
        return view('admin.jurusan.edit', compact('jurusan', 'kriterias', 'skorExisting'));
    }

    public function update(Request $request, string $id) {
        $jurusan = JurusanKuliah::findOrFail($id);

        $request->validate([
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'bidang_studi'=> 'required|string|max:255',
            'skor'        => 'nullable|array',
            'skor.*'      => 'nullable|integer|min:0|max:100',
        ]);

        $jurusan->update($request->only([
            'nama', 'deskripsi', 'bidang_studi'
        ]));

        if ($request->filled('skor')) {
            foreach ($request->skor as $kriteria_id => $score) {
                SkorJurusan::updateOrCreate(
                  ['jurusan_kuliah_id' => $jurusan->id, 'kriteria_id' => $kriteria_id],
                  ['score' => $score]
                );
            }
        }

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(string $id) {
        JurusanKuliah::findOrFail($id)->delete();

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}
