<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kriteria')->insert([
            ['name' => 'Minat',
            'weight' => 0.4,
            'type' => 'benefit',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['name' => 'Nilai Rapor',
            'weight' => 0.3,
            'type' => 'benefit',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'jarak',
            'weight' => 0.2,
            'type' => 'benefit',
            'created_at' => now(),
            'updated_at' => now(),
            ]
        ]);
    }
}
