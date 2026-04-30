<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
<<<<<<< HEAD
=======
use App\Models\Siswa;
use App\Models\Guru;
>>>>>>> 10b9d9ef1c922cab32de5a45e3f7005c2ccef2b9
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
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
<<<<<<< HEAD
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,guru,siswa',
        ]);

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'role'  => 'required|in:admin,guru,siswa',
        ]);

        $user->update([
            'nama'  => $request->nama,
            'email' => $request->email,
            'role'  => $request->role,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
=======
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,guru,siswa',
            // field tambahan siswa
            'jurusan_siswa' => 'required_if:role,siswa|nullable|string|max:255',
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
                'jurusan_siswa' => $request->jurusan_siswa,
            ]);
        } elseif ($request->role === 'guru') {
            Guru::create([
                'users_id' => $user->id,
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'password'      => 'nullable|min:6|confirmed',
            'role'          => 'required|in:admin,guru,siswa',
            'jurusan_siswa' => 'required_if:role,siswa|nullable|string|max:255',
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
                ['jurusan_siswa' => $request->jurusan_siswa]
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
>>>>>>> 10b9d9ef1c922cab32de5a45e3f7005c2ccef2b9
    }
}
