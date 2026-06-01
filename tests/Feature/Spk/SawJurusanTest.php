<?php

use App\Http\Controllers\SawController;
use App\Models\HasilJurusan;
use App\Models\JawabanSiswa;
use App\Models\JurusanKuliah;
use App\Models\Kriteria;
use App\Models\KuisonerOpsi;
use App\Models\Kuisoner;
use App\Models\Siswa;
use App\Models\SkorJurusan;

// ══════════════════════════════════════════════════════════════
// BAGIAN 1 — Silent return jika data tidak lengkap
// ══════════════════════════════════════════════════════════════

it('hitungSAWJurusanPublic tidak error jika tidak ada kriteria', function () {
    $siswa = Siswa::factory()->create();
    // Tidak ada kriteria jurusan di DB

    $saw = new SawController();

    // Tidak boleh throw exception — silent return
    expect(fn() => $saw->hitungSAWJurusanPublic($siswa->id))
        ->not->toThrow(\Exception::class);
});

it('hitungSAWJurusanPublic tidak error jika tidak ada jurusan kuliah', function () {
    $siswa    = Siswa::factory()->create();
    Kriteria::factory()->jurusan()->create(['weight' => 1.0]);
    // Tidak ada jurusan kuliah

    $saw = new SawController();

    expect(fn() => $saw->hitungSAWJurusanPublic($siswa->id))
        ->not->toThrow(\Exception::class);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 2 — Hasil tersimpan ke database
// ══════════════════════════════════════════════════════════════

it('hitungSAWJurusan menyimpan hasil ke tabel hasil_jurusan', function () {
    $siswa    = Siswa::factory()->create();
    $kriteria = Kriteria::factory()->jurusan()->create([
        'weight' => 1.0,
        'type'   => 'benefit',
    ]);

    // Buat 3 jurusan dengan skor profil
    $jurusans = JurusanKuliah::factory()->count(3)->create();
    foreach ($jurusans as $j) {
        SkorJurusan::create([
            'jurusan_kuliah_id' => $j->id,
            'kriteria_id'       => $kriteria->id,
            'score'             => fake()->numberBetween(60, 100),
        ]);
    }

    $saw = new SawController();
    $saw->hitungSAWJurusanPublic($siswa->id);

    // Semua jurusan harus punya hasil
    $hasil = HasilJurusan::where('siswa_id', $siswa->id)->get();
    expect($hasil)->toHaveCount(3);
});

it('hasil jurusan memiliki rank unik dan berurutan dari 1', function () {
    $siswa    = Siswa::factory()->create();
    $kriteria = Kriteria::factory()->jurusan()->create([
        'weight' => 1.0,
        'type'   => 'benefit',
    ]);

    $jurusans = JurusanKuliah::factory()->count(3)->create();
    foreach ($jurusans as $j) {
        SkorJurusan::create([
            'jurusan_kuliah_id' => $j->id,
            'kriteria_id'       => $kriteria->id,
            'score'             => fake()->numberBetween(60, 100),
        ]);
    }

    $saw = new SawController();
    $saw->hitungSAWJurusanPublic($siswa->id);

    $ranks = HasilJurusan::where('siswa_id', $siswa->id)
        ->orderBy('rank')
        ->pluck('rank')
        ->toArray();

    expect($ranks)->toBe([1, 2, 3]);
});

it('score hasil jurusan berada dalam rentang 0 sampai 100', function () {
    $siswa    = Siswa::factory()->create();
    $kriteria = Kriteria::factory()->jurusan()->create([
        'weight' => 1.0,
        'type'   => 'benefit',
    ]);

    $jurusans = JurusanKuliah::factory()->count(5)->create();
    foreach ($jurusans as $j) {
        SkorJurusan::create([
            'jurusan_kuliah_id' => $j->id,
            'kriteria_id'       => $kriteria->id,
            'score'             => fake()->numberBetween(40, 100),
        ]);
    }

    $saw = new SawController();
    $saw->hitungSAWJurusanPublic($siswa->id);

    $hasil = HasilJurusan::where('siswa_id', $siswa->id)->get();
    foreach ($hasil as $h) {
        expect($h->score)->toBeGreaterThanOrEqual(0);
        expect($h->score)->toBeLessThanOrEqual(100);
    }
});

it('menghitung ulang SAW jurusan mengganti hasil lama', function () {
    $siswa    = Siswa::factory()->create();
    $kriteria = Kriteria::factory()->jurusan()->create([
        'weight' => 1.0,
        'type'   => 'benefit',
    ]);

    $jurusan = JurusanKuliah::factory()->create();
    SkorJurusan::create([
        'jurusan_kuliah_id' => $jurusan->id,
        'kriteria_id'       => $kriteria->id,
        'score'             => 80,
    ]);

    $saw = new SawController();
    $saw->hitungSAWJurusanPublic($siswa->id);
    $saw->hitungSAWJurusanPublic($siswa->id); // hitung ulang

    // Tidak boleh duplicate — tetap 1 record per jurusan
    $count = HasilJurusan::where('siswa_id', $siswa->id)->count();
    expect($count)->toBe(1);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 3 — Ranking sesuai skor profil
// ══════════════════════════════════════════════════════════════

it('jurusan dengan skor profil tertinggi mendapat rank 1 jika tidak ada jawaban', function () {
    $siswa    = Siswa::factory()->create();
    $kriteria = Kriteria::factory()->jurusan()->create([
        'nama'   => 'Kompetensi Umum',
        'weight' => 1.0,
        'type'   => 'benefit',
    ]);

    $jurusanTinggi  = JurusanKuliah::factory()->create();
    $jurusanRendah  = JurusanKuliah::factory()->create();

    SkorJurusan::create([
        'jurusan_kuliah_id' => $jurusanTinggi->id,
        'kriteria_id'       => $kriteria->id,
        'score'             => 100,
    ]);
    SkorJurusan::create([
        'jurusan_kuliah_id' => $jurusanRendah->id,
        'kriteria_id'       => $kriteria->id,
        'score'             => 20,
    ]);

    $saw = new SawController();
    $saw->hitungSAWJurusanPublic($siswa->id);

    $rank1 = HasilJurusan::where('siswa_id', $siswa->id)
        ->where('rank', 1)
        ->first();

    expect($rank1->jurusan_kuliah_id)->toBe($jurusanTinggi->id);
});