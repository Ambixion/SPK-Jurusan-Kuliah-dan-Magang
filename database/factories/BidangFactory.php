<?php

namespace Database\Factories;

use App\Models\Bidang;
use Illuminate\Database\Eloquent\Factories\Factory;

class BidangFactory extends Factory
{
    protected $model = Bidang::class;

    public function definition(): array
    {
        return [
            'nama'      => fake()->randomElement([
                'Teknologi Informasi',
                'Rekayasa Sistem',
                'Bisnis Digital',
                'Keamanan Siber',
                'Data Science',
            ]) . ' ' . fake()->unique()->numberBetween(1, 999),
            'deskripsi' => fake()->sentence(),
        ];
    }
}