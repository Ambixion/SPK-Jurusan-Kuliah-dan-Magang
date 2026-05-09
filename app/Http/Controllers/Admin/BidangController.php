<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Skill;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::with('skills')->latest()->paginate(10);
        return view('admin.bidang.index', compact('bidangs'));
    }

    public function create()
    {
        $skills = Skill::orderBy('jenis_skill')->get();
        return view('admin.bidang.create', compact('skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255|unique:bidang,nama',
            'deskripsi' => 'nullable|string',
            'skill_ids' => 'nullable|array',
            'skill_ids.*' => 'exists:skill,id',
        ]);

        $bidang = Bidang::create($request->only('nama', 'deskripsi'));

        if ($request->filled('skill_ids')) {
            $bidang->skills()->sync($request->skill_ids);
        }

        return redirect()->route('admin.bidang.index')
            ->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $bidang         = Bidang::with('skills')->findOrFail($id);
        $skills         = Skill::orderBy('jenis_skill')->get();
        $selectedSkills = $bidang->skills->pluck('id')->toArray();
        return view('admin.bidang.edit', compact('bidang', 'skills', 'selectedSkills'));
    }

    public function update(Request $request, string $id)
    {
        $bidang = Bidang::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255|unique:bidang,nama,' . $id,
            'deskripsi' => 'nullable|string',
            'skill_ids' => 'nullable|array',
            'skill_ids.*' => 'exists:skill,id',
        ]);

        $bidang->update($request->only('nama', 'deskripsi'));
        $bidang->skills()->sync($request->skill_ids ?? []);

        return redirect()->route('admin.bidang.index')
            ->with('success', 'Bidang berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $bidang = Bidang::findOrFail($id);

        if ($bidang->jurusanKuliah()->exists() || $bidang->jurusanSmk()->exists() || $bidang->tempatMagang()->exists()) {
            return back()->with('error', 'Bidang tidak bisa dihapus karena masih digunakan.');
        }

        $bidang->delete();
        return redirect()->route('admin.bidang.index')
            ->with('success', 'Bidang berhasil dihapus.');
    }
}
