<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * SkorMagang: profil tiap tempat magang per kriteria.
 * Profil ini menggambarkan "seberapa besar tuntutan tempat magang tersebut".
 * Matching dengan siswa terjadi di SawController.
 *
 * Semua tempat magang profil setara (tidak ada yg "terbaik absolut"),
 * tapi bidang berbeda → siswa dgn skill berbeda akan dapat hasil berbeda.
 */
class SkorMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('skor_magang')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $tempats   = DB::table('tempat_magang')->get();
        $kriterias = DB::table('kriteria')->where('jenis', 'magang')->get();

        if ($tempats->isEmpty() || $kriterias->isEmpty()) return;

        $skorMap = [
            // Bidang IT/Teknologi
            'PT Telkom Indonesia'      => ['Minat Magang' => 85, 'Kemampuan' => 85, 'Nilai Akademik' => 80],
            'CV Maju Jaya Tech'        => ['Minat Magang' => 82, 'Kemampuan' => 82, 'Nilai Akademik' => 75],
            'Dinas Kominfo Jember'     => ['Minat Magang' => 80, 'Kemampuan' => 78, 'Nilai Akademik' => 75],

            // Bidang Kreatif/Media
            'Studio Kreatif Nusantara' => ['Minat Magang' => 85, 'Kemampuan' => 82, 'Nilai Akademik' => 70],
            'PT Media Kreasi Digital'  => ['Minat Magang' => 82, 'Kemampuan' => 80, 'Nilai Akademik' => 70],

            // Bidang Pertanian
            'PT Agro Jember Makmur'    => ['Minat Magang' => 82, 'Kemampuan' => 80, 'Nilai Akademik' => 72],
            'Balai Penelitian Tanaman' => ['Minat Magang' => 80, 'Kemampuan' => 80, 'Nilai Akademik' => 75],

            // Bidang Teknik/Otomotif
            'Bengkel Teknik Jember'    => ['Minat Magang' => 85, 'Kemampuan' => 85, 'Nilai Akademik' => 70],
        ];

        $rows = [];
        foreach ($tempats as $tempat) {
            $skor = $skorMap[$tempat->nama] ?? ['Minat Magang' => 75, 'Kemampuan' => 75, 'Nilai Akademik' => 70];
            foreach ($kriterias as $kriteria) {
                $rows[] = [
                    'tempat_magang_id' => $tempat->id,
                    'kriteria_id'      => $kriteria->id,
                    'score'            => $skor[$kriteria->nama] ?? 75,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ];
            }
        }

        DB::table('skor_magang')->insert($rows);
    }
}
