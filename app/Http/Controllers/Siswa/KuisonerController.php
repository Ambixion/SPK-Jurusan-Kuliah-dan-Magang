<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use App\Models\JawabanSiswa;
use App\Http\Controllers\SawController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KuisonerController extends Controller
{
    public function index() {
        $siswa = Auth::user()->siswa;

        if(!$siswa) {
            abort(403, 'Data siswa tidak ditemukan,');
        }

        //cek apakah sudah pernah mengisi atau belom
        $sudahMengisi = $siswa->jawabanSiswa()->exists();

        $kuisonerJurusan = Kuisoner::with('opsi')
        ->where('type', 'jurusan')
        ->get();

        $kuisonerMagang = Kuisoner::with('opsi')
        ->where('type', 'magang')
        ->get();

        return view('siswa.kuisoner.index', compact(
            'kuisonerJurusan',
            'kuisonerMagang',
            'sudahMengisi',
            'siswa'
        ));
    }

    public function store(Request $request) {
        $siswa = Auth::user()->siswa;

        //kumpulkan semua opsi yang dipili (jawaban_jurusan + jawaban_magang)
        $allJawaban = array_merge(
            $request->input('jawaban_jurusan', []),
            $request->input('jawaban_magang', [])
        );

        if(empty($allJawaban)) {
            return back()->withErrors(['jawaban' => 'Harap isi semua pertanyaan,']);
        }

        //validasi semua soal wajib dijawab
        $totalSoal = Kuisoner::count();
        if (count($allJawaban) < $totalSoal) {
            return back()->withErrors(['jawaban' => 'Semua pertanyaan wajib dijawab.']);
        }

        DB::transaction(function () use ($siswa, $allJawaban) {
            //hapus jawaban lama jika ada (izinkan re-submit)
            JawabanSiswa::where('siswa_id', $siswa->id)->delete();

            foreach ($allJawaban as $opsi_id) {
                JawabanSiswa::create([
                    'siswa_id' => $siswa->id,
                    'kuisoner_opsi_id' => $opsi_id,
                ]);
            }

            //jalankan perhitungan SAW setelah menyimpan jawabab
            $sawController = new SawController();
            $sawController->hitungSAW($siswa->id);
        });

        return redirect()->route('siswa.hasil')
        ->with('success', 'Kuisoner berhasil diisi! Lihat hasil rekomendasi Anda.');
    }
}
