<?php

use App\Http\Controllers\SawController;
use App\Models\HasilMagang;
use App\Models\Kriteria;
use App\Models\Siswa;
use App\Models\SkorMagang;
use App\Models\Skill;
use App\Models\JurusanSmk;
use App\Models\TempatMagang;

// ══════════════════════════════════════════════════════════════
// BAGIAN 1 — Silent return jika data tidak lengkap
// ══════════════════════════════════════════════════════════════

it('hitungSAWMagangPublic tidak error jika tidak ada kriteria magang', function () {
    $siswa = Siswa::factory()->create();

    $saw = new SawController();

    expect(fn() => $saw->hitungSAWMagangPublic($siswa->id))
        ->not->toThrow(\Exception::class);
});

it('hitungSAWMagangPublic tidak error jika tidak ada tempat magang', function () {
    Kriteria::factory()->magang()->create(['weight' => 1.0]);
    $siswa = Siswa::factory()->create();

    $saw = new SawController();

    expect(fn() => $saw->hitungSAWMagangPublic($siswa->id))
        ->not->toThrow(\Exception::class);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 2 — Hasil tersimpan ke database
// ══════════════════════════════════════════════════════════════

it('hitungSAWMagang menyimpan hasil ke tabel hasil_magang', function () {
    $siswa    = Siswa::factory()->create();
    $kriteria = Kriteria::factory()->magang()->create([
        'weight' => 1.0,
        'type'   => 'benefit',
    ]);

    $tempats = TempatMagang::factory()->count(3)->create();
    foreach ($tempats as $t) {
        SkorMagang::create([
            'tempat_magang_id' => $t->id,
            'kriteria_id'      => $kriteria->id,
            'score'            => fake()->numberBetween(60, 100),
        ]);
    }

    $saw = new SawController();
    $saw->hitungSAWMagangPublic($siswa->id);

    $hasil = HasilMagang::where('siswa_id', $siswa->id)->get();
    expect($hasil)->toHaveCount(3);
});

it('hasil magang memiliki rank unik dan berurutan dari 1', function () {
    $siswa    = Siswa::factory()->create();
    $kriteria = Kriteria::factory()->magang()->create([
        'weight' => 1.0,
        'type'   => 'benefit',
    ]);

    $tempats = TempatMagang::factory()->count(4)->create();
    foreach ($tempats as $t) {
        SkorMagang::create([
            'tempat_magang_id' => $t->id,
            'kriteria_id'      => $kriteria->id,
            'score'            => fake()->numberBetween(50, 100),
        ]);
    }

    $saw = new SawController();
    $saw->hitungSAWMagangPublic($siswa->id);

    $ranks = HasilMagang::where('siswa_id', $siswa->id)
        ->orderBy('rank')
        ->pluck('rank')
        ->toArray();

    expect($ranks)->toBe([1, 2, 3, 4]);
});

it('score hasil magang berada dalam rentang 0 sampai 100', function () {
    $siswa    = Siswa::factory()->create();
    $kriteria = Kriteria::factory()->magang()->create([
        'weight' => 1.0,
        'type'   => 'benefit',
    ]);

    $tempats = TempatMagang::factory()->count(3)->create();
    foreach ($tempats as $t) {
        SkorMagang::create([
            'tempat_magang_id' => $t->id,
            'kriteria_id'      => $kriteria->id,
            'score'            => fake()->numberBetween(40, 100),
        ]);
    }

    $saw = new SawController();
    $saw->hitungSAWMagangPublic($siswa->id);

    $hasil = HasilMagang::where('siswa_id', $siswa->id)->get();
    foreach ($hasil as $h) {
        expect($h->score)->toBeGreaterThanOrEqual(0);
        expect($h->score)->toBeLessThanOrEqual(100);
    }
});

it('menghitung ulang SAW magang mengganti hasil lama', function () {
    $siswa    = Siswa::factory()->create();
    $kriteria = Kriteria::factory()->magang()->create([
        'weight' => 1.0,
        'type'   => 'benefit',
    ]);

    $tempat = TempatMagang::factory()->create();
    SkorMagang::create([
        'tempat_magang_id' => $tempat->id,
        'kriteria_id'      => $kriteria->id,
        'score'            => 80,
    ]);

    $saw = new SawController();
    $saw->hitungSAWMagangPublic($siswa->id);
    $saw->hitungSAWMagangPublic($siswa->id); // hitung ulang

    $count = HasilMagang::where('siswa_id', $siswa->id)->count();
    expect($count)->toBe(1);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 3 — Skill overlap mempengaruhi ranking
// ══════════════════════════════════════════════════════════════

it('tempat magang dengan skill overlap lebih tinggi mendapat rank lebih baik', function () {
    $kriteria = Kriteria::factory()->magang()->create([
        'nama'   => 'Kompetensi Teknis',
        'weight' => 1.0,
        'type'   => 'benefit',
    ]);

    // Setup jurusan SMK dengan 3 skill
    $jurusanSmk = JurusanSmk::factory()->create();
    $skills     = Skill::factory()->count(3)->create();
    $jurusanSmk->skills()->attach($skills->pluck('id'));

    // Siswa dengan jurusan SMK tersebut
    $siswa = Siswa::factory()->create(['jurusan_smk_id' => $jurusanSmk->id]);

    // Tempat magang A: overlap 3/3 skill (100%)
    $tempatA = TempatMagang::factory()->create(['nama' => 'Tempat A']);
    $tempatA->skills()->attach($skills->pluck('id'));
    SkorMagang::create([
        'tempat_magang_id' => $tempatA->id,
        'kriteria_id'      => $kriteria->id,
        'score'            => 80,
    ]);

    // Tempat magang B: tidak ada skill overlap (0%)
    $tempatB = TempatMagang::factory()->create(['nama' => 'Tempat B']);
    SkorMagang::create([
        'tempat_magang_id' => $tempatB->id,
        'kriteria_id'      => $kriteria->id,
        'score'            => 80,
    ]);

    $saw = new SawController();
    $saw->hitungSAWMagangPublic($siswa->id);

    $rank1 = HasilMagang::where('siswa_id', $siswa->id)
        ->where('rank', 1)
        ->first();

    // Tempat A harus rank 1 karena skill overlap 100%
    expect($rank1->tempat_magang_id)->toBe($tempatA->id);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 4 — Endpoint hitung ulang semua (admin)
// ══════════════════════════════════════════════════════════════

it('admin dapat trigger hitung ulang SAW semua siswa', function () {
    $admin    = \App\Models\User::factory()->admin()->create();
    $kriteria = Kriteria::factory()->magang()->create(['weight' => 0.5, 'type' => 'benefit']);
    $kriteria2 = Kriteria::factory()->jurusan()->create(['weight' => 0.5, 'type' => 'benefit']);

    // Buat 2 siswa
    $siswa1 = Siswa::factory()->create();
    $siswa2 = Siswa::factory()->create();

    $this->actingAs($admin)
        ->post(route('admin.saw.hitung-ulang'))
        ->assertRedirect()
        ->assertSessionHas('success');
});

it('guest tidak bisa trigger hitung ulang SAW', function () {
    $this->post(route('admin.saw.hitung-ulang'))
        ->assertRedirect(route('login'));
});

it('guru tidak bisa trigger hitung ulang SAW', function () {
    $guru = \App\Models\User::factory()->guru()->create();

    $this->actingAs($guru)
        ->post(route('admin.saw.hitung-ulang'))
        ->assertStatus(403);
});