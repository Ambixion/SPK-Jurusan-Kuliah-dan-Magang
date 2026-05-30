<?php

use App\Models\User;
use App\Models\JurusanKuliah;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->guru = User::factory()->create([
        'role' => 'guru',
    ]);
});

it('guru dapat melihat daftar jurusan kuliah', function () {
    JurusanKuliah::factory()->count(3)->create();

    $response = $this->actingAs($this->guru)
        ->get('/guru/jurusan-kuliah');

    $response->assertOk();
    $response->assertViewIs('guru.jurusankuliah.index');
    $response->assertViewHas('jurusanKuliah');
});

it('guru tidak dapat mengakses halaman tambah jurusan kuliah', function () {
    $response = $this->actingAs($this->guru)
        ->get('/guru/jurusan-kuliah/create');

    $response->assertStatus(404);
});

it('guru tidak dapat menyimpan data jurusan kuliah', function () {
    $response = $this->actingAs($this->guru)
        ->post('/guru/jurusan-kuliah', [
            'nama' => 'Teknik Informatika',
            'deskripsi' => 'Program studi bidang komputer',
            'bidang_studi' => 'Teknologi',
        ]);

    $response->assertStatus(405);
});

it('guru tidak dapat menghapus jurusan kuliah', function () {
    $jurusanKuliah = JurusanKuliah::factory()->create();

    $response = $this->actingAs($this->guru)
        ->delete('/guru/jurusan-kuliah/' . $jurusanKuliah->id);

    $response->assertStatus(404);
});