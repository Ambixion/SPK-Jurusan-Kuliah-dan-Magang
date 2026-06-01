<?php

namespace Database\Factories;

use App\Models\Kriteria;
use App\Models\SkorMagang;
use App\Models\TempatMagang;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkorMagangFactory extends Factory
{
    protected $model = SkorMagang::class;

    public function definition(): array
    {
        return [
            'tempat_magang_id' => TempatMagang::factory(),
            'kriteria_id'      => Kriteria::factory()->magang(),
            'score'            => fake()->numberBetween(50, 100),
        ];
    }
}