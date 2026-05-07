<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JurusanSmk;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $jurusans = JurusanSmk::all();
        return view('admin.users.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,guru,siswa',
            'jurusan_smk_id' => 'required_if:role,siswa|nullable|exists:jurusan_smk,id',
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        if ($request->role === 'siswa') {
            Siswa::create([
                'users_id'      => $user->id,
                'jurusan_smk_id' => $request->jurusan_smk_id,
            ]);
        } elseif ($request->role === 'guru') {
            Guru::create([
                'users_id' => $user->id,
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }


    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $jurusans = JurusanSmk::all();
        return view('admin.users.edit', compact('user', 'jurusans'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'password'      => 'nullable|min:6|confirmed',
            'role'          => 'required|in:admin,guru,siswa',
            'jurusan_smk_id' => 'required_if:role,siswa|nullable|exists:jurusan_smk,id',
        ]);

        $user->update([
            'nama'  => $request->nama,
            'email' => $request->email,
            'role'  => $request->role,
            ...($request->filled('password')
                ? ['password' => Hash::make($request->password)]
                : []),
        ]);

        // update profil siswa
        if ($request->role === 'siswa') {
            Siswa::updateOrCreate(
                ['users_id' => $user->id],
                ['jurusan_smk_id' => $request->jurusan_smk_id]
            );
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
