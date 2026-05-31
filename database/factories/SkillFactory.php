<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition(): array
    {
        return [
            'jenis_skill' => fake()->randomElement([
                'Programming',
                'Networking',
                'Design',
                'Database',
                'Cybersecurity',
            ]) . ' ' . fake()->unique()->numberBetween(1, 999),
        ];
    }
}