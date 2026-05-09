<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'PT Telkom Indonesia'      => ['Minat Magang' => 90, 'Kemampuan' => 88, 'Nilai Akademik' => 85],
            'Dinas Kominfo Jember'     => ['Minat Magang' => 80, 'Kemampuan' => 78, 'Nilai Akademik' => 80],
            'CV Maju Jaya Tech'        => ['Minat Magang' => 85, 'Kemampuan' => 82, 'Nilai Akademik' => 78],
            'Studio Kreatif Nusantara' => ['Minat Magang' => 80, 'Kemampuan' => 85, 'Nilai Akademik' => 75],
            'PT Agro Jember Makmur'    => ['Minat Magang' => 70, 'Kemampuan' => 68, 'Nilai Akademik' => 70],
            'Balai Penelitian Tanaman' => ['Minat Magang' => 72, 'Kemampuan' => 75, 'Nilai Akademik' => 73],
            'PT Media Kreasi Digital'  => ['Minat Magang' => 78, 'Kemampuan' => 80, 'Nilai Akademik' => 72],
            'Bengkel Teknik Jember'    => ['Minat Magang' => 65, 'Kemampuan' => 72, 'Nilai Akademik' => 68],
        ];

        $rows = [];
        foreach ($tempats as $tempat) {
            $skor = $skorMap[$tempat->nama] ?? [];
            foreach ($kriterias as $kriteria) {
                $rows[] = [
                    'tempat_magang_id' => $tempat->id,
                    'kriteria_id'      => $kriteria->id,
                    'score'            => $skor[$kriteria->nama] ?? 50,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ];
            }
        }
        DB::table('skor_magang')->insert($rows);
    }
}
