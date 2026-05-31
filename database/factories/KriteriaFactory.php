<?php

namespace Database\Factories;

use App\Models\Kriteria;
use Illuminate\Database\Eloquent\Factories\Factory;

class KriteriaFactory extends Factory
{
    protected $model = Kriteria::class;

    public function definition(): array
    {
        return [
            'nama'   => fake()->word() . ' ' . fake()->unique()->numberBetween(1, 999),
            'weight' => fake()->randomFloat(2, 0.1, 1.0),
            'type'   => fake()->randomElement(['benefit', 'cost']),
            'jenis'  => fake()->randomElement(['jurusan', 'magang']),
        ];
    }

    public function benefit(): static
    {
        return $this->state(fn() => ['type' => 'benefit']);
    }

    public function cost(): static
    {
        return $this->state(fn() => ['type' => 'cost']);
    }

    public function magang(): static
    {
        return $this->state(fn() => ['jenis' => 'magang']);
    }

    public function jurusan(): static
    {
        return $this->state(fn() => ['jenis' => 'jurusan']);
    }
}