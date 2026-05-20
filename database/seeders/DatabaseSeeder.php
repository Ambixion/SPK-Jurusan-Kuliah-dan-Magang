<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            SkillSeeder::class,             // 1. Skill
            UserSeeder::class,              // 2. Users
            JurusanSmkSeeder::class,        // 3. Jurusan SMK
            JurusanSeeder::class,           // 4. Jurusan Kuliah
            TempatMagangSeeder::class,      // 5. Tempat Magang
            KriteriaSeeder::class,          // 6. Kriteria SAW
            SkorJurusan::class,             // 7. Skor Jurusan
            SkorMagangSeeder::class,        // 8. Skor Magang
            Bidangseeder::class,            // 9. Bidang + relasi
            KuisonerDinamisSeeder::class,   // 10. Kuisoner dinamis
            SiswaSeeder::class,             // 11. Siswa (setelah jurusan SMK)
            NilaiSeeder::class,             // 12. Nilai rapot siswa ← BARU
        ]);
    }
}
