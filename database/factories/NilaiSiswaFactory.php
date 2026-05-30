<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class NilaiSiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'mata_pelajaran' => 'Rata-rata',
            'nilai' => fake()->numberBetween(60, 100),
            'semester' => fake()->numberBetween(1, 6),
            'tahun_ajaran' => date('Y'),
        ];
    }
}