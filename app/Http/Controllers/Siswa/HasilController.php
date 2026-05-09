<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HasilController extends Controller
{
    // ── Hasil Pemilihan Jurusan Kuliah ──────────────────────────────────────
    public function jurusan()
    {
        $siswa        = Auth::user()->siswa;
        $nilaiRata    = round(DB::table('nilai_siswa')->where('siswa_id', $siswa->id)->avg('nilai') ?? 0, 2);
        $sudahMengisi = $siswa->jawabanSiswa()->whereHas('opsi.kuisoner', fn($q) => $q->where('type', 'jurusan'))->exists();

        $hasilJurusan = collect();
        if ($sudahMengisi) {
            $hasilJurusan = HasilJurusan::with('jurusan')
                ->where('siswa_id', $siswa->id)
                ->orderBy('rank')->get();
        }

        return view('siswa.hasil.jurusan', compact('siswa', 'nilaiRata', 'hasilJurusan', 'sudahMengisi'));
    }

    // ── Hasil Pemilihan PKL ─────────────────────────────────────────────────
    public function pkl()
    {
        $siswa        = Auth::user()->siswa;
        $nilaiRata    = round(DB::table('nilai_siswa')->where('siswa_id', $siswa->id)->avg('nilai') ?? 0, 2);
        $sudahMengisi = HasilMagang::where('siswa_id', $siswa->id)->exists();

        $hasilMagang = collect();
        if ($sudahMengisi) {
            $hasilMagang = HasilMagang::with('tempatMagang')
                ->where('siswa_id', $siswa->id)
                ->orderBy('rank')->get();
        }

        return view('siswa.hasil.pkl', compact('siswa', 'nilaiRata', 'hasilMagang', 'sudahMengisi'));
    }

    public function index()
    {
        return $this->jurusan();
    }
}
