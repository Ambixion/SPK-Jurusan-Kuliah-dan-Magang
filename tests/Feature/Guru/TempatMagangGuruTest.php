<?php

use App\Models\User;
use App\Models\TempatMagang;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->guru = User::factory()->create([
        'role' => 'guru',
    ]);
});

it('guru dapat melihat daftar tempat magang', function () {
    TempatMagang::factory()->count(3)->create();

    $response = $this->actingAs($this->guru)
        ->get('/guru/tempat-magang');

    $response->assertOk();
    $response->assertViewIs('guru.tempatmagang.index');
    $response->assertViewHas('tempatMagang');
});

it('guru tidak dapat mengakses halaman tambah tempat magang', function () {
    $response = $this->actingAs($this->guru)
        ->get('/guru/tempat-magang/create');

    $response->assertStatus(404);
});

it('guru tidak dapat menyimpan data tempat magang', function () {
    $response = $this->actingAs($this->guru)
        ->post('/guru/tempat-magang', [
            'nama' => 'PT Testing',
            'alamat' => 'Jember',
        ]);

    $response->assertStatus(405);
});

it('guru tidak dapat menghapus tempat magang', function () {
    $tempatMagang = TempatMagang::factory()->create();

    $response = $this->actingAs($this->guru)
        ->delete('/guru/tempat-magang/' . $tempatMagang->id);

    $response->assertStatus(404);
});