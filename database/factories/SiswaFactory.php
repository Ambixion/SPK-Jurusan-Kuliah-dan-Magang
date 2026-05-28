<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Siswa>
 */
class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'users_id'          => User::factory()->siswa(),
            'jurusan_smk_id'    => null,
            'nisn'              => fake()->unique()->numerify('##########'),
            'kelas'             => fake()->randomElement(['X', 'XI', 'XII']),
            'semester'          => fake()->randomElement([1, 2, 3, 4, 5, 6]),
            'no_telp'           => fake()->phoneNumber(),
            'alamat'            => fake()->address(),
            'preferensi_lokasi' => null,
        ];
    }
}