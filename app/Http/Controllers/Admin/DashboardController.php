<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JurusanKuliah;
use App\Models\Kriteria;
use App\Models\Siswa;
use App\Models\TempatMagang;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {
        $data = [
            'total_siswa' => Siswa::count(),
            'total_guru' => Guru::count(),
            'total_jurusan' => JurusanKuliah::count(),
            'total_tempat_magang' => TempatMagang::count(),
            'total_kriteria' => Kriteria::count(),
            'total_user' => User::count(),
        ];

        return view('admin.dashboard', compact('data'));
    }
}
