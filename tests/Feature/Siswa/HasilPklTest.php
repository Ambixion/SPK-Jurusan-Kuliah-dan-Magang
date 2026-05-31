<?php

use App\Models\HasilMagang;
use App\Models\JawabanSiswa;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use App\Models\Siswa;
use App\Models\TempatMagang;

// ══════════════════════════════════════════════════════════════
// BAGIAN 1 — Akses halaman hasil PKL
// ══════════════════════════════════════════════════════════════

it('siswa dapat mengakses halaman hasil pkl', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->get(route('siswa.pkl.hasil'))
        ->assertStatus(200)
        ->assertViewIs('siswa.pkl.hasil');
});

it('halaman hasil pkl menampilkan sudahMengisi false jika belum isi kuisoner', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->get(route('siswa.pkl.hasil'))
        ->assertStatus(200)
        ->assertViewHas('sudahMengisi', false);
});

it('halaman hasil pkl menampilkan hasil jika sudah mengisi kuisoner', function () {
    $siswa   = Siswa::factory()->create();
    $tempat  = TempatMagang::factory()->create();

    // Buat kuisoner magang + opsi + jawaban siswa
    $kuisoner = Kuisoner::factory()->magang()->create();
    $opsi     = KuisonerOpsi::factory()->create([
        'kuisoner_id' => $kuisoner->id,
        'nilai'       => 4,
    ]);
    JawabanSiswa::create([
        'siswa_id'         => $siswa->id,
        'kuisoner_opsi_id' => $opsi->id,
    ]);

    // Buat hasil magang langsung (bypass SAW calculation)
    HasilMagang::create([
        'siswa_id'         => $siswa->id,
        'tempat_magang_id' => $tempat->id,
        'score'            => 85.00,
        'rank'             => 1,
    ]);

    $response = $this->actingAs($siswa->user)
        ->get(route('siswa.pkl.hasil'));

    $response->assertStatus(200);
    $response->assertViewHas('sudahMengisi', true);
    $response->assertViewHas('hasilMagang');

    $hasilMagang = $response->viewData('hasilMagang');
    expect($hasilMagang)->toHaveCount(1);
    expect($hasilMagang->first()->tempat_magang_id)->toBe($tempat->id);
});

it('guest tidak bisa akses halaman hasil pkl', function () {
    $this->get(route('siswa.pkl.hasil'))
        ->assertRedirect(route('login'));
});