<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\JurusanKuliah;
use App\Models\TempatMagang;
use App\Models\Kriteria;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_siswa' => Siswa::count(),
            'total_guru' => Guru::count(),
            'total_jurusan' => JurusanKuliah::count(),
            'total_tempat_magang' => TempatMagang::count(),
            'total_kriteria' => Kriteria::count(),
        ];

        return view('admin.dashboard', $stats);
    }
}
