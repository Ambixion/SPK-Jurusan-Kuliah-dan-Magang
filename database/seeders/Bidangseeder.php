<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\JurusanKuliah;
use App\Models\JurusanSmk;
use App\Models\Skill;
use App\Models\TempatMagang;
use Illuminate\Database\Seeder;

class Bidangseeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama'      => 'Teknologi Informasi',
                'deskripsi' => 'Bidang teknologi komputer, jaringan, dan pengembangan software',
                // Skill sesuai nama persis di SkillSeeder
                'skills'         => ['Web Development', 'Mobile Development', 'Database Management',
                                     'Backend Development', 'Frontend Development', 'Network Administration',
                                     'PHP Development', 'Python Development', 'Java Development'],
                'jurusan_kuliah' => ['Teknik Informatika', 'Sistem Informasi'],
                'jurusan_smk'    => ['RPL', 'TKJ'],
                'tempat_magang'  => ['PT Telkom Indonesia', 'CV Maju Jaya Tech', 'Dinas Kominfo Jember'],
            ],
            [
                'nama'      => 'Desain Kreatif',
                'deskripsi' => 'Bidang desain grafis, multimedia, dan komunikasi visual',
                'skills'         => ['UI/UX Design', 'Desain Grafis', 'Animasi 2D/3D',
                                     'Pengolahan Audio Video', 'Fotografi', 'Videografi'],
                'jurusan_kuliah' => ['Desain Komunikasi Visual'],
                'jurusan_smk'    => ['Multimedia'],
                'tempat_magang'  => ['Studio Kreatif Nusantara', 'PT Media Kreasi Digital'],
            ],
            [
                'nama'      => 'Pertanian & Agribisnis',
                'deskripsi' => 'Bidang pertanian, perkebunan, dan agribisnis',
                'skills'         => ['Manajemen Agribisnis', 'Pemasaran Produk Pertanian',
                                     'Analisis Keuangan Usaha', 'Data Analysis'],
                'jurusan_kuliah' => ['Agribisnis Tanaman Pangan', 'Teknologi Pangan'],
                'jurusan_smk'    => ['Agribisnis'],
                'tempat_magang'  => ['PT Agro Jember Makmur', 'Balai Penelitian Tanaman'],
            ],
            [
                'nama'      => 'Teknik Mesin & Manufaktur',
                'deskripsi' => 'Bidang permesinan, otomotif, dan perawatan kendaraan',
                'skills'         => ['Tune Up', 'Overhaul', 'Kelistrikan Kendaraan'],
                'jurusan_kuliah' => ['Teknik Mesin'],
                'jurusan_smk'    => ['TBSM'],
                'tempat_magang'  => ['Bengkel Teknik Jember'],
            ],
            [
                'nama'      => 'Perikanan & Akuakultur',
                'deskripsi' => 'Bidang budidaya ikan dan perikanan',
                'skills'         => [],
                'jurusan_kuliah' => ['Akuakultur'],
                'jurusan_smk'    => [],
                'tempat_magang'  => [],
            ],
            [
                'nama'      => 'Peternakan',
                'deskripsi' => 'Bidang budidaya ternak dan kesehatan hewan',
                'skills'         => [],
                'jurusan_kuliah' => ['Peternakan'],
                'jurusan_smk'    => [],
                'tempat_magang'  => [],
            ],
        ];

        foreach ($data as $item) {
            $bidang = Bidang::firstOrCreate(
                ['nama' => $item['nama']],
                ['deskripsi' => $item['deskripsi']]
            );

            $skillIds = Skill::whereIn('jenis_skill', $item['skills'])->pluck('id');
            $bidang->skills()->sync($skillIds);

            $jurusanKuliahIds = JurusanKuliah::whereIn('nama', $item['jurusan_kuliah'])->pluck('id');
            $bidang->jurusanKuliah()->syncWithoutDetaching($jurusanKuliahIds);

            $jurusanSmkIds = JurusanSmk::whereIn('nama_jurusan', $item['jurusan_smk'])->pluck('id');
            $bidang->jurusanSmk()->syncWithoutDetaching($jurusanSmkIds);

            $tempatMagangIds = TempatMagang::whereIn('nama', $item['tempat_magang'])->pluck('id');
            $bidang->tempatMagang()->syncWithoutDetaching($tempatMagangIds);
        }
    }
}
