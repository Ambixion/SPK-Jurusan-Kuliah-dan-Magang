<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use Illuminate\Support\Facades\Auth;

class HasilController extends Controller
{
    public function index() {
        $siswa = Auth::user()->siswa;

        if (!$siswa->jawabanSiswa()->exists()) {
            return redirect()->route('siswa.kuisoner')->with('info', 'Silahkan isi kuisoner terlebih dahulu untuk melihat hasil rekomendasi.');

        }

        $hasilJurusan = HasilJurusan::with('jurusan')
        ->where('siswa_id', $siswa->id)
        ->orderBy('rank')
        ->get();

        $hasilMagang = HasilMagang::with('tempatMagang')
        ->where('siswa_id', $siswa->id)
        ->orderBy('rank')
        ->get();

        return view('siswa.hasil.index', compact('hasilJurusan', 'hasilMagang', 'siswa'));
    }
}
