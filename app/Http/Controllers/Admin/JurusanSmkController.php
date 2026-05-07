<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurusanKuliah;
use App\Models\JurusanSmk;
use App\Models\Kriteria;
use App\Models\SkorJurusan;
use App\Models\Skill;
use Illuminate\Http\Request;

class JurusanSmkController extends Controller
{
    public function index()
    {
        $jurusan = JurusanSmk::with('skills')->latest()->paginate(10);
        return view('admin.jurusan_smk.index', compact('jurusan'));
    }

    public function create()
    {
        $skills = Skill::all();
        return view('admin.jurusan_smk.create', compact('skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'skill_ids' => 'required|array',
            'skill_ids.*' => 'exists:skill,id',
        ]);

        $jurusan = JurusanSmk::create($request->only([
            'nama_jurusan',
        ]));

        $jurusan->skills()->attach($request->skill_ids);

        return redirect()->route('admin.jurusan_smk.index')->with('success', 'Jurusan SMK berhasil ditambahkan.');
    }


    public function edit(string $id)
    {
        $jurusan = JurusanSmk::with('skills')->findOrFail($id);
        $skills = Skill::all();
        $selectedSkills = $jurusan->skills->pluck('id')->toArray();
        return view('admin.jurusan_smk.edit', compact('jurusan', 'skills', 'selectedSkills'));
    }

    public function update(Request $request, string $id)
    {
        $jurusan = JurusanSmk::findOrFail($id);

        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'skill_ids' => 'required|array',
            'skill_ids.*' => 'exists:skill,id',
        ]);

        $jurusan->update($request->only([
            'nama_jurusan',
        ]));

        $jurusan->skills()->sync($request->skill_ids);

        return redirect()->route('admin.jurusan_smk.index')->with('success', 'Jurusan SMK berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        JurusanSmk::findOrFail($id)->delete();

        return redirect()->route('admin.jurusan_smk.index')
            ->with('success', 'Jurusan SMK berhasil dihapus.');
    }
}
