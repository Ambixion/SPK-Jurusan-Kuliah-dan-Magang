<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JurusanSmk;
use App\Models\Skill;

class JurusanSmkSeeder extends Seeder
{
    public function run(): void
    {
        // Definisi jurusan SMK beserta skill-nya
        $jurusanData = [
            'Multimedia' => [
                'Desain Grafis',
                'Animasi 2D/3D',
                'Pengolahan Audio Video',
                'Fotografi',
                'Videografi',
            ],
            'RPL' => [
                'Web Development',
                'Mobile Development',
                'Database Management',
                'UI/UX Design',
                'PHP Development',
                'Python Development',
                'Frontend Development',
                'Backend Development',
            ],
            'TKJ' => [
                'Network Administration',
                'Cybersecurity',
                'Cloud Computing',
                'DevOps',
            ],
            'TBSM' => [
                'Tune Up',
                'Overhaul',
                'Kelistrikan Kendaraan',
            ],
            'Agribisnis' => [
                'Manajemen Agribisnis',
                'Pemasaran Produk Pertanian',
                'Analisis Keuangan Usaha',
            ],
        ];

        foreach ($jurusanData as $namaJurusan => $skillList) {
            $jurusan = JurusanSmk::firstOrCreate(['nama_jurusan' => $namaJurusan]);

            // Assign skill ke jurusan ini
            $skillIds = Skill::whereIn('jenis_skill', $skillList)->pluck('id');
            $jurusan->skills()->sync($skillIds);
        }
    }
}
