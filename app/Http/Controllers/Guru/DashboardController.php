<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\TempatMagang;
use App\Models\JurusanKuliah;
use App\Models\JurusanSmk;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_siswa' => Siswa::count(),
            'total_tempat_magang' => TempatMagang::count(),
            'total_prodi_kuliah' => JurusanKuliah::count(),

            'siswa_sudah_pilih_prodi' => Siswa::whereHas('hasilJurusan')->count(),
            'siswa_sudah_pilih_magang' => Siswa::whereHas('hasilMagang')->count(),

            'siswa_belum_pilih_prodi' => Siswa::whereDoesntHave('hasilJurusan')->count(),
            'siswa_belum_pilih_magang' => Siswa::whereDoesntHave('hasilMagang')->count(),
        ];

        $siswaTerbaru = Siswa::with(['user', 'jurusanSmk', 'hasilJurusan', 'hasilMagang'])
            ->latest()
            ->take(10)
            ->get();

        $hasilSpk = Siswa::with([
            'user',
            'jurusanSmk',
            'hasilJurusan',
            'hasilMagang.tempatMagang',
        ])
        ->latest()
        ->take(10)
        ->get();

        $jurusanSmk = JurusanSmk::orderBy('nama_jurusan', 'asc')->get();

        return view('guru.dashboard', compact('data', 'siswaTerbaru', 'hasilSpk', 'jurusanSmk'));
    }
    
}