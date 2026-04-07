<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index() {
        $data = [
            'total_siswa' => Siswa::count(),
            'siswa_sudah_mengisi' => Siswa::whereHas('nilaiSiswa')->count(),
            'siswa_belum_mengisi' => Siswa::whereDoesntHave('nilaiSiswa')->count(),
        ];

        $siswaTerbaru = Siswa::with('user')->latest()->take(5)->get();

        return view('guru.dashboard', compact('data', 'siswaTerbaru'));
    }
}
