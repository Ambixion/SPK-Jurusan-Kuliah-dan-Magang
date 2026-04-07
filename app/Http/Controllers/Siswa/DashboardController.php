<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $siswa = Auth::user()->siswa;

        $hasilJurusan = HasilJurusan::with('jurusan')
        ->where('siswa_id', $siswa->id)
        ->orderBy('rank')
        ->take(3)
        ->get();

        $hasilMagang = HasilMagang::with('tempatMagang')
        ->where('siswa_id', $siswa->id)
        ->orderBy('rank')
        ->take(3)
        ->get();

        $sudahMengisiKuisoner = $siswa->jawabanSiswa()->exists();

        return view('siswa.dashboard', compact('siswa', 'hasilJurusan', 'hasilMagang', 'sudahMengisiKuisoner'));
    }
}
