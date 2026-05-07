<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'Web Development',
            'Mobile Development',
            'Database Management',
            'UI/UX Design',
            'DevOps',
            'Machine Learning',
            'Cloud Computing',
            'Data Analysis',
            'Network Administration',
            'Cybersecurity',
            'Java Development',
            'PHP Development',
            'Python Development',
            'Frontend Development',
            'Backend Development',
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['jenis_skill' => $skill]
            );
        }
    }
}
