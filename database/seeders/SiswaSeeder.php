<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\User;
use App\Models\JurusanSmk;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $users      = User::where('role', 'siswa')->get();
        $jurusanIds = JurusanSmk::pluck('id');

        if ($jurusanIds->isEmpty()) {
            $this->command->warn('Tidak ada data jurusan_smk! Jalankan JurusanSmkSeeder terlebih dahulu.');
            return;
        }

        $counter = 1;
        foreach ($users as $user) {
            if (Siswa::where('users_id', $user->id)->exists()) {
                $counter++;
                continue;
            }

            // Generate NISN unik 10 digit
            $nisn = str_pad($counter, 10, '0', STR_PAD_LEFT);

            Siswa::create([
                'users_id'       => $user->id,
                'jurusan_smk_id' => $jurusanIds->random(),
                'nisn'           => $nisn,
                'kelas'          => '12',
                'semester'       => 6,
                'no_telp'        => '08123456789',
                'alamat'         => 'Jember',
            ]);

            $counter++;
        }
    }
}
