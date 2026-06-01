<?php

use App\Models\Kriteria;
use App\Models\SkorJurusan;
use App\Models\SkorMagang;
use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use App\Models\JurusanKuliah;
use App\Models\Kriteria as KriteriaModel;
use App\Models\Siswa;
use App\Models\TempatMagang;
use App\Http\Controllers\SawController;
use Illuminate\Support\Facades\DB;

// ══════════════════════════════════════════════════════════════
// BAGIAN 1 — Normalisasi benefit
// Rumus: nilai / max(kolom)
// ══════════════════════════════════════════════════════════════

it('normalisasi benefit membagi nilai dengan nilai maksimum kolom', function () {
    // Akses normalisasi via reflection karena method private
    $saw    = new SawController();
    $ref    = new ReflectionMethod($saw, 'normalisasi');
    $ref->setAccessible(true);

    $kriterias = collect([
        (object) ['id' => 1, 'type' => 'benefit', 'weight' => 0.5],
    ]);

    $matriks = [
        'A' => [1 => 80.0],
        'B' => [1 => 40.0],
        'C' => [1 => 60.0],
    ];

    $result = $ref->invoke($saw, $matriks, $kriterias);

    // max = 80
    // A: 80/80 = 1.0
    // B: 40/80 = 0.5
    // C: 60/80 = 0.75
    expect($result['A'][1])->toBe(1.0);
    expect($result['B'][1])->toBe(0.5);
    expect($result['C'][1])->toBe(0.75);
});

