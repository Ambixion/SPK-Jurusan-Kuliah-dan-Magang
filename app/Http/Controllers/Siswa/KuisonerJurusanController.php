<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SawController;
use App\Models\Bidang;
use App\Models\JawabanSiswa;
use App\Models\JurusanKuliah;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KuisonerJurusanController extends Controller
{
    /**
     * Landing page — ambil bidang dari database, bukan hardcode
     */
    public function landing()
    {
        $siswa     = Auth::user()->siswa;
        $nilaiRata = $siswa->nilai_rata;

        // Bidang diambil dari DB
        $bidangs = Bidang::with('jurusanKuliah')->orderBy('nama')->get();

        $sudahMengisi = $siswa->jawabanSiswa()
            ->whereHas('opsi.kuisoner', fn($q) => $q->where('type', 'jurusan'))
            ->exists();

        return view('siswa.jurusan.landing', compact('siswa', 'nilaiRata', 'bidangs', 'sudahMengisi'));
    }

    /**
     * Step kuisoner — soal diambil dari DB berdasarkan jurusan + bidang
     */
    public function index(Request $request)
    {
        $siswa          = Auth::user()->siswa;
        $jurusanKuliahId = $request->query('jurusan_kuliah_id');
        $bidangIds      = $request->query('bidang') ? explode(',', $request->query('bidang')) : [];

        // Ambil soal dari DB — dinamis berdasarkan jurusan dan bidang yang dipilih
        $query = Kuisoner::with('opsi')
            ->where('type', 'jurusan')
            ->orderBy('urutan');

        // Filter per jurusan kuliah (atau global jika null)
        if ($jurusanKuliahId) {
            $query->where(function ($q) use ($jurusanKuliahId) {
                $q->where('jurusan_kuliah_id', $jurusanKuliahId)
                  ->orWhereNull('jurusan_kuliah_id');
            });
        }

        // Filter per bidang yang dipilih (atau global jika null)
        if (!empty($bidangIds)) {
            $query->where(function ($q) use ($bidangIds) {
                $q->whereIn('bidang_id', $bidangIds)
                  ->orWhereNull('bidang_id');
            });
        }

        $pertanyaan = $query->get();

        // Simpan context ke session
        session([
            'jurusan_step_context' => [
                'jurusan_kuliah_id' => $jurusanKuliahId,
                'bidang_ids'        => $bidangIds,
            ]
        ]);

        if ($pertanyaan->isEmpty()) {
            return redirect()->route('siswa.jurusan')
                ->with('error', 'Belum ada kuisoner untuk pilihan ini. Hubungi admin.');
        }

        // Pecah soal menjadi step-step (@10 soal per step)
        $chunks   = $pertanyaan->chunk(10);
        $step     = max(1, (int) $request->query('step', 1));
        $stepData = $chunks->get($step - 1);
        $totalStep = $chunks->count();

        if (!$stepData) {
            return redirect()->route('siswa.jurusan');
        }

        return view('siswa.jurusan.step', compact('siswa', 'stepData', 'step', 'totalStep'));
    }

    /**
     * Store jawaban — tidak ada hardcode sama sekali
     */
    public function store(Request $request)
    {
        $siswa       = Auth::user()->siswa;
        $currentStep = (int) $request->input('step', 1);
        $totalStep   = (int) $request->input('total_step', 1);
        $jawaban     = $request->input('jawaban', []);

        // Validasi semua soal di step ini dijawab
        $soalIds = $request->input('soal_ids', []);
        $belumDijawab = array_diff($soalIds, array_keys($jawaban));
        if (!empty($belumDijawab)) {
            return back()
                ->withInput()
                ->with('error', 'Harap jawab semua pertanyaan sebelum lanjut.');
        }

        // Simpan jawaban step ini ke session
        $sessionKey = "jurusan_jawaban_step{$currentStep}";
        session([$sessionKey => $jawaban]);

        // Kalau belum step terakhir → lanjut ke step berikutnya
        if ($currentStep < $totalStep) {
            $context = session('jurusan_step_context', []);
            return redirect()->route('siswa.jurusan.kuisoner', array_merge($context, [
                'step' => $currentStep + 1,
            ]));
        }

        // ── STEP TERAKHIR: Gabungkan semua jawaban & simpan ──────────────────
        $semuaJawaban = [];
        for ($i = 1; $i <= $totalStep; $i++) {
            $semuaJawaban = array_merge($semuaJawaban, session("jurusan_jawaban_step{$i}", []));
        }

        DB::transaction(function () use ($siswa, $semuaJawaban) {
            // Hapus jawaban lama type jurusan
            $opsiJurusan = KuisonerOpsi::whereHas('kuisoner', fn($q) => $q->where('type', 'jurusan'))
                ->pluck('id');
            JawabanSiswa::where('siswa_id', $siswa->id)
                ->whereIn('kuisoner_opsi_id', $opsiJurusan)
                ->delete();

            // Simpan jawaban baru — opsi_id langsung dari form (sudah valid)
            foreach ($semuaJawaban as $kuisoner_id => $opsi_id) {
                if ($opsi_id) {
                    JawabanSiswa::updateOrCreate([
                        'siswa_id'         => $siswa->id,
                        'kuisoner_opsi_id' => $opsi_id,
                    ]);
                }
            }

            (new SawController())->hitungSAWJurusanPublic($siswa->id);
        });

        // Bersihkan session
        for ($i = 1; $i <= $totalStep; $i++) {
            session()->forget("jurusan_jawaban_step{$i}");
        }
        session()->forget('jurusan_step_context');

        return redirect()->route('siswa.jurusan.hasil')
            ->with('success', 'Kuisoner berhasil diisi! Berikut hasil rekomendasi jurusan kuliah.');
    }
}
