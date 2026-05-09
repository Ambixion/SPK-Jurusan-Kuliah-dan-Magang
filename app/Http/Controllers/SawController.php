<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SkorSiswa;
use App\Models\JurusanKuliah;
use App\Models\TempatMagang;
use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use App\Models\JawabanSiswa;
use App\Models\Kuisoner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SawController extends Controller
{
    public function hitungSAW(int $siswaId): void
    {
        $this->konversiJawabanKeSkor($siswaId);
        $this->hitungSAWJurusan($siswaId);
        $this->hitungSAWMagang($siswaId);
    }

    public function hitungSAWJurusanPublic(int $siswaId): void
    {
        $this->konversiJawabanKeSkor($siswaId);
        $this->hitungSAWJurusan($siswaId);
    }

    public function hitungSAWMagangPublic(int $siswaId): void
    {
        $this->konversiJawabanKeSkor($siswaId);
        $this->hitungSAWMagang($siswaId);
    }

    /**
     * CORE FIX: Scoring sekarang akurat karena kuisoner terhubung langsung ke kriteria.
     * Tidak lagi pakai str_contains('akademik') yang rapuh.
     */
    private function konversiJawabanKeSkor(int $siswaId): void
    {
        SkorSiswa::where('siswa_id', $siswaId)->delete();

        // Ambil semua jawaban beserta opsi, kuisoner, dan kriteria-nya
        $jawabans = JawabanSiswa::where('siswa_id', $siswaId)
            ->with('opsi.kuisoner.kriteria')
            ->get();

        // Kelompokkan nilai per kriteria_id
        $nilaiPerKriteria = [];  // [kriteria_id => [nilai1, nilai2, ...]]

        foreach ($jawabans as $jawaban) {
            $kuisoner = $jawaban->opsi->kuisoner ?? null;
            if (!$kuisoner) continue;

            // Jika kuisoner terhubung ke kriteria → gunakan kriteria itu
            if ($kuisoner->kriteria_id) {
                $nilaiPerKriteria[$kuisoner->kriteria_id][] = $jawaban->opsi->nilai;
            }
            // Jika tidak terhubung → fallback ke kriteria pertama sesuai type
            else {
                $kriteriaFallback = Kriteria::where('jenis', $kuisoner->type)->first();
                if ($kriteriaFallback) {
                    $nilaiPerKriteria[$kriteriaFallback->id][] = $jawaban->opsi->nilai;
                }
            }
        }

        // Nilai akademik dari rapot
        $nilaiAkademik = round(
            DB::table('nilai_siswa')->where('siswa_id', $siswaId)->avg('nilai') ?? 0
        );

        // Simpan skor per kriteria = rata-rata jawaban untuk kriteria tersebut
        $semuaKriteria = Kriteria::all();
        foreach ($semuaKriteria as $kriteria) {
            // Jika ada jawaban untuk kriteria ini → rata-ratakan
            if (!empty($nilaiPerKriteria[$kriteria->id])) {
                $nilai = array_values($nilaiPerKriteria[$kriteria->id]);
                $skor  = round(array_sum($nilai) / count($nilai));
            }
            // Kalau kriteria "nilai akademik" dan tidak ada jawaban → pakai nilai rapot
            elseif (str_contains(strtolower($kriteria->nama), 'akademik')) {
                $skor = $nilaiAkademik;
            }
            // Tidak ada jawaban → skor 0
            else {
                $skor = 0;
            }

            SkorSiswa::updateOrCreate(
                ['siswa_id' => $siswaId, 'kriteria_id' => $kriteria->id],
                ['score' => $skor]
            );
        }
    }

    private function hitungSAWJurusan(int $siswaId): void
    {
        $kriterias = Kriteria::where('jenis', 'jurusan')->get();
        $jurusans  = JurusanKuliah::with('skorJurusan')->get();

        if ($kriterias->isEmpty() || $jurusans->isEmpty()) return;

        $skorSiswa = SkorSiswa::where('siswa_id', $siswaId)
            ->whereIn('kriteria_id', $kriterias->pluck('id'))
            ->pluck('score', 'kriteria_id');

        $matriks = [];
        foreach ($jurusans as $jurusan) {
            foreach ($kriterias as $kriteria) {
                $skorJ = $jurusan->skorJurusan->firstWhere('kriteria_id', $kriteria->id);
                $skorS = $skorSiswa[$kriteria->id] ?? 0;
                $matriks[$jurusan->id][$kriteria->id] = $skorJ
                    ? ($skorJ->score + $skorS) / 2
                    : $skorS;
            }
        }

        $normalisasi = $this->normalisasi($matriks, $kriterias);
        $preferensi  = $this->hitungPreferensi($normalisasi, $kriterias);
        arsort($preferensi);

        HasilJurusan::where('siswa_id', $siswaId)->delete();
        $rank = 1;
        foreach ($preferensi as $jurusanId => $score) {
            HasilJurusan::create([
                'siswa_id'          => $siswaId,
                'jurusan_kuliah_id' => $jurusanId,
                'score'             => round($score, 3),
                'rank'              => $rank++,
            ]);
        }
    }

    private function hitungSAWMagang(int $siswaId): void
    {
        $kriterias     = Kriteria::where('jenis', 'magang')->get();
        $tempatMagangs = TempatMagang::with('skorMagang')->get();

        if ($kriterias->isEmpty() || $tempatMagangs->isEmpty()) return;

        $skorSiswa = SkorSiswa::where('siswa_id', $siswaId)
            ->whereIn('kriteria_id', $kriterias->pluck('id'))
            ->pluck('score', 'kriteria_id');

        $matriks = [];
        foreach ($tempatMagangs as $tempat) {
            foreach ($kriterias as $kriteria) {
                $skorM = $tempat->skorMagang->firstWhere('kriteria_id', $kriteria->id);
                $skorS = $skorSiswa[$kriteria->id] ?? 0;
                $matriks[$tempat->id][$kriteria->id] = $skorM
                    ? ($skorM->score + $skorS) / 2
                    : $skorS;
            }
        }

        $normalisasi = $this->normalisasi($matriks, $kriterias);
        $preferensi  = $this->hitungPreferensi($normalisasi, $kriterias);
        arsort($preferensi);

        HasilMagang::where('siswa_id', $siswaId)->delete();
        $rank = 1;
        foreach ($preferensi as $tempatId => $score) {
            HasilMagang::create([
                'siswa_id'         => $siswaId,
                'tempat_magang_id' => $tempatId,
                'score'            => round($score, 3),
                'rank'             => $rank++,
            ]);
        }
    }

    private function normalisasi(array $matriks, $kriterias): array
    {
        $normalisasi = [];
        foreach ($kriterias as $kriteria) {
            $kolom  = array_map(fn($row) => $row[$kriteria->id] ?? 0, $matriks);
            $maxVal = max($kolom) ?: 1;
            $minVal = min($kolom) ?: 1;
            foreach ($matriks as $altId => $row) {
                $val = $row[$kriteria->id] ?? 0;
                $normalisasi[$altId][$kriteria->id] = $kriteria->type === 'benefit'
                    ? ($maxVal > 0 ? $val / $maxVal : 0)
                    : ($val    > 0 ? $minVal / $val  : 0);
            }
        }
        return $normalisasi;
    }

    private function hitungPreferensi(array $normalisasi, $kriterias): array
    {
        $preferensi = [];
        foreach ($normalisasi as $altId => $row) {
            $total = 0;
            foreach ($kriterias as $kriteria) {
                $total += $kriteria->weight * ($row[$kriteria->id] ?? 0);
            }
            $preferensi[$altId] = $total;
        }
        return $preferensi;
    }

    public function hitungUlangSemua(Request $request)
    {
        $siswaIds = DB::table('siswa')->pluck('id');
        foreach ($siswaIds as $siswaId) {
            $this->hitungSAW($siswaId);
        }
        return back()->with('success', 'Perhitungan SAW untuk semua siswa berhasil diperbarui.');
    }
}