it('normalisasi benefit menghasilkan 0 jika seluruh kolom bernilai 0', function () {
    $saw = new SawController();
    $ref = new ReflectionMethod($saw, 'normalisasi');
    $ref->setAccessible(true);

    $kriterias = collect([
        (object) ['id' => 1, 'type' => 'benefit', 'weight' => 1.0],
    ]);

    $matriks = [
        'A' => [1 => 0.0],
        'B' => [1 => 0.0],
    ];

    $result = $ref->invoke($saw, $matriks, $kriterias);

    expect($result['A'][1])->toBe(0);
    expect($result['B'][1])->toBe(0);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 2 — Normalisasi cost
// Rumus: min(kolom positif) / nilai
// ══════════════════════════════════════════════════════════════

it('normalisasi cost membagi nilai minimum dengan setiap nilai', function () {
    $saw = new SawController();
    $ref = new ReflectionMethod($saw, 'normalisasi');
    $ref->setAccessible(true);

    $kriterias = collect([
        (object) ['id' => 1, 'type' => 'cost', 'weight' => 0.5],
    ]);

    $matriks = [
        'A' => [1 => 20.0],
        'B' => [1 => 40.0],
        'C' => [1 => 10.0],
    ];

    $result = $ref->invoke($saw, $matriks, $kriterias);

    // min positif = 10
    // A: 10/20 = 0.5
    // B: 10/40 = 0.25
    // C: 10/10 = 1.0
    expect($result['A'][1])->toBe(0.5);
    expect($result['B'][1])->toBe(0.25);
    expect($result['C'][1])->toBe(1.0);
});

it('normalisasi cost menghasilkan 0 untuk nilai 0', function () {
    $saw = new SawController();
    $ref = new ReflectionMethod($saw, 'normalisasi');
    $ref->setAccessible(true);

    $kriterias = collect([
        (object) ['id' => 1, 'type' => 'cost', 'weight' => 1.0],
    ]);

    $matriks = [
        'A' => [1 => 0.0],
        'B' => [1 => 50.0],
    ];

    $result = $ref->invoke($saw, $matriks, $kriterias);

    // nilai 0 → normalisasi = 0 (tidak bisa dibagi)
    expect($result['A'][1])->toBe(0);
    expect($result['B'][1])->toBeGreaterThan(0);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 3 — Preferensi (nilai akhir terbobot)
// Rumus: Σ (weight_i / totalWeight) × normalisasi_i
// ══════════════════════════════════════════════════════════════

it('preferensi menghasilkan nilai terbobot yang benar', function () {
    $saw = new SawController();
    $ref = new ReflectionMethod($saw, 'preferensi');
    $ref->setAccessible(true);

    $kriterias = collect([
        (object) ['id' => 1, 'weight' => 0.6],
        (object) ['id' => 2, 'weight' => 0.4],
    ]);

    $norm = [
        'A' => [1 => 1.0, 2 => 0.5],
        'B' => [1 => 0.5, 2 => 1.0],
    ];

    $result = $ref->invoke($saw, $norm, $kriterias);

    // totalWeight = 1.0
    // A: (0.6/1.0 × 1.0) + (0.4/1.0 × 0.5) = 0.6 + 0.2 = 0.8
    // B: (0.6/1.0 × 0.5) + (0.4/1.0 × 1.0) = 0.3 + 0.4 = 0.7
    expect(round($result['A'], 4))->toBe(0.8);
    expect(round($result['B'], 4))->toBe(0.7);
});

it('preferensi mengembalikan array kosong jika total bobot nol', function () {
    $saw = new SawController();
    $ref = new ReflectionMethod($saw, 'preferensi');
    $ref->setAccessible(true);

    $kriterias = collect([
        (object) ['id' => 1, 'weight' => 0],
    ]);

    $norm   = ['A' => [1 => 1.0]];
    $result = $ref->invoke($saw, $norm, $kriterias);

    expect($result)->toBe([]);
});

it('alternatif dengan preferensi tertinggi berada di rank pertama', function () {
    $saw = new SawController();
    $ref = new ReflectionMethod($saw, 'preferensi');
    $ref->setAccessible(true);

    $kriterias = collect([
        (object) ['id' => 1, 'weight' => 1.0],
    ]);

    $norm = [
        'X' => [1 => 0.3],
        'Y' => [1 => 1.0],  // tertinggi
        'Z' => [1 => 0.6],
    ];

    $result = $ref->invoke($saw, $norm, $kriterias);
    arsort($result);
    $ranking = array_keys($result);

    expect($ranking[0])->toBe('Y');
    expect($ranking[1])->toBe('Z');
    expect($ranking[2])->toBe('X');
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 4 — Haversine distance
// ══════════════════════════════════════════════════════════════

it('jarak haversine antara dua titik yang sama adalah 0', function () {
    $saw = new SawController();
    $ref = new ReflectionMethod($saw, 'hitungJarakKm');
    $ref->setAccessible(true);

    $jarak = $ref->invoke($saw, -7.983908, 112.621391, -7.983908, 112.621391);

    expect($jarak)->toBe(0.0);
});

// it('jarak haversine Jakarta ke Surabaya sekitar 670-690 km', function () {
//     $saw = new SawController();
//     $ref = new ReflectionMethod($saw, 'hitungJarakKm');
//     $ref->setAccessible(true);

//     // Jakarta: -6.2088, 106.8456
//     // Surabaya: -7.2575, 112.7521
//     $jarak = $ref->invoke($saw, -6.2088, 106.8456, -7.2575, 112.7521);

//     expect($jarak)->toBeGreaterThan(670.0);
//     expect($jarak)->toBeLessThan(690.0);
// });

it('jarak haversine tidak negatif untuk semua kombinasi koordinat', function () {
    $saw = new SawController();
    $ref = new ReflectionMethod($saw, 'hitungJarakKm');
    $ref->setAccessible(true);

    $pasangan = [
        [-8.1584, 113.7225, -7.983908, 112.621391],
        [0.0, 0.0, 90.0, 180.0],
        [-90.0, -180.0, 90.0, 180.0],
    ];

    foreach ($pasangan as [$lat1, $lng1, $lat2, $lng2]) {
        $jarak = $ref->invoke($saw, $lat1, $lng1, $lat2, $lng2);
        expect($jarak)->toBeGreaterThanOrEqual(0.0);
    }
});