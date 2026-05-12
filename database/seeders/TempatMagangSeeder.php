<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TempatMagang;
use App\Models\Skill;
use App\Models\Bidang;

class TempatMagangSeeder extends Seeder
{
    public function run(): void
    {
        // Data tempat magang beserta skill & bidang yang diterima
        $data = [
            [
                'nama'      => 'PT Telkom Indonesia',
                'deskripsi' => 'Perusahaan telekomunikasi terbesar di Indonesia.',
                'latitude'  => -8.1845, 'longitude' => 113.6691,
                'bidang'    => 'Teknologi', 'kuota' => 10, 'kontak' => '0331-100001',
                // Skill yang cocok: RPL & TKJ
                'skills'  => ['Web Development', 'Backend Development', 'Frontend Development',
                              'Network Administration', 'Cloud Computing', 'Cybersecurity',
                              'Database Management', 'DevOps'],
                'bidangs' => ['Teknologi Informasi'],
            ],
            [
                'nama'      => 'Dinas Kominfo Jember',
                'deskripsi' => 'Instansi pemerintah bidang komunikasi dan informatika.',
                'latitude'  => -8.1653, 'longitude' => 113.7022,
                'bidang'    => 'Teknologi', 'kuota' => 5, 'kontak' => '0331-100002',
                'skills'  => ['Network Administration', 'Web Development', 'Database Management',
                              'Backend Development', 'Cloud Computing'],
                'bidangs' => ['Teknologi Informasi'],
            ],
            [
                'nama'      => 'CV Maju Jaya Tech',
                'deskripsi' => 'Perusahaan IT lokal bidang pengembangan software.',
                'latitude'  => -8.1720, 'longitude' => 113.6850,
                'bidang'    => 'Teknologi', 'kuota' => 8, 'kontak' => '0331-100003',
                'skills'  => ['Web Development', 'Mobile Development', 'Backend Development',
                              'Frontend Development', 'PHP Development', 'Python Development',
                              'Database Management', 'UI/UX Design'],
                'bidangs' => ['Teknologi Informasi'],
            ],
            [
                'nama'      => 'Studio Kreatif Nusantara',
                'deskripsi' => 'Studio desain grafis dan multimedia profesional.',
                'latitude'  => -8.2198, 'longitude' => 114.3691,
                'bidang'    => 'Desain', 'kuota' => 6, 'kontak' => '0333-100004',
                // Skill yang cocok: Multimedia
                'skills'  => ['Desain Grafis', 'Animasi 2D/3D', 'Pengolahan Audio Video',
                              'Fotografi', 'Videografi', 'UI/UX Design'],
                'bidangs' => ['Desain Kreatif'],
            ],
            [
                'nama'      => 'PT Media Kreasi Digital',
                'deskripsi' => 'Perusahaan media digital dan konten kreatif.',
                'latitude'  => -7.2575, 'longitude' => 112.7521,
                'bidang'    => 'Media', 'kuota' => 8, 'kontak' => '031-100007',
                'skills'  => ['Desain Grafis', 'Pengolahan Audio Video', 'Videografi',
                              'Fotografi', 'Animasi 2D/3D'],
                'bidangs' => ['Desain Kreatif'],
            ],
            [
                'nama'      => 'PT Agro Jember Makmur',
                'deskripsi' => 'Perusahaan agribisnis dan pengolahan hasil pertanian.',
                'latitude'  => -8.2012, 'longitude' => 113.6540,
                'bidang'    => 'Pertanian', 'kuota' => 10, 'kontak' => '0331-100005',
                // Skill yang cocok: Agribisnis
                'skills'  => ['Manajemen Agribisnis', 'Pemasaran Produk Pertanian',
                              'Analisis Keuangan Usaha'],
                'bidangs' => ['Pertanian & Agribisnis'],
            ],
            [
                'nama'      => 'Balai Penelitian Tanaman',
                'deskripsi' => 'Lembaga penelitian pertanian dan perkebunan.',
                'latitude'  => -8.1589, 'longitude' => 113.7100,
                'bidang'    => 'Pertanian', 'kuota' => 4, 'kontak' => '0331-100006',
                'skills'  => ['Manajemen Agribisnis', 'Pemasaran Produk Pertanian'],
                'bidangs' => ['Pertanian & Agribisnis'],
            ],
            [
                'nama'      => 'Bengkel Teknik Jember',
                'deskripsi' => 'Bengkel teknik mesin dan perawatan kendaraan.',
                'latitude'  => -8.1780, 'longitude' => 113.6920,
                'bidang'    => 'Teknik', 'kuota' => 6, 'kontak' => '0331-100008',
                // Skill yang cocok: TBSM
                'skills'  => ['Overhaul'],
                'bidangs' => ['Teknik Mesin & Manufaktur'],
            ],
            [
                'nama'      => 'Toyota Auto 2000 Malang',
                'deskripsi' => 'Menawarkan pengalaman langsung diagnosa mesin, servis rem, dan kelistrikan.',
                'latitude'  => -7.9621613, 'longitude' => 112.6357214,
                'bidang'    => 'Mesin', 'kuota' => 5, 'kontak' => '(0341) 472000',
                // Skill yang cocok: TBSM
                'skills'  => ['Tune Up', 'Kelistrikan Kendaraan'],
                'bidangs' => ['Teknik Mesin'],
            ],
        ];

        foreach ($data as $item) {
            $tempat = TempatMagang::updateOrCreate(
                ['nama' => $item['nama']],
                [
                    'deskripsi' => $item['deskripsi'],
                    'latitude'  => $item['latitude'],
                    'longitude' => $item['longitude'],
                    'bidang'    => $item['bidang'],
                    'kuota'     => $item['kuota'],
                    'kontak'    => $item['kontak'],
                ]
            );

            // Assign skill ke tempat magang via pivot tempat_magang_skill
            $skillIds = Skill::whereIn('jenis_skill', $item['skills'])->pluck('id');
            $tempat->skills()->sync($skillIds);

            // Assign bidang ke tempat magang via pivot tempat_magang_bidang
            $bidangIds = Bidang::whereIn('nama', $item['bidangs'])->pluck('id');
            $tempat->bidangs()->sync($bidangIds);
        }

        $this->command->info('TempatMagangSeeder selesai. Total: ' . TempatMagang::count());
    }
}
