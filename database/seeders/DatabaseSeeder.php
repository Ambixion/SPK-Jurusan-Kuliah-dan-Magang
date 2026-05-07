<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Symfony\Component\Translation\t;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SkillSeeder::class,
            UserSeeder::class,
            SiswaSeeder::class,
            JurusanSeeder::class,
            KriteriaSeeder::class,
            SkorSiswa::class,
            SkorJurusan::class,
        ]);
    }
}
