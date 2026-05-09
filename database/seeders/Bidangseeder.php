<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\JurusanKuliah;
use App\Models\JurusanSmk;
use App\Models\Skill;
use App\Models\TempatMagang;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    public function run(): void
    {
        // Definisi bidang beserta skill dan relasi ke jurusan/tempat magang
        $data = [
            [
                'nama'      => 'Teknologi Informasi',
                'deskripsi' => 'Bidang teknologi komputer, jaringan, dan pengembangan software',
                'skills'    => ['Web Development', 'Mobile Development', 'Database Management',
                                'Backend Development', 'Frontend Development', 'Network Administration'],
                'jurusan_kuliah' => ['Teknik Informatika', 'Sistem Informasi'],
                'jurusan_smk'    => ['RPL', 'TKJ'],
                'tempat_magang'  => ['PT Telkom Indonesia', 'CV Maju Jaya Tech', 'Dinas Kominfo Jember'],
            ],
            [
                'nama'      => 'Desain Kreatif',
                'deskripsi' => 'Bidang desain grafis, multimedia, dan komunikasi visual',
                'skills'    => ['UI/UX Design', 'Frontend Development'],
                'jurusan_kuliah' => ['Desain Komunikasi Visual'],
                'jurusan_smk'    => ['Multimedia'],
                'tempat_magang'  => ['Studio Kreatif Nusantara', 'PT Media Kreasi Digital'],
            ],
            [
                'nama'      => 'Pertanian & Agribisnis',
                'deskripsi' => 'Bidang pertanian, perkebunan, dan agribisnis',
                'skills'    => ['Data Analysis'],
                'jurusan_kuliah' => ['Agribisnis Tanaman Pangan', 'Teknologi Pangan'],
                'jurusan_smk'    => ['ATPH'],
                'tempat_magang'  => ['PT Agro Jember Makmur', 'Balai Penelitian Tanaman'],
            ],
            [
                'nama'      => 'Teknik Mesin & Manufaktur',
                'deskripsi' => 'Bidang permesinan, manufaktur, dan teknik industri',
                'skills'    => [],
                'jurusan_kuliah' => ['Teknik Mesin'],
                'jurusan_smk'    => ['TPM'],
                'tempat_magang'  => ['Bengkel Teknik Jember'],
            ],
            [
                'nama'      => 'Perikanan & Akuakultur',
                'deskripsi' => 'Bidang budidaya ikan dan perikanan',
                'skills'    => [],
                'jurusan_kuliah' => ['Akuakultur'],
                'jurusan_smk'    => [],
                'tempat_magang'  => [],
            ],
            [
                'nama'      => 'Peternakan',
                'deskripsi' => 'Bidang budidaya ternak dan kesehatan hewan',
                'skills'    => [],
                'jurusan_kuliah' => ['Peternakan'],
                'jurusan_smk'    => [],
                'tempat_magang'  => [],
            ],
        ];

        foreach ($data as $item) {
            $bidang = Bidang::firstOrCreate(['nama' => $item['nama']], ['deskripsi' => $item['deskripsi']]);

            // Attach skills
            $skillIds = Skill::whereIn('jenis_skill', $item['skills'])->pluck('id');
            $bidang->skills()->sync($skillIds);

            // Attach ke jurusan kuliah
            $jurusanKuliahIds = JurusanKuliah::whereIn('nama', $item['jurusan_kuliah'])->pluck('id');
            $bidang->jurusanKuliah()->syncWithoutDetaching($jurusanKuliahIds);

            // Attach ke jurusan SMK
            $jurusanSmkIds = JurusanSmk::whereIn('nama_jurusan', $item['jurusan_smk'])->pluck('id');
            $bidang->jurusanSmk()->syncWithoutDetaching($jurusanSmkIds);

            // Attach ke tempat magang
            $tempatMagangIds = TempatMagang::whereIn('nama', $item['tempat_magang'])->pluck('id');
            $bidang->tempatMagang()->syncWithoutDetaching($tempatMagangIds);
        }
    }
}
