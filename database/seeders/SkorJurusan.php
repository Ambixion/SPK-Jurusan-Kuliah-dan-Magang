<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        $skorMap = [
            'Teknik Informatika'        => ['Minat Bidang' => 90, 'Kemampuan' => 88, 'Nilai Akademik' => 85],
            'Desain Komunikasi Visual'  => ['Minat Bidang' => 85, 'Kemampuan' => 82, 'Nilai Akademik' => 75],
            'Sistem Informasi'          => ['Minat Bidang' => 80, 'Kemampuan' => 78, 'Nilai Akademik' => 80],
            'Agribisnis Tanaman Pangan' => ['Minat Bidang' => 70, 'Kemampuan' => 68, 'Nilai Akademik' => 70],
            'Teknik Mesin'              => ['Minat Bidang' => 65, 'Kemampuan' => 72, 'Nilai Akademik' => 68],
            'Peternakan'                => ['Minat Bidang' => 60, 'Kemampuan' => 65, 'Nilai Akademik' => 62],
            'Teknologi Pangan'          => ['Minat Bidang' => 68, 'Kemampuan' => 70, 'Nilai Akademik' => 67],
            'Akuakultur'                => ['Minat Bidang' => 62, 'Kemampuan' => 64, 'Nilai Akademik' => 60],
        ];

        $rows = [];
        foreach ($jurusans as $jurusan) {
            $skor = $skorMap[$jurusan->nama] ?? [];
            foreach ($kriterias as $kriteria) {
                $rows[] = [
                    'jurusan_kuliah_id' => $jurusan->id,
                    'kriteria_id'       => $kriteria->id,
                    'score'             => $skor[$kriteria->nama] ?? 50,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
            }
        }
        DB::table('skor_jurusan')->insert($rows);
    }
}
