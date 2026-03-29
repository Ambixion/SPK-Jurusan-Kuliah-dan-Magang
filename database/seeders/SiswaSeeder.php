<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->where('role', 'siswa')->get();

        DB::table('siswa')->insert([
            [
                'users_id' => $users[0]->id,
                'jurusan_siswa' => 'IPA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'users_id' => $users[1]->id,
                'jurusan_siswa' => 'IPS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'users_id' => $users[2]->id,
                'jurusan_siswa' => 'Teknik Komputer dan Jaringan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
