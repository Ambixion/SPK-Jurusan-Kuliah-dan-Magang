<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('skor_siswa')->delete();
        DB::table('skor_jurusan')->delete();
        DB::table('skor_magang')->delete();
        DB::table('kriteria')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('kriteria')->insert([
            ['nama' => 'Minat Bidang',   'weight' => 0.40, 'type' => 'benefit', 'jenis' => 'jurusan', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kemampuan',      'weight' => 0.35, 'type' => 'benefit', 'jenis' => 'jurusan', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Nilai Akademik', 'weight' => 0.25, 'type' => 'benefit', 'jenis' => 'jurusan', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Minat Magang',   'weight' => 0.40, 'type' => 'benefit', 'jenis' => 'magang',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Kemampuan',      'weight' => 0.35, 'type' => 'benefit', 'jenis' => 'magang',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Nilai Akademik', 'weight' => 0.25, 'type' => 'benefit', 'jenis' => 'magang',  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
