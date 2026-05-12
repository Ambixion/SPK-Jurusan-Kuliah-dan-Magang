<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * SkorJurusan: profil tiap jurusan kuliah per kriteria.
 *
 * KONSEP: skor ini merepresentasikan "seberapa tinggi tuntutan/kecocokan
 * jurusan tersebut untuk tiap kriteria".
 * Jurusan Teknik Informatika → Minat Bidang & Kemampuan TINGGI (butuh minat & skill kuat)
 * Jurusan Teknik Mesin → Kemampuan TINGGI (butuh skill teknis kuat) tapi beda bidang dari TI
 *
 * Matching dengan siswa terjadi di SawController (matching score),
 * bukan dengan membuat skor jurusan lebih rendah.
 * Semua jurusan harus punya profil yang REALISTIS dan BERBEDA.
 */
class SkorJurusan extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('skor_jurusan')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $jurusans  = DB::table('jurusan_kuliah')->get();
        $kriterias = DB::table('kriteria')->where('jenis', 'jurusan')->get();

        if ($jurusans->isEmpty() || $kriterias->isEmpty()) return;

        // Profil tiap jurusan: angka = profil kebutuhan jurusan (bukan ranking)
        // Semua jurusan nilainya setara, hanya BIDANG yang berbeda.
        // SAW akan mencocokkan profil ini dengan skor siswa.
        $skorMap = [
            // Jurusan teknologi → butuh minat & kemampuan di bidang IT
            'Teknik Informatika'        => ['Minat Bidang' => 85, 'Kemampuan' => 85, 'Nilai Akademik' => 80],
            'Sistem Informasi'          => ['Minat Bidang' => 80, 'Kemampuan' => 80, 'Nilai Akademik' => 75],

            // Jurusan kreatif → butuh minat seni & kreativitas
            'Desain Komunikasi Visual'  => ['Minat Bidang' => 85, 'Kemampuan' => 80, 'Nilai Akademik' => 70],

            // Jurusan teknik → butuh kemampuan teknis tinggi
            'Teknik Mesin'              => ['Minat Bidang' => 85, 'Kemampuan' => 85, 'Nilai Akademik' => 75],

            // Jurusan pertanian
            'Agribisnis Tanaman Pangan' => ['Minat Bidang' => 80, 'Kemampuan' => 75, 'Nilai Akademik' => 70],
            'Teknologi Pangan'          => ['Minat Bidang' => 80, 'Kemampuan' => 78, 'Nilai Akademik' => 72],

            // Jurusan peternakan & perikanan
            'Peternakan'                => ['Minat Bidang' => 80, 'Kemampuan' => 75, 'Nilai Akademik' => 68],
            'Akuakultur'                => ['Minat Bidang' => 80, 'Kemampuan' => 75, 'Nilai Akademik' => 68],
        ];

        $rows = [];
        foreach ($jurusans as $jurusan) {
            $skor = $skorMap[$jurusan->nama] ?? ['Minat Bidang' => 75, 'Kemampuan' => 75, 'Nilai Akademik' => 70];
            foreach ($kriterias as $kriteria) {
                $rows[] = [
                    'jurusan_kuliah_id' => $jurusan->id,
                    'kriteria_id'       => $kriteria->id,
                    'score'             => $skor[$kriteria->nama] ?? 75,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
            }
        }

        DB::table('skor_jurusan')->insert($rows);
    }
}
