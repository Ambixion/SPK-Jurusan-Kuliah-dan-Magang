<?php

namespace Database\Factories;

use App\Models\JurusanKuliah;
use App\Models\Kriteria;
use App\Models\SkorJurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkorJurusanFactory extends Factory
{
    protected $model = SkorJurusan::class;

    public function definition(): array
    {
        return [
            'jurusan_kuliah_id' => JurusanKuliah::factory(),
            'kriteria_id'       => Kriteria::factory()->jurusan(),
            'score'             => fake()->numberBetween(50, 100),
        ];
    }
}