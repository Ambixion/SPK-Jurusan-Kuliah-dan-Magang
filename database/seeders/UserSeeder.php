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
            ]
        ]);
    }
}
