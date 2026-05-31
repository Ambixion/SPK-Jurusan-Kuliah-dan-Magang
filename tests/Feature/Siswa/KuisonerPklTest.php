<?php

use App\Models\JawabanSiswa;
use App\Models\JurusanSmk;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use App\Models\Siswa;
use App\Models\Skill;

// ══════════════════════════════════════════════════════════════
// BAGIAN 1 — Landing PKL
// ══════════════════════════════════════════════════════════════

it('siswa dapat mengakses landing pkl', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->get(route('siswa.pkl'))
        ->assertStatus(200)
        ->assertViewIs('siswa.pkl.landing');
});

it('landing pkl menampilkan sudahMengisi false jika belum isi kuisoner', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->get(route('siswa.pkl'))
        ->assertViewHas('sudahMengisi', false);
});

it('landing pkl menampilkan sudahMengisi true jika sudah isi kuisoner', function () {
    $siswa    = Siswa::factory()->create();
    $kuisoner = Kuisoner::factory()->magang()->create();
    $opsi     = KuisonerOpsi::factory()->create(['kuisoner_id' => $kuisoner->id]);

    JawabanSiswa::create([
        'siswa_id'         => $siswa->id,
        'kuisoner_opsi_id' => $opsi->id,
    ]);

    $this->actingAs($siswa->user)
        ->get(route('siswa.pkl'))
        ->assertViewHas('sudahMengisi', true);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 2 — Update preferensi lokasi
// ══════════════════════════════════════════════════════════════

it('siswa dapat update preferensi lokasi dalam kota', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->post(route('siswa.pkl.preferensi'), [
            'preferensi_lokasi' => 'dalam_kota',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($siswa->fresh()->preferensi_lokasi)->toBe('dalam_kota');
});

it('siswa dapat update preferensi lokasi luar kota', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->post(route('siswa.pkl.preferensi'), [
            'preferensi_lokasi' => 'luar_kota',
        ])
        ->assertRedirect();

    expect($siswa->fresh()->preferensi_lokasi)->toBe('luar_kota');
});

it('siswa dapat update preferensi lokasi bebas', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->post(route('siswa.pkl.preferensi'), [
            'preferensi_lokasi' => 'bebas',
        ])
        ->assertRedirect();

    expect($siswa->fresh()->preferensi_lokasi)->toBe('bebas');
});

it('update preferensi gagal jika nilai tidak valid', function () {
    $siswa = Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->post(route('siswa.pkl.preferensi'), [
            'preferensi_lokasi' => 'luar_negeri', // tidak valid
        ])
        ->assertSessionHasErrors('preferensi_lokasi');
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 3 — Update skill tambahan
// ══════════════════════════════════════════════════════════════

it('siswa dapat update skill tambahan', function () {
    $siswa  = Siswa::factory()->create();
    $skills = Skill::factory()->count(2)->create();

    $this->actingAs($siswa->user)
        ->post(route('siswa.pkl.skill.update'), [
            'skill_ids' => $skills->pluck('id')->toArray(),
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($siswa->fresh()->skillTambahan)->toHaveCount(2);
});

it('siswa dapat menghapus semua skill tambahan dengan kirim array kosong', function () {
    $siswa  = Siswa::factory()->create();
    $skills = Skill::factory()->count(2)->create();
    $siswa->skillTambahan()->sync($skills->pluck('id'));

    $this->actingAs($siswa->user)
        ->post(route('siswa.pkl.skill.update'), [
            'skill_ids' => [],
        ])
        ->assertRedirect();

    expect($siswa->fresh()->skillTambahan)->toHaveCount(0);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 4 — Kuisoner PKL (index)
// ══════════════════════════════════════════════════════════════

it('siswa dapat mengakses kuisoner pkl jika sudah ada soal', function () {
    $siswa    = Siswa::factory()->create();
    $kuisoner = Kuisoner::factory()->magang()->create(['urutan' => 1]);
    KuisonerOpsi::factory()->count(3)->create(['kuisoner_id' => $kuisoner->id]);

    $this->actingAs($siswa->user)
        ->get(route('siswa.pkl.kuisoner'))
        ->assertStatus(200)
        ->assertViewIs('siswa.pkl.step');
});

it('siswa diredirect ke landing jika belum ada soal pkl', function () {
    $siswa = Siswa::factory()->create();
    // tidak ada kuisoner magang di DB

    $this->actingAs($siswa->user)
        ->get(route('siswa.pkl.kuisoner'))
        ->assertRedirect(route('siswa.pkl'));
});

it('halaman kuisoner pkl menampilkan step dan total step yang benar', function () {
    $siswa = Siswa::factory()->create();

    // Buat 15 soal → akan terbagi menjadi 2 step (10 + 5)
    $kuisonerList = Kuisoner::factory()->magang()->count(15)->create();
    foreach ($kuisonerList as $k) {
        KuisonerOpsi::factory()->count(3)->create(['kuisoner_id' => $k->id]);
    }

    $response = $this->actingAs($siswa->user)
        ->get(route('siswa.pkl.kuisoner', ['step' => 1]));

    $response->assertStatus(200);
    $response->assertViewHas('step', 1);
    $response->assertViewHas('totalStep', 2);
});

// ══════════════════════════════════════════════════════════════
// BAGIAN 5 — Store jawaban PKL
// ══════════════════════════════════════════════════════════════

it('store pkl gagal jika ada soal yang belum dijawab', function () {
    $siswa    = Siswa::factory()->create();
    $kuisoner = Kuisoner::factory()->magang()->create();
    KuisonerOpsi::factory()->count(2)->create(['kuisoner_id' => $kuisoner->id]);

    $this->actingAs($siswa->user)
        ->post(route('siswa.pkl.store'), [
            'step'       => 1,
            'total_step' => 1,
            'soal_ids'   => [$kuisoner->id],
            'jawaban'    => [], // kosong — belum dijawab
        ])
        ->assertRedirect()
        ->assertSessionHas('error');
});

it('store pkl step bukan terakhir menyimpan ke session dan redirect ke step berikutnya', function () {
    $siswa    = Siswa::factory()->create();
    $kuisoner = Kuisoner::factory()->magang()->create();
    $opsi     = KuisonerOpsi::factory()->create(['kuisoner_id' => $kuisoner->id]);

    $this->actingAs($siswa->user)
        ->post(route('siswa.pkl.store'), [
            'step'       => 1,
            'total_step' => 2,  // belum step terakhir
            'soal_ids'   => [$kuisoner->id],
            'jawaban'    => [$kuisoner->id => $opsi->id],
        ])
        ->assertRedirect();

    // Jawaban step 1 tersimpan di session
    expect(session('pkl_jawaban_step1'))->toHaveKey($kuisoner->id);
});