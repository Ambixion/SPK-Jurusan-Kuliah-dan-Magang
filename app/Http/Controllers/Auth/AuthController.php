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

    public function login(Request $request)
    {
        $credentials = $request->validate([
            // // 'nama'     => ['required', 'string'],
            // 'email'    => ['required', 'email'],
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nama';
        $credentials = [
            $fieldType => $request->login,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return match (Auth::user()->role) {
                'admin' => redirect()->intended('/admin/dashboard'),
                'guru' => redirect()->intended('/guru/dashboard'),
                'siswa' => redirect()->intended('/siswa/dashboard'),
                default => redirect('/'),
            };
        }

        return back()->withErrors([
            'login' => 'Email atau password salah.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout.');
    }

}
