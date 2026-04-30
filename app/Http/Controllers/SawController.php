<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SkorSiswa;
use App\Models\JurusanKuliah;
use App\Models\TempatMagang;
use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use App\Models\JawabanSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SawController extends Controller
{
    /**
     * Entry point utama: hitung SAW untuk satu siswa.
     * Dipanggil dari KuisonerController setelah siswa mengisi kuisoner.
     */
    public function hitungSAW(int $siswaId):void {
        // 1. konversi jawaban kuisoner siswa -> skor_siswa per kriteria
        $this->konversiJawabanKeSkor($siswaId);

        //2. hitung saw untuk jurusan kuliah
        $this->hitungSAWJurusan($siswaId);

        //3. hitung saw untuk tempat magang
        $this->hitungSAWMagang($siswaId);
    }

    // =========================================================================
    // STEP 1 – Konversi jawaban kuisoner → skor_siswa
    // =========================================================================

    /**
     * Agregasi nilai pilihan jawaban siswa menjadi skor per kriteria.
     * Setiap jawaban memiliki nilai (bobot opsi) yang dijumlahkan per kriteria.
     */
    private function konversiJawabanKeSkor(int $siswaId): void {
        //hapus skor lama
        SkorSiswa::where('siswa_id', $siswaId)->delete();

        //ambil semua jawaban siswa beserta nilai opsi dan kuisoner id nya
        $jawabans = JawabanSiswa::where('siswa_id', $siswaId)
            ->with('opsi.kuisoner')
            ->get();

        // Kelompokkan nilai per kriteria berdasarkan tipe kuisoner
        // Asumsikan: 1 kuisoner ↔ 1 kriteria (berdasarkan urutan/jenis yang sama)
        // Untuk mapping yang lebih eksplisit, tambahkan kolom kriteria_id pada tabel kuisoner.
        // Sementara ini: jumlahkan nilai semua jawaban per jenis (jurusan/magang) lalu bagi rata ke kriteria.
        $nilaiJurusan = 0;
        $nilaiMagang = 0;
        $countJurusan = 0;
        $countMagang = 0;

        foreach ($jawabans as $jawaban) {
            $type = $jawaban->opsi->kuisoner->type ?? null;
            if ($type === 'jurusan') {
                $nilaiJurusan += $jawaban->opsi->nilai;
                $countJurusan++;
            } elseif($type === 'magang') {
                $nilaiMagang += $jawaban->opsi->nilai;
                $countMagang++;
            }
        }

        //hitung rata rata nilai kuisoner sebagai skor minat siswa
        $rataJurusan = $countJurusan > 0 ? round($nilaiJurusan / $countJurusan) : 0;
        $rataMagang = $countMagang > 0 ? round($nilaiMagang / $countMagang) : 0;

        //ambil nilai akademik rata rata siswa dari tabel nilai_siswa
        $nilaiAkademik = DB::table('nilai_siswa')
            ->where('siswa_id', $siswaId)
            ->avg('nilai') ?? 0;

        $nilaiAkademik = round($nilaiAkademik);

        //simpan skor per kriteria sesuai jenis
        $kriteriaJurusan = Kriteria::where('jenis', 'jurusan')->get();
        foreach ($kriteriaJurusan as $kriteria) {
            $skor = str_contains(strtolower($kriteria->name), 'akademik')
            ? $nilaiAkademik : $rataJurusan;

            SkorSiswa::updateOrCreate(
                ['siswa_id' => $siswaId, 'kriteria_id' => $kriteria->id],
                ['score' => $skor]
            );
        }

        $kriteriaMagang = Kriteria::where('jenis', 'magang')->get();
        foreach ($kriteriaMagang as $kriteria) {
            $skor = str_contains(strtolower($kriteria->name), 'akademik')
            ? $nilaiAkademik : $rataMagang;

            SkorSiswa::updateOrCreate(
                ['siswa_id' => $siswaId, 'kriteria_id' => $kriteria->id],
                ['score' => $skor]
            );
        }
    }

    // =========================================================================
    // STEP 2 – SAW untuk Jurusan Kuliah
    // =========================================================================
    private function hitungSAWJurusan(int $siswaId): void {
        $kriterias = Kriteria::where('jenis', 'jurusan')->get();
        $jurusans = JurusanKuliah::with('skorJurusan')->get();

        if ($kriterias->isEmpty() || $jurusans->isEmpty()) {
            return;
        }

        //ambil skor siswa per kriteria
        $skorSiswa = SkorSiswa::where('siswa_id', $siswaId)
            ->whereIn('kriteria_id', $kriterias->pluck('id'))
            ->pluck('score', 'kriteria_id');

        //bangun matriks keputusan: [jurusan_id => [kriteria_id => score]]
        $matriks = [];
        foreach ($jurusans as $jurusan) {
            foreach ($kriterias as $kriteria) {
                $skorJ = $jurusan->skorJurusan->firstWhere('kriteria_id', $kriteria->id);
                $skorS = $skorSiswa[$kriteria->id] ?? 0;

                //skor final = rata rata skor jurusan dan skor siswa
                $matriks[$jurusan->id][$kriteria->id] = ($skorJ ? ($skorJ->score + $skorS) / 2 : $skorS);
            }
        }

        //normalisasi
        $normalisasi = $this->normalisasi($matriks, $kriterias);

        //hitung nilai preferensi & ranking
        $preferensi = $this->hitungPreferensi($normalisasi, $kriterias);
        arsort($preferensi);

        //simpan hasil
        HasilJurusan::where('siswa_id', $siswaId)->delete();

        $rank = 1;
        foreach ($preferensi as $jurusanId => $score) {
            HasilJurusan::create([
                'siswa_id' => $siswaId,
                'jurusan_kuliah_id' => $jurusanId,
                'score' => round($score, 3),
                'rank' => $rank++,
            ]);
        }
    }

    // =========================================================================
    // STEP 3 – SAW untuk Tempat Magang
    // =========================================================================
    private function hitungSAWMagang(int $siswaId): void {
        $kriterias = Kriteria::where('jenis', 'magang')->get();
        $tempatMagangs = TempatMagang::with('skorMagang')->get();

        if ($kriterias->isEmpty() || $tempatMagangs->isEmpty()) {
            return;
        }

        //ambil skor siswa per kriteria
        $skorSiswa = SkorSiswa::where('siswa_id', $siswaId)
            ->whereIn('kriteria_id', $kriterias->pluck('id'))
            ->pluck('score', 'kriteria_id');

        //bangun matriks keputusan:
        $matriks = [];
        foreach ($tempatMagangs as $tempat) {
            foreach ($kriterias as $kriteria) {
                $skorM = $tempat->skorMagang->firstWhere('kriteria_id', $kriteria->id);
                $skorS = $skorSiswa[$kriteria->id] ?? 0;

                $matriks[$tempat->id][$kriteria->id] = ($skorM ? ($skorM->score + $skorS) / 2 : $skorS);
            }
        }

        //normalisasi
        $normalisasi = $this->normalisasi($matriks, $kriterias);

        //hitung nilai preferensi & ranking
        $preferensi = $this->hitungPreferensi($matriks, $kriterias);
        arsort($preferensi);

        //simpan hasil
        HasilMagang::where('siswa_id', $siswaId)->delete();

        $rank = 1;
        foreach ($preferensi as $tempatId => $score) {
            HasilMagang::create([
                'siswa_id' => $siswaId,
                'tempat_magang_id' => $tempatId,
                'score' => round($score, 3),
                'rank' => $rank++,
            ]);
        }
    }

     // =========================================================================
    // Helpers SAW
    // =========================================================================

    /**
     * Normalisasi matriks keputusan menggunakan metode SAW:
     * - Benefit : r_ij = x_ij / max(x_j)
     * - Cost    : r_ij = min(x_j) / x_ij
     *
     * @param  array     $matriks   [alternatif_id => [kriteria_id => nilai]]
     * @param  \Illuminate\Support\Collection $kriterias
     * @return array     [alternatif_id => [kriteria_id => nilai_normal]]
     */
    private function normalisasi(array $matriks, $kriterias): array {
        $normalisasi = [];

        foreach ($kriterias as $kriteria) {
            $kolom = array_column(
                array_map(fn($row) => [$row[$kriteria->id] ?? 0], $matriks), 0
            );

            $maxVal = max($kolom) ?: 1;
            $minVal = min($kolom) ?: 1;

            foreach ($matriks as $altId => $row) {
                $val = $row[$kriteria->id] ?? 0;

                if ($kriteria->type === 'benefit') {
                    $normalisasi[$altId][$kriteria->id] = $maxVal > 0 ? $val / $maxVal : 0;
                } else {
                    //cost
                    $normalisasi[$altId][$kriteria->id] = $val > 0 ? $minVal / $val : 0;
                }
            }
        }

        return $normalisasi;
    }

    /**
     * Hitung nilai preferensi = Σ (weight_j * r_ij)
     *
     * @param  array $normalisasi  [alternatif_id => [kriteria_id => nilai_normal]]
     * @param  \Illuminate\Support\Collection $kriterias
     * @return array [alternatif_id => nilai_preferensi]
     */
    private function hitungPreferensi(array $normalisasi, $kriterias): array {
        $preferensi = [];

        foreach ($normalisasi as $altId => $row) {
            $total = 0;
            foreach ($kriterias as $kriteria) {
                $total += ($kriteria->weight * ($row[$kriteria->id] ?? 0));
            }
            $preferensi[$altId] = $total;
        }

        return $preferensi;
    }

    // =========================================================================
    // Endpoint: hitung ulang SAW untuk semua siswa (Admin trigger)
    // =========================================================================

    /**
     * Hitung ulang SAW semua siswa. Bisa dipanggil dari route admin.
     */
    public function hitungUlangSemua(Request $request) {
        $siswaIds = DB::table('siswa')->pluck('id');

        foreach ($siswaIds as $siswaId) {
            $this->hitungSAW($siswaId);
        }

        return back()->with('success', 'Perhitungan SAW untuk semua siswa berhasil diperbarui.');
    }
}
