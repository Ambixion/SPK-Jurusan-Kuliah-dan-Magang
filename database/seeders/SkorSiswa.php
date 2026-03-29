<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkorSiswa extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswa = DB::table('siswa')->get();
        $kriteria = DB::table('kriteria')->get();

        DB::table('skor_siswa')->insert(
            [[
                'siswa_id' => $siswa[0]->id,
                'kriteria_id' => $kriteria[0]->id,
                'score' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'siswa_id' => $siswa[0]->id,
                'kriteria_id' => $kriteria[1]->id,
                'score' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'siswa_id' => $siswa[1]->id,
                'kriteria_id' => $kriteria[0]->id,
                'score' => 70,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'siswa_id' => $siswa[1]->id,
                'kriteria_id' => $kriteria[1]->id,
                'score' => 85,
                'created_at' => now(),
                'updated_at' => now(),
            ]]
        );
    }
}
