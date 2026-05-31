<?php

use App\Models\HasilJurusan;
use App\Models\JawabanSiswa;
use App\Models\JurusanKuliah;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use App\Models\Siswa;

// ══════════════════════════════════════════════════════════════
// BAGIAN 1 — Akses halaman hasil jurusan
// ══════════════════════════════════════════════════════════════

it('siswa dapat mengakses halaman hasil jurusan', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->get(route('siswa.jurusan.hasil'))
        ->assertStatus(200)
        ->assertViewIs('siswa.jurusan.hasil');
});

it('halaman hasil jurusan menampilkan sudahMengisi false jika belum isi kuisoner', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->get(route('siswa.jurusan.hasil'))
        ->assertStatus(200)
        ->assertViewHas('sudahMengisi', false);
});

it('halaman hasil jurusan menampilkan hasil jika sudah mengisi kuisoner', function () {
    $siswa   = Siswa::factory()->create();
    $jurusan = JurusanKuliah::factory()->create();

    // Buat kuisoner jurusan + opsi + jawaban
    $kuisoner = Kuisoner::factory()->jurusan()->create();
    $opsi     = KuisonerOpsi::factory()->create([
        'kuisoner_id' => $kuisoner->id,
        'nilai'       => 5,
    ]);
    JawabanSiswa::create([
        'siswa_id'         => $siswa->id,
        'kuisoner_opsi_id' => $opsi->id,
    ]);

    // Buat hasil jurusan langsung (bypass SAW)
    HasilJurusan::create([
        'siswa_id'          => $siswa->id,
        'jurusan_kuliah_id' => $jurusan->id,
        'score'             => 90.00,
        'rank'              => 1,
    ]);

    $response = $this->actingAs($siswa->user)
        ->get(route('siswa.jurusan.hasil'));

    $response->assertStatus(200);
    $response->assertViewHas('sudahMengisi', true);

    $hasilJurusan = $response->viewData('hasilJurusan');
    expect($hasilJurusan)->toHaveCount(1);
    expect($hasilJurusan->first()->jurusan_kuliah_id)->toBe($jurusan->id);
});

it('guest tidak bisa akses halaman hasil jurusan', function () {
    $this->get(route('siswa.jurusan.hasil'))
        ->assertRedirect(route('login'));
});