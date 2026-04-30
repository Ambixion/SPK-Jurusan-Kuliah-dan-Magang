<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
<<<<<<< HEAD
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
=======

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
>>>>>>> 10b9d9ef1c922cab32de5a45e3f7005c2ccef2b9
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return match (Auth::user()->role) {
<<<<<<< HEAD
                'admin' => redirect()->route('admin.dashboard'),
                'guru' => redirect()->route('guru.dashboard'),
                'siswa' => redirect()->route('siswa.dashboard'),
                default => redirect('/login')->withErrors(['role' => 'Role tidak valid']),
=======
                'admin' => redirect()->intended('/admin/dashboard'),
                'guru'  => redirect()->intended('/guru/dashboard'),
                'siswa' => redirect()->intended('/siswa/dashboard'),
                default => redirect('/'),
>>>>>>> 10b9d9ef1c922cab32de5a45e3f7005c2ccef2b9
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
