<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkorJurusan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusan = DB::table('jurusan_kuliah')->get();
        $kriteria = DB::table('kriteria')->get();

        DB::table('skor_jurusan')->insert(
            [[
                'jurusan_kuliah_id' => $jurusan[0]->id,
                'kriteria_id' => $kriteria[0]->id,
                'score' => 85,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'jurusan_kuliah_id' => $jurusan[0]->id,
                'kriteria_id' => $kriteria[1]->id,
                'score' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'jurusan_kuliah_id' => $jurusan[1]->id,
                'kriteria_id' => $kriteria[0]->id,
                'score' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'jurusan_kuliah_id' => $jurusan[1]->id,
                'kriteria_id' => $kriteria[1]->id,
                'score' => 85,
                'created_at' => now(),
                'updated_at' => now(),
            ]]
        );
    }
}
