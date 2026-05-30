<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanKuliahFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => fake()->randomElement([
                'Teknik Informatika',
                'Sistem Informasi',
                'Manajemen Informatika',
                'Teknologi Rekayasa Perangkat Lunak',
            ]),
            'deskripsi' => fake()->sentence(),
            'bidang_studi' => fake()->randomElement([
                'Teknologi Informasi',
                'Komputer',
                'Bisnis Digital',
            ]),
        ];
    }
}