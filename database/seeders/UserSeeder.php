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
            'nama' => 'siswa1',
            'email' => 'siswa1@example.com',
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama' => 'siswa2',
            'email' => 'siswa2@example.com',
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'nama' => 'siswa3',
            'email' => 'siswa3@example.com',
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'created_at' => now(),
            'updated_at' => now(),
            ]
        ]);
    }
}
