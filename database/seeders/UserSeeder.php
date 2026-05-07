<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
            'nama' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama' => 'admin1',
            'email' => 'admin1@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama' => 'admin2',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama' => 'admin3',
            'email' => 'admin3@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama' => 'guru',
            'email' => 'guru@example.com',
            'password' => bcrypt('password'),
            'role' => 'guru',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama' => 'siswa',
            'email' => 'siswa@example.com',
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama' => 'orang tua',
            'email' => 'orangtua@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama' => 'kepala sekolah',
            'email' => 'kepalasekolah@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
            ]
        ]);
    }
}
