<?php

use App\Models\Kriteria;
use App\Models\Skill;
use App\Models\TempatMagang;
use App\Models\User;

// helper payload valid untuk store/update
function tempatMagangPayload(array $override = []): array
{
    return array_merge([
        'nama'      => 'PT Testing Indonesia',
        'deskripsi' => 'Perusahaan testing',
        'skill_ids' => [],  // diisi per test
        'latitude'  => -7.983908,
        'longitude' => 112.621391,
        'bidang'    => 'IT',
        'kuota'     => 5,
        'kontak'    => '08123456789',
    ], $override);
}

// ══════════════════════════════════════════════════════════════
// STORE
// ══════════════════════════════════════════════════════════════

it('admin dapat menambah tempat magang baru', function () {
    $admin  = User::factory()->admin()->create();
    $skills = Skill::factory()->count(2)->create();

    $this->actingAs($admin)
        ->post(route('admin.tempat_magang.store'), tempatMagangPayload([
            'skill_ids' => $skills->pluck('id')->toArray(),
        ]))
        ->assertRedirect(route('admin.tempat_magang.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('tempat_magang', ['nama' => 'PT Testing Indonesia']);
});

it('store tempat magang gagal jika skill ids kosong', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.tempat_magang.store'), tempatMagangPayload([
            'skill_ids' => [],
        ]))
        ->assertSessionHasErrors('skill_ids');
});

it('store tempat magang gagal jika latitude tidak valid', function () {
    $admin  = User::factory()->admin()->create();
    $skills = Skill::factory()->count(1)->create();

    $this->actingAs($admin)
        ->post(route('admin.tempat_magang.store'), tempatMagangPayload([
            'skill_ids' => $skills->pluck('id')->toArray(),
            'latitude'  => 999, // di luar range -90..90
        ]))
        ->assertSessionHasErrors('latitude');
});

it('store tempat magang gagal jika kuota kurang dari 1', function () {
    $admin  = User::factory()->admin()->create();
    $skills = Skill::factory()->count(1)->create();

    $this->actingAs($admin)
        ->post(route('admin.tempat_magang.store'), tempatMagangPayload([
            'skill_ids' => $skills->pluck('id')->toArray(),
            'kuota'     => 0,
        ]))
        ->assertSessionHasErrors('kuota');
});

it('admin dapat store tempat magang beserta skor kriteria magang', function () {
    $admin    = User::factory()->admin()->create();
    $skills   = Skill::factory()->count(1)->create();
    $kriteria = Kriteria::factory()->create(['jenis' => 'magang']);

    $this->actingAs($admin)
        ->post(route('admin.tempat_magang.store'), tempatMagangPayload([
            'skill_ids' => $skills->pluck('id')->toArray(),
            'skor'      => [$kriteria->id => 90],
        ]))
        ->assertRedirect(route('admin.tempat_magang.index'));

    $this->assertDatabaseHas('skor_magang', [
        'kriteria_id' => $kriteria->id,
        'score'       => 90,
    ]);
});

// ══════════════════════════════════════════════════════════════
// UPDATE
// ══════════════════════════════════════════════════════════════

it('admin dapat mengupdate tempat magang', function () {
    $admin   = User::factory()->admin()->create();
    $tempat  = TempatMagang::factory()->create(['nama' => 'Lama']);
    $skills  = Skill::factory()->count(1)->create();

    $this->actingAs($admin)
        ->put(route('admin.tempat_magang.update', $tempat->id), tempatMagangPayload([
            'nama'      => 'Baru',
            'skill_ids' => $skills->pluck('id')->toArray(),
        ]))
        ->assertRedirect(route('admin.tempat_magang.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('tempat_magang', ['nama' => 'Baru']);
});

// ══════════════════════════════════════════════════════════════
// DESTROY
// ══════════════════════════════════════════════════════════════

it('admin dapat menghapus tempat magang', function () {
    $admin  = User::factory()->admin()->create();
    $tempat = TempatMagang::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.tempat_magang.destroy', $tempat->id))
        ->assertRedirect(route('admin.tempat_magang.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('tempat_magang', ['id' => $tempat->id]);
});