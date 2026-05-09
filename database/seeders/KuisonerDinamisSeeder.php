<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\JurusanKuliah;
use App\Models\Kriteria;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use Illuminate\Database\Seeder;

class KuisonerDinamisSeeder extends Seeder
{
    public function run(): void
    {
        // Opsi Likert standar
        $opsiLikert = [
            ['jawaban' => 'Sangat Setuju',       'nilai' => 5],
            ['jawaban' => 'Setuju',               'nilai' => 4],
            ['jawaban' => 'Netral',               'nilai' => 3],
            ['jawaban' => 'Tidak Setuju',         'nilai' => 2],
            ['jawaban' => 'Sangat Tidak Setuju',  'nilai' => 1],
        ];

        $kriteriaMinatJurusan  = Kriteria::where('jenis', 'jurusan')->where('nama', 'Minat Bidang')->first();
        $kriteriaKemampuan     = Kriteria::where('jenis', 'jurusan')->where('nama', 'Kemampuan')->first();
        $kriteriaMinatMagang   = Kriteria::where('jenis', 'magang')->where('nama', 'Minat Magang')->first();
        $kriteriaKemampuanMag  = Kriteria::where('jenis', 'magang')->where('nama', 'Kemampuan')->first();

        $bidangTI      = Bidang::where('nama', 'Teknologi Informasi')->first();
        $bidangDesain  = Bidang::where('nama', 'Desain Kreatif')->first();
        $bidangTani    = Bidang::where('nama', 'Pertanian & Agribisnis')->first();
        $bidangMesin   = Bidang::where('nama', 'Teknik Mesin & Manufaktur')->first();
        $bidangIkan    = Bidang::where('nama', 'Perikanan & Akuakultur')->first();
        $bidangTernak  = Bidang::where('nama', 'Peternakan')->first();

        $jurusanTI   = JurusanKuliah::where('nama', 'Teknik Informatika')->first();
        $jurusanDKV  = JurusanKuliah::where('nama', 'Desain Komunikasi Visual')->first();
        $jurusanSI   = JurusanKuliah::where('nama', 'Sistem Informasi')->first();
        $jurusanAgri = JurusanKuliah::where('nama', 'Agribisnis Tanaman Pangan')->first();
        $jurusanMesin = JurusanKuliah::where('nama', 'Teknik Mesin')->first();

        // ── SOAL GLOBAL (berlaku untuk semua jurusan) ────────────────────────
        $soalGlobal = [
            // Minat umum
            ['soal' => 'Saya tertarik dengan bidang teknologi dan komputer', 'type' => 'jurusan', 'jurusan_kuliah_id' => null, 'bidang_id' => null, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 1],
            ['soal' => 'Saya tertarik dengan bidang seni dan desain kreatif', 'type' => 'jurusan', 'jurusan_kuliah_id' => null, 'bidang_id' => null, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 2],
            ['soal' => 'Saya tertarik dengan bidang pertanian dan alam', 'type' => 'jurusan', 'jurusan_kuliah_id' => null, 'bidang_id' => null, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 3],
            // Kemampuan umum
            ['soal' => 'Saya mudah belajar hal-hal baru', 'type' => 'jurusan', 'jurusan_kuliah_id' => null, 'bidang_id' => null, 'kriteria_id' => $kriteriaKemampuan?->id, 'urutan' => 10],
            ['soal' => 'Saya teliti dalam mengerjakan tugas', 'type' => 'jurusan', 'jurusan_kuliah_id' => null, 'bidang_id' => null, 'kriteria_id' => $kriteriaKemampuan?->id, 'urutan' => 11],
        ];

        // ── SOAL KHUSUS PER BIDANG ───────────────────────────────────────────
        $soalPerBidang = [
            // Teknologi Informasi
            ['soal' => 'Saya menikmati pemrograman komputer', 'type' => 'jurusan', 'bidang_id' => $bidangTI?->id, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 20],
            ['soal' => 'Saya tertarik dengan jaringan komputer dan keamanan data', 'type' => 'jurusan', 'bidang_id' => $bidangTI?->id, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 21],
            ['soal' => 'Saya mampu menggunakan komputer dengan baik', 'type' => 'jurusan', 'bidang_id' => $bidangTI?->id, 'kriteria_id' => $kriteriaKemampuan?->id, 'urutan' => 22],
            ['soal' => 'Saya bisa memecahkan masalah secara logis dan sistematis', 'type' => 'jurusan', 'bidang_id' => $bidangTI?->id, 'kriteria_id' => $kriteriaKemampuan?->id, 'urutan' => 23],

            // Desain Kreatif
            ['soal' => 'Saya suka membuat karya visual dan desain', 'type' => 'jurusan', 'bidang_id' => $bidangDesain?->id, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 30],
            ['soal' => 'Saya tertarik membuat konten video dan foto', 'type' => 'jurusan', 'bidang_id' => $bidangDesain?->id, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 31],
            ['soal' => 'Saya memiliki selera estetika yang baik', 'type' => 'jurusan', 'bidang_id' => $bidangDesain?->id, 'kriteria_id' => $kriteriaKemampuan?->id, 'urutan' => 32],

            // Pertanian
            ['soal' => 'Saya tertarik menanam dan merawat tanaman', 'type' => 'jurusan', 'bidang_id' => $bidangTani?->id, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 40],
            ['soal' => 'Saya suka kegiatan di luar ruangan', 'type' => 'jurusan', 'bidang_id' => $bidangTani?->id, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 41],

            // Mesin
            ['soal' => 'Saya tertarik dengan mesin dan alat teknik', 'type' => 'jurusan', 'bidang_id' => $bidangMesin?->id, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 50],
            ['soal' => 'Saya suka membongkar dan memperbaiki benda', 'type' => 'jurusan', 'bidang_id' => $bidangMesin?->id, 'kriteria_id' => $kriteriaKemampuan?->id, 'urutan' => 51],
        ];

        // ── SOAL KHUSUS PER JURUSAN KULIAH ──────────────────────────────────
        $soalPerJurusan = [
            // Teknik Informatika
            ['soal' => 'Saya ingin mengembangkan aplikasi web atau mobile', 'type' => 'jurusan', 'jurusan_kuliah_id' => $jurusanTI?->id, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 60],
            ['soal' => 'Saya tertarik dengan kecerdasan buatan (AI)', 'type' => 'jurusan', 'jurusan_kuliah_id' => $jurusanTI?->id, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 61],
            ['soal' => 'Saya memahami konsep dasar algoritma dan logika', 'type' => 'jurusan', 'jurusan_kuliah_id' => $jurusanTI?->id, 'kriteria_id' => $kriteriaKemampuan?->id, 'urutan' => 62],

            // DKV
            ['soal' => 'Saya ingin berkarir di industri kreatif dan periklanan', 'type' => 'jurusan', 'jurusan_kuliah_id' => $jurusanDKV?->id, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 70],
            ['soal' => 'Saya punya kemampuan menggambar atau ilustrasi', 'type' => 'jurusan', 'jurusan_kuliah_id' => $jurusanDKV?->id, 'kriteria_id' => $kriteriaKemampuan?->id, 'urutan' => 71],

            // Sistem Informasi
            ['soal' => 'Saya tertarik mengelola sistem informasi di perusahaan', 'type' => 'jurusan', 'jurusan_kuliah_id' => $jurusanSI?->id, 'kriteria_id' => $kriteriaMinatJurusan?->id, 'urutan' => 80],
        ];

        // ── SOAL PKL GLOBAL ──────────────────────────────────────────────────
        $soalPklGlobal = [
            ['soal' => 'Saya siap bekerja sesuai aturan dan SOP perusahaan', 'type' => 'magang', 'kriteria_id' => $kriteriaKemampuanMag?->id, 'urutan' => 1],
            ['soal' => 'Saya mampu berkomunikasi dengan baik di lingkungan kerja', 'type' => 'magang', 'kriteria_id' => $kriteriaKemampuanMag?->id, 'urutan' => 2],
            ['soal' => 'Saya tertarik magang di bidang teknologi', 'type' => 'magang', 'kriteria_id' => $kriteriaMinatMagang?->id, 'urutan' => 3],
            ['soal' => 'Saya tertarik magang di bidang kreatif dan desain', 'type' => 'magang', 'kriteria_id' => $kriteriaMinatMagang?->id, 'urutan' => 4],
            ['soal' => 'Saya tertarik magang di bidang pertanian atau peternakan', 'type' => 'magang', 'kriteria_id' => $kriteriaMinatMagang?->id, 'urutan' => 5],
            ['soal' => 'Saya lebih suka tempat PKL yang dekat dengan rumah', 'type' => 'magang', 'kriteria_id' => $kriteriaKemampuanMag?->id, 'urutan' => 6],
            ['soal' => 'Saya siap bekerja dalam tekanan dan memenuhi deadline', 'type' => 'magang', 'kriteria_id' => $kriteriaKemampuanMag?->id, 'urutan' => 7],
            ['soal' => 'Saya bisa bekerja sama dalam tim kerja', 'type' => 'magang', 'kriteria_id' => $kriteriaKemampuanMag?->id, 'urutan' => 8],
        ];

        // ── Simpan semua soal ────────────────────────────────────────────────
        $allSoal = array_merge($soalGlobal, $soalPerBidang, $soalPerJurusan, $soalPklGlobal);

        foreach ($allSoal as $soalData) {
            $kuisoner = Kuisoner::firstOrCreate(
                ['soal' => $soalData['soal'], 'type' => $soalData['type']],
                [
                    'jurusan_kuliah_id' => $soalData['jurusan_kuliah_id'] ?? null,
                    'bidang_id'         => $soalData['bidang_id'] ?? null,
                    'kriteria_id'       => $soalData['kriteria_id'] ?? null,
                    'urutan'            => $soalData['urutan'] ?? 0,
                ]
            );

            // Tambah opsi hanya kalau belum ada
            if ($kuisoner->opsi()->count() === 0) {
                foreach ($opsiLikert as $opsi) {
                    KuisonerOpsi::create([
                        'kuisoner_id' => $kuisoner->id,
                        'jawaban'     => $opsi['jawaban'],
                        'nilai'       => $opsi['nilai'],
                    ]);
                }
            }
        }
    }
}
