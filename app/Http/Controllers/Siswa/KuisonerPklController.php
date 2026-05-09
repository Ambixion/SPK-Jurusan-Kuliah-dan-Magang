<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SawController;
use App\Models\Bidang;
use App\Models\JawabanSiswa;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KuisonerPklController extends Controller
{
    // =========================================================================
    // LANDING — Data diri siswa + pilih bidang & skill dari DB
    // =========================================================================
    public function landing()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) abort(403);

        // Nilai rata-rata dari relasi (bukan DB::table langsung)
        $nilaiRata = round($siswa->nilaiSiswa()->avg('nilai') ?? 0, 2);

        // Bidang & skill diambil dari DB — tidak hardcode
        $bidangs = Bidang::orderBy('nama')->get();
        $skills  = Skill::orderBy('jenis_skill')->get();

        $sudahMengisi = JawabanSiswa::where('siswa_id', $siswa->id)
            ->whereHas('opsi.kuisoner', fn($q) => $q->where('type', 'magang'))
            ->exists();

        return view('siswa.pkl.landing', compact(
            'siswa', 'nilaiRata', 'bidangs', 'skills', 'sudahMengisi'
        ));
    }

    // =========================================================================
    // INDEX (Step 1) — Soal kuisoner PKL diambil dari DB berdasarkan bidang & skill
    // =========================================================================
    public function index(Request $request)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) abort(403);

        // Pastikan ada kuisoner magang di DB
        if (!Kuisoner::where('type', 'magang')->exists()) {
            return redirect()->route('siswa.pkl')
                ->with('error', 'Belum ada kuisoner PKL. Hubungi admin untuk menambahkan soal.');
        }

        // Ambil bidang_id dari query string (dikirim dari landing)
        $bidangIds = $request->query('bidang_ids')
            ? explode(',', $request->query('bidang_ids'))
            : [];

        // Ambil soal dari DB — filter per bidang yang dipilih, atau semua kalau tidak ada pilihan
        $query = Kuisoner::with('opsi')
            ->where('type', 'magang')
            ->orderBy('urutan')
            ->orderBy('id');

        if (!empty($bidangIds)) {
            $query->where(function ($q) use ($bidangIds) {
                $q->whereIn('bidang_id', $bidangIds)
                  ->orWhereNull('bidang_id');
            });
        }

        $pertanyaan = $query->get();

        if ($pertanyaan->isEmpty()) {
            return redirect()->route('siswa.pkl')
                ->with('error', 'Tidak ada kuisoner yang sesuai dengan bidang pilihan Anda. Coba pilih bidang lain.');
        }

        // Simpan context ke session
        session(['pkl_step_context' => ['bidang_ids' => $bidangIds]]);

        // Paginate soal per 10 per step
        $chunks    = $pertanyaan->chunk(10);
        $step      = max(1, (int) $request->query('step', 1));
        $stepData  = $chunks->get($step - 1);
        $totalStep = $chunks->count();

        if (!$stepData) {
            return redirect()->route('siswa.pkl');
        }

        return view('siswa.pkl.step', compact('siswa', 'stepData', 'step', 'totalStep'));
    }

    // =========================================================================
    // STORE — Simpan jawaban per step, di step terakhir hitung SAW
    // =========================================================================
    public function store(Request $request)
    {
        $siswa       = Auth::user()->siswa;
        if (!$siswa) abort(403);

        $currentStep = (int) $request->input('step', 1);
        $totalStep   = (int) $request->input('total_step', 1);
        $jawaban     = $request->input('jawaban', []);
        $soalIds     = $request->input('soal_ids', []);

        // Validasi semua soal di step ini sudah dijawab
        $belumDijawab = array_diff($soalIds, array_keys($jawaban));
        if (!empty($belumDijawab)) {
            return back()
                ->withInput()
                ->with('error', 'Harap jawab semua pertanyaan sebelum lanjut.');
        }

        // Simpan jawaban step ini ke session (key = opsi_id, value = opsi_id)
        session(["pkl_jawaban_step{$currentStep}" => $jawaban]);

        // Kalau belum step terakhir → redirect ke step berikutnya
        if ($currentStep < $totalStep) {
            $context = session('pkl_step_context', []);
            return redirect()->route('siswa.pkl.kuisoner', array_merge($context, [
                'step' => $currentStep + 1,
            ]));
        }

        // ── STEP TERAKHIR: Gabungkan semua jawaban & simpan ke DB ────────────
        $semuaJawaban = [];
        for ($i = 1; $i <= $totalStep; $i++) {
            $semuaJawaban = array_merge($semuaJawaban, session("pkl_jawaban_step{$i}", []));
        }

        DB::transaction(function () use ($siswa, $semuaJawaban) {
            // Hapus jawaban lama type magang
            $opsiMagang = KuisonerOpsi::whereHas('kuisoner', fn($q) => $q->where('type', 'magang'))
                ->pluck('id');
            JawabanSiswa::where('siswa_id', $siswa->id)
                ->whereIn('kuisoner_opsi_id', $opsiMagang)
                ->delete();

            // Simpan jawaban baru — opsi_id langsung dari form (sudah tervalidasi)
            foreach ($semuaJawaban as $kuisoner_id => $opsi_id) {
                if ($opsi_id) {
                    JawabanSiswa::updateOrCreate([
                        'siswa_id'         => $siswa->id,
                        'kuisoner_opsi_id' => $opsi_id,
                    ]);
                }
            }

            // Hitung SAW untuk magang
            (new SawController())->hitungSAWMagangPublic($siswa->id);
        });

        // Bersihkan session pkl
        for ($i = 1; $i <= $totalStep; $i++) {
            session()->forget("pkl_jawaban_step{$i}");
        }
        session()->forget('pkl_step_context');

        return redirect()->route('siswa.pkl.hasil')
            ->with('success', 'Kuisoner PKL berhasil diisi! Berikut hasil rekomendasi tempat PKL Anda.');
    }
}
