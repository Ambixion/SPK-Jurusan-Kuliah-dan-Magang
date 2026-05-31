<?php

namespace Database\Factories;

use App\Models\Kuisoner;
use Illuminate\Database\Eloquent\Factories\Factory;

class KuisonerFactory extends Factory
{
    protected $model = Kuisoner::class;

    public function definition(): array
    {
        return [
            'soal'              => fake()->sentence() . '?',
            'type'              => 'magang',
            'jurusan_kuliah_id' => null,
            'bidang_id'         => null,
            'skill_id'          => null,
            'kriteria_id'       => null,
            'urutan'            => fake()->numberBetween(1, 10),
        ];
    }

    public function magang(): static
    {
        return $this->state(fn() => ['type' => 'magang']);
    }

    public function jurusan(): static
    {
        return $this->state(fn() => ['type' => 'jurusan']);
    }
}