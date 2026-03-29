<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jurusan_kuliah')->insert([
            ['nama' => 'Teknik Informatika',
            'deskripsi' => 'Teknik Informatika adalah jurusan yang mempelajari tentang pengembangan perangkat lunak, sistem komputer, dan teknologi informasi.',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['nama' => 'Sistem Informasi',
            'deskripsi' => 'Sistem Informasi adalah jurusan yang mempelajari tentang pengembangan dan pengelolaan sistem informasi di organisasi.',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['nama' => 'Teknik Elektro',
            'deskripsi' => 'Teknik Elektro adalah jurusan yang mempelajari tentang prinsip dan aplikasi teknologi listrik dan elektronik.',
            'created_at' => now(),
            'updated_at' => now(),
            ],
        ]);
    }
}
