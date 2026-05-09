<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilMagang;
use App\Models\JawabanSiswa;
use App\Models\KuisonerOpsi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HasilPklController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) abort(403);

        $nilaiRata = round(DB::table('nilai_siswa')->where('siswa_id', $siswa->id)->avg('nilai') ?? 0, 2);

        $opsiMagang   = KuisonerOpsi::whereHas('kuisoner', fn($q) => $q->where('type', 'magang'))->pluck('id');
        $sudahMengisi = JawabanSiswa::where('siswa_id', $siswa->id)
            ->whereIn('kuisoner_opsi_id', $opsiMagang)
            ->exists();

        $hasilMagang = collect();
        if ($sudahMengisi) {
            $hasilMagang = HasilMagang::with('tempatMagang')
                ->where('siswa_id', $siswa->id)
                ->orderBy('rank')
                ->get();
        }

        return view('siswa.pkl.hasil', compact(
            'siswa', 'nilaiRata', 'hasilMagang', 'sudahMengisi'
        ));
    }
}
