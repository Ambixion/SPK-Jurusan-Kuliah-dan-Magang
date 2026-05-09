<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilJurusan;
use App\Models\Kuisoner;
use App\Models\JawabanSiswa;
use App\Models\KuisonerOpsi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HasilJurusanController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) abort(403);

        $nilaiRata = round(DB::table('nilai_siswa')->where('siswa_id', $siswa->id)->avg('nilai') ?? 0, 2);

        // Cek apakah sudah mengisi kuisoner jurusan
        $opsiJurusan  = KuisonerOpsi::whereHas('kuisoner', fn($q) => $q->where('type', 'jurusan'))->pluck('id');
        $sudahMengisi = JawabanSiswa::where('siswa_id', $siswa->id)
            ->whereIn('kuisoner_opsi_id', $opsiJurusan)
            ->exists();

        $hasilJurusan = collect();
        if ($sudahMengisi) {
            $hasilJurusan = HasilJurusan::with('jurusan')
                ->where('siswa_id', $siswa->id)
                ->orderBy('rank')
                ->get();
        }

        return view('siswa.jurusan.hasil', compact(
            'siswa', 'nilaiRata', 'hasilJurusan', 'sudahMengisi'
        ));
    }
}
