<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TempatMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('skor_magang')->delete();
        DB::table('tempat_magang')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('tempat_magang')->insert([
            [
                'nama'      => 'PT Telkom Indonesia',
                'deskripsi' => 'Perusahaan telekomunikasi terbesar di Indonesia.',
                'latitude'  => -8.1845,
                'longitude' => 113.6691,
                'bidang'    => 'Teknologi',
                'kuota'     => 10,
                'kontak'    => '0331-100001',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama'      => 'Dinas Kominfo Jember',
                'deskripsi' => 'Instansi pemerintah bidang komunikasi dan informatika.',
                'latitude'  => -8.1653,
                'longitude' => 113.7022,
                'bidang'    => 'Teknologi',
                'kuota'     => 5,
                'kontak'    => '0331-100002',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama'      => 'CV Maju Jaya Tech',
                'deskripsi' => 'Perusahaan IT lokal bidang pengembangan software.',
                'latitude'  => -8.1720,
                'longitude' => 113.6850,
                'bidang'    => 'Teknologi',
                'kuota'     => 8,
                'kontak'    => '0331-100003',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama'      => 'Studio Kreatif Nusantara',
                'deskripsi' => 'Studio desain grafis dan multimedia profesional.',
                'latitude'  => -8.2198,
                'longitude' => 114.3691,
                'bidang'    => 'Desain',
                'kuota'     => 6,
                'kontak'    => '0333-100004',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama'      => 'PT Agro Jember Makmur',
                'deskripsi' => 'Perusahaan agribisnis dan pengolahan hasil pertanian.',
                'latitude'  => -8.2012,
                'longitude' => 113.6540,
                'bidang'    => 'Pertanian',
                'kuota'     => 10,
                'kontak'    => '0331-100005',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama'      => 'Balai Penelitian Tanaman',
                'deskripsi' => 'Lembaga penelitian pertanian dan perkebunan.',
                'latitude'  => -8.1589,
                'longitude' => 113.7100,
                'bidang'    => 'Pertanian',
                'kuota'     => 4,
                'kontak'    => '0331-100006',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama'      => 'PT Media Kreasi Digital',
                'deskripsi' => 'Perusahaan media digital dan konten kreatif.',
                'latitude'  => -7.2575,
                'longitude' => 112.7521,
                'bidang'    => 'Media',
                'kuota'     => 8,
                'kontak'    => '031-100007',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nama'      => 'Bengkel Teknik Jember',
                'deskripsi' => 'Bengkel teknik mesin dan perawatan alat berat.',
                'latitude'  => -8.1780,
                'longitude' => 113.6920,
                'bidang'    => 'Teknik',
                'kuota'     => 6,
                'kontak'    => '0331-100008',
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
