<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa) {
            abort(403, 'Data siswa tidak ditemukan.');
        }

        // Hitung nilai rata-rata lewat relasi (bukan DB::table langsung)
        $nilaiRata = round($siswa->nilaiSiswa()->avg('nilai')??0,2);

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

        return view('siswa.dashboard.index', compact(
            'siswa',
            'hasilJurusan',
            'hasilMagang',
            'sudahMengisiKuisoner',
            'nilaiRata'
        ));
    }
}
