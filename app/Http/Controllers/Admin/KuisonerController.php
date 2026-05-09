<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\JurusanKuliah;
use App\Models\Kriteria;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use Illuminate\Http\Request;

class KuisonerController extends Controller
{
    public function index()
    {
        $kuisoner = Kuisoner::with(['opsi', 'jurusanKuliah', 'bidang', 'kriteria'])
            ->orderBy('type')
            ->orderBy('jurusan_kuliah_id')
            ->orderBy('urutan')
            ->paginate(15);
        return view('admin.kuisoner.index', compact('kuisoner'));
    }

    public function create()
    {
        $jurusans  = JurusanKuliah::orderBy('nama')->get();
        $bidangs   = Bidang::orderBy('nama')->get();
        $kriterias = Kriteria::orderBy('jenis')->orderBy('nama')->get();
        return view('admin.kuisoner.create', compact('jurusans', 'bidangs', 'kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'soal'              => 'required|string|max:500',
            'type'              => 'required|in:jurusan,magang',
            'jurusan_kuliah_id' => 'nullable|exists:jurusan_kuliah,id',
            'bidang_id'         => 'nullable|exists:bidang,id',
            'kriteria_id'       => 'nullable|exists:kriteria,id',
            'urutan'            => 'nullable|integer|min:0',
            'opsi'              => 'required|array|min:2',
            'opsi.*.jawaban'    => 'required|string|max:255',
            'opsi.*.nilai'      => 'required|integer|min:0|max:10',
        ]);

        $kuisoner = Kuisoner::create([
            'soal'              => $request->soal,
            'type'              => $request->type,
            'jurusan_kuliah_id' => $request->jurusan_kuliah_id,
            'bidang_id'         => $request->bidang_id,
            'kriteria_id'       => $request->kriteria_id,
            'urutan'            => $request->urutan ?? 0,
        ]);

        foreach ($request->opsi as $opsi) {
            if (!empty($opsi['jawaban'])) {
                KuisonerOpsi::create([
                    'kuisoner_id' => $kuisoner->id,
                    'jawaban'     => $opsi['jawaban'],
                    'nilai'       => $opsi['nilai'] ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.kuisoner.index')
            ->with('success', 'Kuisoner berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $kuisoner  = Kuisoner::with('opsi')->findOrFail($id);
        $jurusans  = JurusanKuliah::orderBy('nama')->get();
        $bidangs   = Bidang::orderBy('nama')->get();
        $kriterias = Kriteria::orderBy('jenis')->orderBy('nama')->get();
        return view('admin.kuisoner.edit', compact('kuisoner', 'jurusans', 'bidangs', 'kriterias'));
    }

    public function update(Request $request, string $id)
    {
        $kuisoner = Kuisoner::findOrFail($id);

        $request->validate([
            'soal'              => 'required|string|max:500',
            'type'              => 'required|in:jurusan,magang',
            'jurusan_kuliah_id' => 'nullable|exists:jurusan_kuliah,id',
            'bidang_id'         => 'nullable|exists:bidang,id',
            'kriteria_id'       => 'nullable|exists:kriteria,id',
            'urutan'            => 'nullable|integer|min:0',
            'opsi'              => 'required|array|min:2',
            'opsi.*.jawaban'    => 'required|string|max:255',
            'opsi.*.nilai'      => 'required|integer|min:0|max:10',
        ]);

        $kuisoner->update([
            'soal'              => $request->soal,
            'type'              => $request->type,
            'jurusan_kuliah_id' => $request->jurusan_kuliah_id,
            'bidang_id'         => $request->bidang_id,
            'kriteria_id'       => $request->kriteria_id,
            'urutan'            => $request->urutan ?? 0,
        ]);

        $kuisoner->opsi()->delete();
        foreach ($request->opsi as $opsi) {
            if (!empty($opsi['jawaban'])) {
                KuisonerOpsi::create([
                    'kuisoner_id' => $kuisoner->id,
                    'jawaban'     => $opsi['jawaban'],
                    'nilai'       => $opsi['nilai'] ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.kuisoner.index')
            ->with('success', 'Kuisoner berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kuisoner = Kuisoner::findOrFail($id);
        $kuisoner->opsi()->delete();
        $kuisoner->delete();
        return redirect()->route('admin.kuisoner.index')
            ->with('success', 'Kuisoner berhasil dihapus.');
    }

    // API endpoint: ambil kuisoner berdasarkan jurusan & bidang (untuk form siswa)
    public function getByFilter(Request $request)
    {
        $query = Kuisoner::with('opsi')
            ->where('type', $request->type ?? 'jurusan')
            ->orderBy('urutan');

        if ($request->jurusan_kuliah_id) {
            $query->where(function ($q) use ($request) {
                $q->where('jurusan_kuliah_id', $request->jurusan_kuliah_id)
                  ->orWhereNull('jurusan_kuliah_id');
            });
        }

        if ($request->bidang_id) {
            $query->where(function ($q) use ($request) {
                $q->where('bidang_id', $request->bidang_id)
                  ->orWhereNull('bidang_id');
            });
        }

        return response()->json($query->get());
    }
}
