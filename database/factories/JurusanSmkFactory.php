<?php

namespace Database\Factories;

use App\Models\JurusanSmk;
use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanSmkFactory extends Factory
{
    protected $model = JurusanSmk::class;

    public function definition(): array
    {
        return [
            'nama_jurusan' => fake()->randomElement([
                'Teknik Komputer dan Jaringan',
                'Rekayasa Perangkat Lunak',
                'Multimedia',
                'Teknik Elektronika',
                'Akuntansi',
            ]) . ' ' . fake()->unique()->numberBetween(1, 999),
        ];
    }
}