<?php

use App\Models\User;
use App\Models\Siswa;
use App\Models\TempatMagang;
use App\Models\JurusanKuliah;
use App\Models\JurusanSmk;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->guru = User::factory()->create([
        'role' => 'guru',
    ]);

    $this->jurusanSmk = JurusanSmk::factory()->create([
        'nama_jurusan' => 'Rekayasa Perangkat Lunak',
    ]);
});

it('guru dapat mengakses dashboard guru', function () {
    Siswa::factory()->count(2)->create([
        'jurusan_smk_id' => $this->jurusanSmk->id,
        'preferensi_lokasi' => 'dalam_kota',
    ]);

    TempatMagang::factory()->count(3)->create();
    JurusanKuliah::factory()->count(4)->create();

    $response = $this->actingAs($this->guru)
        ->get(route('guru.dashboard'));

    $response->assertOk();
    $response->assertViewIs('guru.dashboard');
    $response->assertViewHas('data');
    $response->assertViewHas('hasilSpk');
});

it('dashboard guru menampilkan jumlah data siswa, tempat magang, dan prodi kuliah', function () {
    Siswa::factory()->count(2)->create([
        'jurusan_smk_id' => $this->jurusanSmk->id,
        'preferensi_lokasi' => 'dalam_kota',
    ]);

    TempatMagang::factory()->count(3)->create();
    JurusanKuliah::factory()->count(4)->create();

    $response = $this->actingAs($this->guru)
        ->get(route('guru.dashboard'));

    $response->assertOk();

    $data = $response->viewData('data');

    expect($data['total_siswa'])->toBe(2);
    expect($data['total_tempat_magang'])->toBe(3);
    expect($data['total_prodi_kuliah'])->toBe(4);
});