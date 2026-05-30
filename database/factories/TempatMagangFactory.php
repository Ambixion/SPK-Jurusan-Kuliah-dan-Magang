<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TempatMagangFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => fake()->company(),
            'deskripsi' => fake()->sentence(),
            'latitude' => fake()->latitude(-8.5, -7.5),
            'longitude' => fake()->longitude(113.0, 114.5),
            'bidang' => fake()->randomElement([
                'Teknologi Informasi',
                'Administrasi',
                'Desain',
                'Jaringan',
            ]),
            'kuota' => fake()->numberBetween(1, 10),
            'kontak' => fake()->phoneNumber(),
        ];
    }
}