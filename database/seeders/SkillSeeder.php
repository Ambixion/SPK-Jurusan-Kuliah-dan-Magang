<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            // ── RPL ──────────────────────────────────────────────────────────
            'Web Development',
            'Mobile Development',
            'Database Management',
            'PHP Development',
            'Python Development',
            'Frontend Development',
            'Backend Development',
            'UI/UX Design',
            'Java Development',

            // ── TKJ ──────────────────────────────────────────────────────────
            'Network Administration',
            'Cybersecurity',
            'Cloud Computing',
            'DevOps',

            // ── Multimedia ───────────────────────────────────────────────────
            'Desain Grafis',
            'Animasi 2D/3D',
            'Pengolahan Audio Video',
            'Fotografi',
            'Videografi',

            // ── TBSM ─────────────────────────────────────────────────────────
            'Tune Up',
            'Overhaul',
            'Kelistrikan Kendaraan',

            // ── Agribisnis ───────────────────────────────────────────────────
            'Manajemen Agribisnis',
            'Pemasaran Produk Pertanian',
            'Analisis Keuangan Usaha',

            // ── Umum ─────────────────────────────────────────────────────────
            'Machine Learning',
            'Data Analysis',
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['jenis_skill' => $skill]);
        }
    }
}
