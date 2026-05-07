<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TempatMagang;
use App\Models\Kriteria;
use App\Models\Skill;
use App\Models\SkorMagang;
use Illuminate\Http\Request;

class TempatMagangController extends Controller
{
    public function index()
    {
        $tempatMagang = TempatMagang::with('skills')->latest()->paginate(10);
        return view('admin.tempat_magang.index', compact('tempatMagang'));
    }

    public function create()
    {
        $kriterias = Kriteria::where('jenis', 'magang')->get();
        $skills = Skill::all();
        return view('admin.tempat_magang.create', compact('kriterias', 'skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'skill_ids'    => 'required|array',
            'skill_ids.*' => 'required|exists:skill,id',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'bidang'      => 'required|string|max:255',
            'kuota'       => 'required|integer|min:1',
            'kontak'      => 'required|string|max:255',
            'skor'        => 'nullable|array',
            'skor.*'      => 'nullable|integer|min:0|max:100',
        ]);

        $tempat = TempatMagang::create($request->only([
            'nama', 'deskripsi', 'latitude', 'longitude', 'bidang', 'kuota', 'kontak'
        ]));

        $tempat->skills()->attach($request->skill_ids);

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



    public function edit(string $id)
    {
        $tempat    = TempatMagang::with('skorMagang', 'skills')->findOrFail($id);
        $kriterias = Kriteria::where('jenis', 'magang')->get();
        $skills = Skill::all();
        $skorExisting = $tempat->skorMagang->pluck('score', 'kriteria_id');
        $selectedSkills = $tempat->skills->pluck('id')->toArray();

        return view('admin.tempat_magang.edit', compact('tempat', 'kriterias', 'skills', 'skorExisting', 'selectedSkills'));
    }

    public function update(Request $request, string $id)
    {
        $tempat = TempatMagang::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'skill_ids'    => 'required|array',
            'skill_ids.*' => 'required|exists:skill,id',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'bidang'      => 'required|string|max:255',
            'kuota'       => 'required|integer|min:1',
            'kontak'      => 'nullable|string|max:255',
            'skor'        => 'nullable|array',
            'skor.*'      => 'nullable|integer|min:0|max:100',
        ]);

        $tempat->update($request->only([
            'nama', 'deskripsi', 'latitude', 'longitude', 'bidang', 'kuota', 'kontak'
        ]));

        $tempat->skills()->sync($request->skill_ids);

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
