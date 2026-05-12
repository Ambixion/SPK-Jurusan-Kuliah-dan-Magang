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
    // =========================================================================
    // LANDING — Bidang & jurusan kuliah dari DB, tidak hardcode
    // =========================================================================
    public function landing()
    {
        $siswa     = Auth::user()->siswa;
        if (!$siswa) abort(403);

        $nilaiRata = round($siswa->nilaiSiswa()->avg('nilai') ?? 0, 2);

        // Semua bidang dari DB beserta jurusan kuliah yang punya bidang itu
        $bidangs = Bidang::with('jurusanKuliah')->orderBy('nama')->get();

        // Semua jurusan kuliah dari DB beserta bidangnya
        $jurusanList = JurusanKuliah::with('bidangs')->orderBy('nama')->get();

        $sudahMengisi = $siswa->jawabanSiswa()
            ->whereHas('opsi.kuisoner', fn($q) => $q->where('type', 'jurusan'))
            ->exists();

        return view('siswa.jurusan.landing', compact(
            'siswa',
            'nilaiRata',
            'bidangs',
            'jurusanList',
            'sudahMengisi'
        ));
    }

    // =========================================================================
    // INDEX — Soal dari DB, filter per jurusan kuliah yang dipilih + bidangnya
    // =========================================================================
    public function index(Request $request)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) abort(403);

        if (!Kuisoner::where('type', 'jurusan')->exists()) {
            return redirect()->route('siswa.jurusan')
                ->with('error', 'Belum ada kuisoner jurusan. Hubungi admin.');
        }

        $jurusanKuliahId = $request->query('jurusan_kuliah_id');
        $bidangIds = $request->query('bidang_ids')
            ? array_filter(explode(',', $request->query('bidang_ids')))
            : [];

        // Jika jurusan kuliah dipilih tapi tidak ada bidang_ids → ambil bidang dari jurusan itu
        if ($jurusanKuliahId && empty($bidangIds)) {
            $jurusan   = JurusanKuliah::with('bidangs')->find($jurusanKuliahId);
            $bidangIds = $jurusan ? $jurusan->bidangs->pluck('id')->toArray() : [];
        }

        $query = Kuisoner::with(['opsi' => fn($q) => $q->orderByDesc('nilai'), 'bidang', 'jurusanKuliah', 'kriteria'])
            ->where('type', 'jurusan')
            ->orderBy('urutan');

        if ($jurusanKuliahId || !empty($bidangIds)) {
            $query->where(function ($q) use ($jurusanKuliahId, $bidangIds) {
                // ── Soal global (tidak terikat jurusan maupun bidang) ────────────
                $q->where(function ($inner) {
                    $inner->whereNull('jurusan_kuliah_id')
                        ->whereNull('bidang_id');
                });

                // ── Soal khusus jurusan kuliah yang dipilih ──────────────────────
                if ($jurusanKuliahId) {
                    $q->orWhere(function ($inner) use ($jurusanKuliahId) {
                        $inner->where('jurusan_kuliah_id', $jurusanKuliahId);
                    });
                }

                // ── Soal per bidang yang relevan ─────────────────────────────────
                if (!empty($bidangIds)) {
                    $q->orWhere(function ($inner) use ($bidangIds) {
                        $inner->whereIn('bidang_id', $bidangIds)
                            ->whereNull('jurusan_kuliah_id'); // bidang global (bukan per-jurusan)
                    });
                }
            });
        }
        // Jika tidak ada filter sama sekali → tampilkan hanya soal global
        else {
            $query->whereNull('jurusan_kuliah_id')->whereNull('bidang_id');
        }

        $pertanyaan = $query->get();

        // Simpan context ke session agar navigasi antar step tetap konsisten
        session([
            'jurusan_step_context' => [
                'jurusan_kuliah_id' => $jurusanKuliahId,
                'bidang_ids'        => implode(',', $bidangIds),
            ]
        ]);

        if ($pertanyaan->isEmpty()) {
            return redirect()->route('siswa.jurusan')
                ->with('error', 'Belum ada soal untuk pilihan ini. Hubungi admin untuk menambahkan kuisoner.');
        }

        $chunks    = $pertanyaan->chunk(10);
        $step      = max(1, (int) $request->query('step', 1));
        $stepData  = $chunks->get($step - 1);
        $totalStep = $chunks->count();

        if (!$stepData) return redirect()->route('siswa.jurusan');

        return view('siswa.jurusan.step', compact('siswa', 'stepData', 'step', 'totalStep'));
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
        $jawaban     = $request->input('jawaban', []);  // [kuisoner_id => opsi_id]
        $soalIds     = $request->input('soal_ids', []);

        // Validasi semua soal di step ini dijawab
        $belumDijawab = array_diff($soalIds, array_keys($jawaban));
        if (!empty($belumDijawab)) {
            return back()
                ->withInput()
                ->with('error', 'Harap jawab semua pertanyaan sebelum lanjut.');
        }

        session(["jurusan_jawaban_step{$currentStep}" => $jawaban]);

        if ($currentStep < $totalStep) {
            $ctx = session('jurusan_step_context', []);
            return redirect()->route('siswa.jurusan.kuisoner', array_merge(
                ['step' => $currentStep + 1],
                $ctx
            ));
        }

        // ── STEP TERAKHIR: Gabungkan semua jawaban & simpan ──────────────────
        $semuaJawaban = [];
        for ($i = 1; $i <= $totalStep; $i++) {
            $semuaJawaban = array_merge($semuaJawaban, session("jurusan_jawaban_step{$i}", []));
        }

        DB::transaction(function () use ($siswa, $semuaJawaban) {
            $opsiJurusan = KuisonerOpsi::whereHas('kuisoner', fn($q) => $q->where('type', 'jurusan'))
                ->pluck('id');
            JawabanSiswa::where('siswa_id', $siswa->id)
                ->whereIn('kuisoner_opsi_id', $opsiJurusan)
                ->delete();

            foreach ($semuaJawaban as $kuisonerId => $opsiId) {
                if ($opsiId) {
                    JawabanSiswa::updateOrCreate([
                        'siswa_id'         => $siswa->id,
                        'kuisoner_opsi_id' => $opsiId,
                    ]);
                }
            }

            (new SawController())->hitungSAWJurusanPublic($siswa->id);
        });

        for ($i = 1; $i <= $totalStep; $i++) {
            session()->forget("jurusan_jawaban_step{$i}");
        }
        session()->forget('jurusan_step_context');

        return redirect()->route('siswa.jurusan.hasil')
            ->with('success', 'Kuisoner berhasil diisi! Berikut hasil rekomendasi jurusan kuliah Anda.');
    }
}
