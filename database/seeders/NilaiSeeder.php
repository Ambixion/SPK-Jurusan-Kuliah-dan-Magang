<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\NilaiSiswa;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $siswas = Siswa::all();

        // Daftar mata pelajaran SMK
        $mataPelajaran = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Fisika',
            'Kimia',
            'Produktif Kejuruan',
            'PKK (Produk Kreatif)',
            'Pendidikan Agama',
        ];

        foreach ($siswas as $siswa) {
            // Hapus nilai lama jika ada
            NilaiSiswa::where('siswa_id', $siswa->id)->delete();

            foreach ($mataPelajaran as $mapel) {
                // Nilai acak antara 75–95
                $nilai = rand(75, 95) + (rand(0, 99) / 100);

                NilaiSiswa::create([
                    'siswa_id'      => $siswa->id,
                    'mata_pelajaran'=> $mapel,
                    'nilai'         => round($nilai, 2),
                    'semester'      => $siswa->semester ?? 6,
                    'tahun_ajaran'  => 2026,
                ]);
            }
        }

        $this->command->info('Nilai siswa berhasil di-seed.');
    }
}
