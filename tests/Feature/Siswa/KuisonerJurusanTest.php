<?php

use App\Models\Bidang;
use App\Models\JawabanSiswa;
use App\Models\JurusanKuliah;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use App\Models\Siswa;

// ══════════════════════════════════════════════════════════════
// BAGIAN 1 — Landing Jurusan
// ══════════════════════════════════════════════════════════════

it('siswa dapat mengakses landing jurusan kuliah', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->get(route('siswa.jurusan'))
        ->assertStatus(200)
        ->assertViewIs('siswa.jurusan.landing');
});

it('landing jurusan menampilkan daftar bidang dan jurusan kuliah', function () {
    $siswa   = Siswa::factory()->create();
    Bidang::factory()->count(2)->create();
    JurusanKuliah::factory()->count(3)->create();

    $response = $this->actingAs($siswa->user)
        ->get(route('siswa.jurusan'));

    $response->assertViewHas('bidangs');
    $response->assertViewHas('jurusanList');
});

it('landing jurusan menampilkan sudahMengisi false jika belum isi', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->get(route('siswa.jurusan'))
        ->assertViewHas('sudahMengisi', false);
});

it('landing jurusan menampilkan sudahMengisi true jika sudah isi', function () {
    $siswa    = Siswa::factory()->create();
    $kuisoner = Kuisoner::factory()->jurusan()->create();
    $opsi     = KuisonerOpsi::factory()->create(['kuisoner_id' => $kuisoner->id]);

    JawabanSiswa::create([
        'siswa_id'         => $siswa->id,
        'kuisoner_opsi_id' => $opsi->id,
    ]);

    $this->actingAs($siswa->user)
        ->get(route('siswa.jurusan'))
        ->assertViewHas('sudahMengisi', true);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 2 — Kuisoner Jurusan (index)
// ══════════════════════════════════════════════════════════════

it('siswa dapat mengakses kuisoner jurusan jika sudah ada soal', function () {
    $siswa    = Siswa::factory()->create();
    $kuisoner = Kuisoner::factory()->jurusan()->create(['urutan' => 1]);
    KuisonerOpsi::factory()->count(3)->create(['kuisoner_id' => $kuisoner->id]);

    $this->actingAs($siswa->user)
        ->get(route('siswa.jurusan.kuisoner'))
        ->assertStatus(200)
        ->assertViewIs('siswa.jurusan.step');
});

it('siswa diredirect ke landing jika belum ada soal jurusan', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->get(route('siswa.jurusan.kuisoner'))
        ->assertRedirect(route('siswa.jurusan'));
});

it('kuisoner jurusan difilter berdasarkan jurusan kuliah yang dipilih', function () {
    $siswa   = Siswa::factory()->create();
    $jurusan = JurusanKuliah::factory()->create();

    // Soal global (tidak terikat jurusan maupun bidang)
    $soalGlobal = Kuisoner::factory()->jurusan()->create([
        'jurusan_kuliah_id' => null,
        'bidang_id'         => null,
    ]);

    // Soal khusus jurusan ini
    $soalJurusan = Kuisoner::factory()->jurusan()->create([
        'jurusan_kuliah_id' => $jurusan->id,
    ]);

    // Soal jurusan lain (tidak boleh muncul)
    $jurusanLain = JurusanKuliah::factory()->create();
    $soalLain    = Kuisoner::factory()->jurusan()->create([
        'jurusan_kuliah_id' => $jurusanLain->id,
    ]);

    KuisonerOpsi::factory()->create(['kuisoner_id' => $soalGlobal->id]);
    KuisonerOpsi::factory()->create(['kuisoner_id' => $soalJurusan->id]);
    KuisonerOpsi::factory()->create(['kuisoner_id' => $soalLain->id]);

    $response = $this->actingAs($siswa->user)
        ->get(route('siswa.jurusan.kuisoner', [
            'jurusan_kuliah_id' => $jurusan->id,
        ]));

    $response->assertStatus(200);

    $stepData = $response->viewData('stepData');
    $soalIds  = $stepData->pluck('id')->toArray();

    // Soal global dan soal jurusan ini harus ada
    expect($soalIds)->toContain($soalGlobal->id);
    expect($soalIds)->toContain($soalJurusan->id);

    // Soal jurusan lain tidak boleh ada
    expect($soalIds)->not->toContain($soalLain->id);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 3 — Store jawaban jurusan
// ══════════════════════════════════════════════════════════════

it('store jurusan gagal jika ada soal yang belum dijawab', function () {
    $siswa    = Siswa::factory()->create();
    $kuisoner = Kuisoner::factory()->jurusan()->create();
    KuisonerOpsi::factory()->create(['kuisoner_id' => $kuisoner->id]);

    $this->actingAs($siswa->user)
        ->post(route('siswa.jurusan.store'), [
            'step'       => 1,
            'total_step' => 1,
            'soal_ids'   => [$kuisoner->id],
            'jawaban'    => [],
        ])
        ->assertRedirect()
        ->assertSessionHas('error');
});

it('store jurusan step bukan terakhir redirect ke step berikutnya', function () {
    $siswa    = Siswa::factory()->create();
    $kuisoner = Kuisoner::factory()->jurusan()->create();
    $opsi     = KuisonerOpsi::factory()->create(['kuisoner_id' => $kuisoner->id]);

    $this->actingAs($siswa->user)
        ->post(route('siswa.jurusan.store'), [
            'step'       => 1,
            'total_step' => 2,
            'soal_ids'   => [$kuisoner->id],
            'jawaban'    => [$kuisoner->id => $opsi->id],
        ])
        ->assertRedirect();

    expect(session('jurusan_jawaban_step1'))->toHaveKey($kuisoner->id);
});