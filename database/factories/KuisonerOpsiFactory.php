<?php

namespace Database\Factories;

use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use Illuminate\Database\Eloquent\Factories\Factory;

class KuisonerOpsiFactory extends Factory
{
    protected $model = KuisonerOpsi::class;

    public function definition(): array
    {
        return [
            'kuisoner_id' => Kuisoner::factory(),
            'jawaban'     => fake()->randomElement([
                'Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'
            ]),
            'nilai' => fake()->randomElement([5, 4, 3, 2, 1]),
        ];
    }
}