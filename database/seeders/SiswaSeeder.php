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
        $user = DB::table('users')->where('role', 'siswa')->first();

        DB::table('siswa')->insert([
            'users_id' => $user->id,
            'jurusan_siswa' => 'IPA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
