<?php

use App\Models\Kriteria;

it('kriteria dapat dibuat dengan data lengkap', function () {
    $kriteria = Kriteria::factory()->create([
        'nama'   => 'Nilai Akademik',
        'weight' => 0.40,
        'type'   => 'benefit',
        'jenis'  => 'jurusan',
    ]);

    expect($kriteria->nama)->toBe('Nilai Akademik');
    expect($kriteria->weight)->toBe(0.40);
    expect($kriteria->type)->toBe('benefit');
    expect($kriteria->jenis)->toBe('jurusan');
});

it('kriteria tersimpan di database', function () {
    Kriteria::factory()->create(['nama' => 'Jarak Lokasi']);

    $this->assertDatabaseHas('kriteria', ['nama' => 'Jarak Lokasi']);
});

it('kriteria benefit dapat dibuat via state', function () {
    $kriteria = Kriteria::factory()->benefit()->create();

    expect($kriteria->type)->toBe('benefit');
});

it('kriteria cost dapat dibuat via state', function () {
    $kriteria = Kriteria::factory()->cost()->create();

    expect($kriteria->type)->toBe('cost');
});

it('kriteria jenis magang dapat dibuat via state', function () {
    $kriteria = Kriteria::factory()->magang()->create();

    expect($kriteria->jenis)->toBe('magang');
});

it('kriteria jenis jurusan dapat dibuat via state', function () {
    $kriteria = Kriteria::factory()->jurusan()->create();

    expect($kriteria->jenis)->toBe('jurusan');
});

it('dapat mengambil semua kriteria magang', function () {
    Kriteria::factory()->magang()->count(3)->create();
    Kriteria::factory()->jurusan()->count(2)->create();

    $kriteriamagang = Kriteria::where('jenis', 'magang')->get();

    expect($kriteriamagang)->toHaveCount(3);
});

it('total weight kriteria tidak boleh melebihi 1', function () {
    Kriteria::factory()->jurusan()->create(['weight' => 0.40]);
    Kriteria::factory()->jurusan()->create(['weight' => 0.35]);
    Kriteria::factory()->jurusan()->create(['weight' => 0.25]);

    $totalWeight = Kriteria::where('jenis', 'jurusan')->sum('weight');

    expect($totalWeight)->toBeLessThanOrEqual(1.0);
});