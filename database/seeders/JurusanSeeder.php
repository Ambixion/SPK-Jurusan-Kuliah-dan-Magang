<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jurusan_kuliah')->insert([
            ['nama' => 'Teknik Informatika',        'deskripsi' => 'Mempelajari pengembangan perangkat lunak, sistem komputer, dan teknologi informasi.',        'bidang_studi' => 'Networking · Hardware · Sistem Informasi', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Desain Komunikasi Visual',  'deskripsi' => 'Mempelajari desain grafis, multimedia, ilustrasi, dan komunikasi visual kreatif.',           'bidang_studi' => 'Seni Grafis · Multimedia · Periklanan',     'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Sistem Informasi',          'deskripsi' => 'Mempelajari pengelolaan dan pengembangan sistem informasi di organisasi.',                    'bidang_studi' => 'Database · Analisis Sistem · Bisnis IT',   'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Agribisnis Tanaman Pangan', 'deskripsi' => 'Mempelajari budidaya tanaman pangan, pertanian modern, dan wirausaha agribisnis.',            'bidang_studi' => 'Pertanian · Pengolahan · Wirausaha',         'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Teknik Mesin',              'deskripsi' => 'Mempelajari perancangan, pembuatan, dan pemeliharaan mesin serta peralatan teknik.',          'bidang_studi' => 'Alat Berat · Mesin · Bengkel',              'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Peternakan',                'deskripsi' => 'Mempelajari budidaya ternak, manajemen peternakan, dan pengolahan hasil ternak.',             'bidang_studi' => 'Ternak · Kesehatan Hewan · Agribisnis',     'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Teknologi Pangan',          'deskripsi' => 'Mempelajari pengolahan dan pengawetan bahan pangan serta jaminan kualitas produk.',           'bidang_studi' => 'Pengolahan · Kimia Pangan · Industri',       'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Akuakultur',                'deskripsi' => 'Mempelajari budidaya ikan, udang, dan biota air lainnya secara modern.',                      'bidang_studi' => 'Perikanan · Budidaya Air · Lingkungan',     'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
