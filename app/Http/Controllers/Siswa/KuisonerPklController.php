<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SawController;
use App\Models\Bidang;
use App\Models\JawabanSiswa;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KuisonerPklController extends Controller
{
    // =========================================================================
    // LANDING — Auto-detect jurusan SMK siswa, tampilkan skill dari DB
    // =========================================================================
    public function landing()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) abort(403);

        $nilaiRata = round($siswa->nilaiSiswa()->avg('nilai') ?? 0, 2);

        // Ambil jurusan SMK siswa beserta skill-nya dari DB
        $jurusanSmk  = $siswa->jurusanSmk;               // relasi ke JurusanSmk
        $skillJurusan = $jurusanSmk                       // skill milik jurusan SMK ini
            ? $jurusanSmk->skills()->orderBy('jenis_skill')->get()
            : collect();

        // Jika tidak ada skill di jurusan → tampilkan semua skill sebagai fallback
        if ($skillJurusan->isEmpty()) {
            $skillJurusan = \App\Models\Skill::orderBy('jenis_skill')->get();
        }

        $sudahMengisi = JawabanSiswa::where('siswa_id', $siswa->id)
            ->whereHas('opsi.kuisoner', fn($q) => $q->where('type', 'magang'))
            ->exists();

        return view('siswa.pkl.landing', compact(
            'siswa',
            'nilaiRata',
            'jurusanSmk',
            'skillJurusan',
            'sudahMengisi'
        ));
    }

    // =========================================================================
    // UPDATE PREFERENSI LOKASI — Simpan preferensi lokasi siswa (dalam_kota|luar_kota|bebas)
    // =========================================================================
    public function updatePreferensi(Request $request)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) abort(403);

        $data = $request->validate([
            'preferensi_lokasi' => 'required|in:dalam_kota,luar_kota,bebas',
        ]);

        $siswa->preferensi_lokasi = $data['preferensi_lokasi'];
        $siswa->save();

        return back()->with('success', 'Preferensi lokasi berhasil disimpan.');
    }

    // =========================================================================
    // INDEX — Ambil soal PKL dari DB berdasarkan skill jurusan SMK siswa
    // =========================================================================
    public function index(Request $request)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) abort(403);

        if (!Kuisoner::where('type', 'magang')->exists()) {
            return redirect()->route('siswa.pkl')
                ->with('error', 'Belum ada kuisoner PKL. Hubungi admin.');
        }

        // Skill yang dipilih siswa di landing (dari query string)
        $skillIds = $request->query('skill_ids')
            ? array_filter(explode(',', $request->query('skill_ids')))
            : [];

        // Jika tidak ada skill dipilih → pakai semua skill jurusan SMK siswa otomatis
        if (empty($skillIds) && $siswa->jurusanSmk) {
            $skillIds = $siswa->jurusanSmk->skills()->pluck('skill.id')->toArray();
        }

        $query = Kuisoner::with(['opsi' => fn($q) => $q->orderByDesc('nilai'), 'skill', 'bidang', 'kriteria'])
            ->where('type', 'magang')
            ->orderBy('urutan')
            ->orderBy('id');

        if (!empty($skillIds)) {
            $query->where(function ($q) use ($skillIds) {
                // Soal global (skill_id NULL) + soal untuk skill yang dipilih
                $q->whereNull('skill_id')
                    ->orWhereIn('skill_id', $skillIds);
            });
        } else {
            // Tidak ada skill sama sekali → hanya tampilkan soal global
            $query->whereNull('skill_id');
        }

        $pertanyaan = $query->get();

        if ($pertanyaan->isEmpty()) {
            return redirect()->route('siswa.pkl')
                ->with('error', 'Tidak ada kuisoner PKL untuk jurusan Anda. Hubungi admin.');
        }

        session(['pkl_step_context' => ['skill_ids' => implode(',', $skillIds)]]);

        $chunks    = $pertanyaan->chunk(10);
        $step      = max(1, (int) $request->query('step', 1));
        $stepData  = $chunks->get($step - 1);
        $totalStep = $chunks->count();

        if (!$stepData) return redirect()->route('siswa.pkl');

        return view('siswa.pkl.step', compact('siswa', 'stepData', 'step', 'totalStep'));
    }

    // =========================================================================
    // STORE — Simpan jawaban per step, di step terakhir hitung SAW
    // =========================================================================
    public function store(Request $request)
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) abort(403);

        $currentStep = (int) $request->input('step', 1);
        $totalStep   = (int) $request->input('total_step', 1);
        $jawaban     = $request->input('jawaban', []);   // [kuisoner_id => opsi_id]
        $soalIds     = $request->input('soal_ids', []);  // array soal di step ini

        // Validasi: semua soal di step ini harus dijawab
        $belumDijawab = array_diff($soalIds, array_keys($jawaban));
        if (!empty($belumDijawab)) {
            return back()
                ->withInput()
                ->with('error', 'Harap jawab semua pertanyaan sebelum lanjut.');
        }

        // Simpan jawaban step ini ke session
        session(["pkl_jawaban_step{$currentStep}" => $jawaban]);

        // Jika belum step terakhir → redirect ke step berikutnya
        if ($currentStep < $totalStep) {
            $ctx = session('pkl_step_context', []);
            return redirect()->route('siswa.pkl.kuisoner', array_merge(
                ['step' => $currentStep + 1],
                $ctx
            ));
        }

        // ── STEP TERAKHIR: Gabungkan semua jawaban & simpan ──────────────────
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

            // Simpan jawaban baru — key=kuisoner_id, value=opsi_id
            foreach ($semuaJawaban as $kuisonerId => $opsiId) {
                if ($opsiId) {
                    JawabanSiswa::updateOrCreate([
                        'siswa_id'         => $siswa->id,
                        'kuisoner_opsi_id' => $opsiId,
                    ]);
                }
            }

            // Hitung SAW magang
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
