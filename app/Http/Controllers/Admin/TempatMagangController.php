<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TempatMagang;
use App\Models\Kriteria;
use App\Models\SkorMagang;
use Illuminate\Http\Request;

class TempatMagangController extends Controller
{
    public function index()
    {
        $tempatMagang = TempatMagang::latest()->paginate(10);
        return view('admin.tempat_magang.index', compact('tempatMagang'));
    }

    public function create()
    {
        $kriterias = Kriteria::where('jenis', 'magang')->get();
        return view('admin.tempat_magang.create', compact('kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi'    => 'required|string|max:255',
            'kuota'     => 'required|integer|min:1',
            'kontak'    => 'required|string|max:255',
            'skor'      => 'nullable|array',
            'skor.*'    => 'nullable|integer|min:0|max:100',
        ]);

        $tempat = TempatMagang::create($request->only([
            'nama', 'deskripsi', 'lokasi', 'kuota', 'kontak'
        ]));

        if ($request->filled('skor')) {
            foreach ($request->skor as $kriteria_id => $score) {
                SkorMagang::updateOrCreate(
                    ['tempat_magang_id' => $tempat->id, 'kriteria_id' => $kriteria_id],
                    ['score' => $score]
                );
            }
        }

        return redirect()->route('admin.tempat_magang.index')
            ->with('success', 'Tempat magang berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $tempat = TempatMagang::with(['skorMagang.kriteria'])->findOrFail($id);
        return view('admin.tempat_magang.show', compact('tempat'));
    }

    public function edit(string $id)
    {
        $tempat    = TempatMagang::with('skorMagang')->findOrFail($id);
        $kriterias = Kriteria::where('jenis', 'magang')->get();
        $skorExisting = $tempat->skorMagang->pluck('score', 'kriteria_id');

        return view('admin.tempat_magang.edit', compact('tempat', 'kriterias', 'skorExisting'));
    }

    public function update(Request $request, string $id)
    {
        $tempat = TempatMagang::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi'    => 'required|string|max:255',
            'kuota'     => 'required|integer|min:1',
            'kontak'    => 'required|string|max:255',
            'skor'      => 'nullable|array',
            'skor.*'    => 'nullable|integer|min:0|max:100',
        ]);

        $tempat->update($request->only([
            'nama', 'deskripsi', 'lokasi', 'kuota', 'kontak'
        ]));

        if ($request->filled('skor')) {
            foreach ($request->skor as $kriteria_id => $score) {
                SkorMagang::updateOrCreate(
                    ['tempat_magang_id' => $tempat->id, 'kriteria_id' => $kriteria_id],
                    ['score' => $score]
                );
            }
        }

        return redirect()->route('admin.tempat_magang.index')
            ->with('success', 'Tempat magang berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        TempatMagang::findOrFail($id)->delete();

        return redirect()->route('admin.tempat_magang.index')
            ->with('success', 'Tempat magang berhasil dihapus.');
    }
}
