<?php

namespace App\Http\Controllers;

use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use App\Models\JurusanKuliah;
use App\Models\Kriteria;
use App\Models\Siswa;
use App\Models\SkorSiswa;
use App\Models\TempatMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SawController extends Controller
{
    public function hitungSAW(int $siswaId): void
    {
        $this->hitungSAWJurusanPublic($siswaId);
        $this->hitungSAWMagangPublic($siswaId);
    }

    public function hitungSAWJurusanPublic(int $siswaId): void
    {
        $skor = $this->hitungSkorSiswaPerKriteria($siswaId, 'jurusan');
        $this->hitungSAWJurusan($siswaId, $skor);
    }

    public function hitungSAWMagangPublic(int $siswaId): void
    {
        $this->hitungSAWMagang($siswaId);
    }

    public function hitungUlangSemua(Request $request)
    {
        foreach (DB::table('siswa')->pluck('id') as $id) {
            $this->hitungSAW($id);
        }
        return back()->with('success', 'Perhitungan SAW berhasil diperbarui untuk semua siswa.');
    }

    // =========================================================================
    // Hitung skor siswa per kriteria dari jawaban kuisoner
    // Skala Likert 1-5 → 0-100
    // =========================================================================
    private function hitungSkorSiswaPerKriteria(int $siswaId, string $type): array
    {
        SkorSiswa::where('siswa_id', $siswaId)->delete();

        $nilaiAkademik = min(100, round(
            DB::table('nilai_siswa')->where('siswa_id', $siswaId)->avg('nilai') ?? 0
        ));

        $nilaiPerKriteria = [];
        DB::table('jawaban_siswa')
            ->join('kuisoner_opsi', 'jawaban_siswa.kuisoner_opsi_id', '=', 'kuisoner_opsi.id')
            ->join('kuisoner', 'kuisoner_opsi.kuisoner_id', '=', 'kuisoner.id')
            ->where('jawaban_siswa.siswa_id', $siswaId)
            ->where('kuisoner.type', $type)
            ->whereNotNull('kuisoner.kriteria_id')
            ->select('kuisoner.kriteria_id', 'kuisoner_opsi.nilai')
            ->get()
            ->each(function ($row) use (&$nilaiPerKriteria) {
                $nilaiPerKriteria[$row->kriteria_id][] = (int) $row->nilai;
            });

        $skorPerKriteria = [];
        foreach (Kriteria::where('jenis', $type)->get() as $k) {
            if (!empty($nilaiPerKriteria[$k->id])) {
                $rata = array_sum($nilaiPerKriteria[$k->id]) / count($nilaiPerKriteria[$k->id]);
                $skor = round(($rata / 5) * 100);
            } elseif (str_contains(strtolower($k->nama), 'akademik')) {
                $skor = $nilaiAkademik;
            } else {
                $skor = 0;
            }
            $skorPerKriteria[$k->id] = $skor;
            SkorSiswa::create(['siswa_id' => $siswaId, 'kriteria_id' => $k->id, 'score' => $skor]);
        }
        return $skorPerKriteria;
    }

    // =========================================================================
    // SAW JURUSAN KULIAH
    // Jurusan yang dipilih siswa (ada jawabannya) mendapat nilai penuh.
    // Jurusan yang tidak dipilih mendapat nilai minimum (15% profil).
    // =========================================================================
    private function hitungSAWJurusan(int $siswaId, array $skorSiswaPerKriteria): void
    {
        $kriterias = Kriteria::where('jenis', 'jurusan')->get();
        $jurusans  = JurusanKuliah::with('skorJurusan')->get();
        if ($kriterias->isEmpty() || $jurusans->isEmpty()) return;

        $nilaiAkademik = min(100, round(
            DB::table('nilai_siswa')->where('siswa_id', $siswaId)->avg('nilai') ?? 0
        ));

        // Jawaban per jurusan_kuliah_id per kriteria
        $jawabanPerJurusan = [];
        DB::table('jawaban_siswa')
            ->join('kuisoner_opsi', 'jawaban_siswa.kuisoner_opsi_id', '=', 'kuisoner_opsi.id')
            ->join('kuisoner', 'kuisoner_opsi.kuisoner_id', '=', 'kuisoner.id')
            ->where('jawaban_siswa.siswa_id', $siswaId)
            ->where('kuisoner.type', 'jurusan')
            ->whereNotNull('kuisoner.jurusan_kuliah_id')
            ->whereNotNull('kuisoner.kriteria_id')
            ->select('kuisoner.jurusan_kuliah_id', 'kuisoner.kriteria_id', 'kuisoner_opsi.nilai')
            ->get()
            ->each(function ($row) use (&$jawabanPerJurusan) {
                $jawabanPerJurusan[$row->jurusan_kuliah_id][$row->kriteria_id][] = (int) $row->nilai;
            });

        $jurusanDipilih = array_keys($jawabanPerJurusan);

        $matriks = [];
        foreach ($jurusans as $jurusan) {
            foreach ($kriterias as $k) {
                $skorJ  = $jurusan->skorJurusan->firstWhere('kriteria_id', $k->id);
                $profil = $skorJ ? (float) $skorJ->score : 75.0;

                if (str_contains(strtolower($k->nama), 'akademik')) {
                    $selisih = abs($profil - $nilaiAkademik);
                    $match   = max(0.1, 1 - ($selisih / 100));
                    $nilai   = $profil * $match;
                } elseif (isset($jawabanPerJurusan[$jurusan->id][$k->id])) {
                    $arr  = $jawabanPerJurusan[$jurusan->id][$k->id];
                    $rata = array_sum($arr) / count($arr);
                    $skorSiswa100 = round(($rata / 5) * 100);
                    $selisih = abs($profil - $skorSiswa100);
                    $match   = max(0.05, 1 - ($selisih / 100));
                    $nilai   = $profil * $match;
                } elseif (in_array($jurusan->id, $jurusanDipilih)) {
                    $nilai = $profil * 0.5;
                } else {
                    // Tidak dipilih → skor minimum, tidak bisa mengalahkan yang dipilih
                    $nilai = $profil * 0.15;
                }

                $matriks[$jurusan->id][$k->id] = max(0, $nilai);
            }
        }

        $norm = $this->normalisasi($matriks, $kriterias);
        $pref = $this->preferensi($norm, $kriterias);
        arsort($pref);

        HasilJurusan::where('siswa_id', $siswaId)->delete();
        $rank = 1;
        foreach ($pref as $jId => $score) {
            HasilJurusan::create([
                'siswa_id'          => $siswaId,
                'jurusan_kuliah_id' => $jId,
                'score'             => min(100, round($score * 100, 2)),
                'rank'              => $rank++,
            ]);
        }
    }

    // =========================================================================
    // SAW MAGANG (PKL) — BERBASIS SKILL OVERLAP
    //
    // KONSEP UTAMA:
    // Skill siswa berasal dari jurusan SMK (pivot jurusan_smk_skill).
    // Skill tempat magang berasal dari pivot tempat_magang_skill.
    // Semakin banyak skill yang overlap → semakin cocok tempat magang itu.
    //
    // TBSM → skill: Tune Up, Overhaul, Kelistrikan
    // Bengkel Teknik → skill: Tune Up, Overhaul, Kelistrikan → overlap 100% → rank 1
    // PT Telkom → skill: Web Dev, PHP, dll → overlap 0% dengan TBSM → rank bawah
    // =========================================================================
    private function hitungSAWMagang(int $siswaId): void
    {
        $kriterias     = Kriteria::where('jenis', 'magang')->get();
        $tempatMagangs = TempatMagang::with(['skorMagang', 'skills', 'bidangs'])->get();
        $siswa         = Siswa::with(['jurusanSmk.skills', 'jurusanSmk.bidangs'])->find($siswaId);

        if ($kriterias->isEmpty() || $tempatMagangs->isEmpty() || !$siswa) return;

        $nilaiAkademik = min(100, round(
            DB::table('nilai_siswa')->where('siswa_id', $siswaId)->avg('nilai') ?? 0
        ));

        // Skill & bidang jurusan SMK siswa
        $skillSiswa  = $siswa->jurusanSmk ? $siswa->jurusanSmk->skills->pluck('id')->toArray() : [];
        $bidangSiswa = $siswa->jurusanSmk ? $siswa->jurusanSmk->bidangs->pluck('id')->toArray() : [];

        // Skor jawaban kuisoner magang per kriteria (0-100)
        $nilaiJawaban = [];
        DB::table('jawaban_siswa')
            ->join('kuisoner_opsi', 'jawaban_siswa.kuisoner_opsi_id', '=', 'kuisoner_opsi.id')
            ->join('kuisoner', 'kuisoner_opsi.kuisoner_id', '=', 'kuisoner.id')
            ->where('jawaban_siswa.siswa_id', $siswaId)
            ->where('kuisoner.type', 'magang')
            ->whereNotNull('kuisoner.kriteria_id')
            ->select('kuisoner.kriteria_id', 'kuisoner_opsi.nilai')
            ->get()
            ->each(function ($row) use (&$nilaiJawaban) {
                $nilaiJawaban[$row->kriteria_id][] = (int) $row->nilai;
            });

        $skorJawaban = [];
        foreach ($kriterias as $k) {
            if (!empty($nilaiJawaban[$k->id])) {
                $rata = array_sum($nilaiJawaban[$k->id]) / count($nilaiJawaban[$k->id]);
                $skorJawaban[$k->id] = round(($rata / 5) * 100);
            } else {
                $skorJawaban[$k->id] = str_contains(strtolower($k->nama), 'akademik') ? $nilaiAkademik : 50;
            }
        }

        $matriks = [];
        foreach ($tempatMagangs as $tempat) {
            $skillTempat  = $tempat->skills->pluck('id')->toArray();
            $bidangTempat = $tempat->bidangs->pluck('id')->toArray();

            // Hitung skill match score (0-100)
            if (!empty($skillSiswa) && !empty($skillTempat)) {
                // Ada skill di kedua sisi → pakai skill overlap
                $overlap    = count(array_intersect($skillSiswa, $skillTempat));
                $denominator = max(count($skillSiswa), count($skillTempat));
                $skillMatchScore = round(($overlap / $denominator) * 100);
            } elseif (!empty($bidangSiswa) && !empty($bidangTempat)) {
                // Fallback: pakai bidang overlap
                $overlap    = count(array_intersect($bidangSiswa, $bidangTempat));
                $denominator = max(count($bidangSiswa), count($bidangTempat));
                $skillMatchScore = round(($overlap / $denominator) * 100);
            } else {
                $skillMatchScore = 10; // tidak ada relasi
            }

            foreach ($kriterias as $k) {
                $skorM  = $tempat->skorMagang->firstWhere('kriteria_id', $k->id);
                $profil = $skorM ? (float) $skorM->score : 75.0;

                if (str_contains(strtolower($k->nama), 'akademik')) {
                    $selisih = abs($profil - $nilaiAkademik);
                    $match   = max(0.1, 1 - ($selisih / 100));
                    $nilai   = $profil * $match;
                } else {
                    // Gabung: 60% skill match + 40% jawaban kuisoner
                    $gabungan = ($skillMatchScore * 0.60) + ($skorJawaban[$k->id] * 0.40);
                    $selisih  = abs($profil - $gabungan);
                    $match    = max(0.05, 1 - ($selisih / 100));
                    $nilai    = $profil * $match;
                }

                $matriks[$tempat->id][$k->id] = max(0, $nilai);
            }
        }

        $norm = $this->normalisasi($matriks, $kriterias);
        $pref = $this->preferensi($norm, $kriterias);
        arsort($pref);

        HasilMagang::where('siswa_id', $siswaId)->delete();
        $rank = 1;
        foreach ($pref as $tId => $score) {
            HasilMagang::create([
                'siswa_id'         => $siswaId,
                'tempat_magang_id' => $tId,
                'score'            => min(100, round($score * 100, 2)),
                'rank'             => $rank++,
            ]);
        }
    }

    private function normalisasi(array $matriks, $kriterias): array
    {
        $result = [];
        foreach ($kriterias as $k) {
            $kolom  = array_column($matriks, $k->id) ?: [0];
            $maxVal = max($kolom) ?: 1;
            $minPos = min(array_filter($kolom, fn($v) => $v > 0) ?: [1]);
            foreach ($matriks as $altId => $row) {
                $val = $row[$k->id] ?? 0;
                $result[$altId][$k->id] = $k->type === 'benefit'
                    ? ($maxVal > 0 ? $val / $maxVal : 0)
                    : ($val   > 0 ? $minPos / $val  : 0);
            }
        }
        return $result;
    }

    private function preferensi(array $norm, $kriterias): array
    {
        $result = [];
        foreach ($norm as $altId => $row) {
            $total = 0;
            foreach ($kriterias as $k) {
                $total += (float) $k->weight * ($row[$k->id] ?? 0);
            }
            $result[$altId] = $total;
        }
        return $result;
    }
}
