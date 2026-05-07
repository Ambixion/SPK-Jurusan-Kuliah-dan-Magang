<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use Illuminate\Http\Request;

class KuisonerController extends Controller
{
    public function index()
    {
        $kuisoner = Kuisoner::with('opsi')->latest()->paginate(10);
        return view('admin.kuisoner.index', compact('kuisoner'));
    }

    public function create()
    {
        return view('admin.kuisoner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'soal'   => 'required|string|max:500',
            'type'   => 'required|in:jurusan,magang',
            'opsi'   => 'required|array|min:1',
            'opsi.*.jawaban' => 'required|string|max:255',
            'opsi.*.nilai'   => 'required|integer|min:0',
        ]);

        $kuisoner = Kuisoner::create($request->only('soal', 'type'));

        // Simpan opsi
        if ($request->filled('opsi')) {
            foreach ($request->opsi as $opsi) {
                if (!empty($opsi['jawaban'])) {
                    KuisonerOpsi::create([
                        'kuisoner_id' => $kuisoner->id,
                        'jawaban' => $opsi['jawaban'],
                        'nilai' => $opsi['nilai'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('admin.kuisoner.index')
            ->with('success', 'Kuisoner berhasil ditambahkan.');
    }


    public function edit(string $id)
    {
        $kuisoner = Kuisoner::with('opsi')->findOrFail($id);
        return view('admin.kuisoner.edit', compact('kuisoner'));
    }

    public function update(Request $request, string $id)
    {
        $kuisoner = Kuisoner::findOrFail($id);

        $request->validate([
            'soal'   => 'required|string|max:500',
            'type'   => 'required|in:jurusan,magang',
            'opsi'   => 'required|array|min:1',
            'opsi.*.jawaban' => 'required|string|max:255',
            'opsi.*.nilai'   => 'required|integer|min:0',
        ]);

        $kuisoner->update($request->only('soal', 'type'));

        // Hapus opsi lama dan buat baru
        $kuisoner->opsi()->delete();

        if ($request->filled('opsi')) {
            foreach ($request->opsi as $opsi) {
                if (!empty($opsi['jawaban'])) {
                    KuisonerOpsi::create([
                        'kuisoner_id' => $kuisoner->id,
                        'jawaban' => $opsi['jawaban'],
                        'nilai' => $opsi['nilai'] ?? 0,
                    ]);
                }
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
}
