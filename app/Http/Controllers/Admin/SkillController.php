<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::latest()->paginate(10);
        return view('admin.skill.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skill.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_skill' => 'required|string|max:255|unique:skill,jenis_skill',
        ]);

        Skill::create($request->only('jenis_skill'));

        return redirect()->route('admin.skill.index')
            ->with('success', 'Skill berhasil ditambahkan.');
    }



    public function edit(string $id)
    {
        $skill = Skill::findOrFail($id);
        return view('admin.skill.edit', compact('skill'));
    }

    public function update(Request $request, string $id)
    {
        $skill = Skill::findOrFail($id);

        $request->validate([
            'jenis_skill' => 'required|string|max:255|unique:skill,jenis_skill,' . $id,
        ]);

        $skill->update($request->only('jenis_skill'));

        return redirect()->route('admin.skill.index')
            ->with('success', 'Skill berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $skill = Skill::findOrFail($id);

        // Check if skill is used
        if ($skill->tempatMagang()->exists() || $skill->jurusanSmk()->exists()) {
            return back()->with('error', 'Skill tidak bisa dihapus karena masih digunakan.');
        }

        $skill->delete();

        return redirect()->route('admin.skill.index')
            ->with('success', 'Skill berhasil dihapus.');
    }
}
