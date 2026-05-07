<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index() {
        $kriterias = Kriteria::latest()->paginate(10);
        return view('admin.kriteria.index', compact('kriterias'));
    }

    public function create() {
        return view('admin.kriteria.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'weight' => 'required|numeric|min:0|max:1',
            'type'   => 'required|in:benefit,cost',
            'jenis'  => 'required|in:jurusan,magang',
        ]);

        $totalBobot = Kriteria::where('jenis', $request->jenis)->sum('weight');
        if (($totalBobot + $request->weight) > 1.001) {
            return back()->withErrors([
                'weight' => 'Total bobot kriteria ' . $request->jenis . ' tidak boleh melebihi 1. Sisa bobot tersedia: ' . round(1 - $totalBobot, 3),
            ])->withInput();
        }

        Kriteria::create($request->only(['nama', 'weight', 'type', 'jenis']));
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }


    public function edit(string $id) {
        $kriteria = Kriteria::findOrFail($id);
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, string $id) {
        $kriteria = Kriteria::findOrFail($id);

        $request->validate([
            'nama'   => 'required|string|max:255',
            'weight' => 'required|numeric|min:0|max:1',
            'type'   => 'required|in:benefit,cost',
            'jenis'  => 'required|in:jurusan,magang',
        ]);

        $totalBobot = Kriteria::where('jenis', $request->jenis)->where('id', '!=', $id)->sum('weight');
        if (($totalBobot + $request->weight) > 1.001) {
            return back()->withErrors([
                'weight' => 'Total bobot kriteria ' . $request->jenis . ' tidak boleh melebihi 1. Sisa bobot tersedia: ' . round(1 - $totalBobot, 3),
            ])->withInput();
        }

        $kriteria->update($request->only(['nama', 'weight', 'type', 'jenis']));
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(string $id){
        Kriteria::findOrFail($id)->delete();
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
