<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSmkSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jurusan_smk')->insert([
            [
                'nama_jurusan' => 'Multimedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'TKJ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'RPL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'TBSM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'Agribisnis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
