<?php

use App\Models\Bidang;
use App\Models\JurusanKuliah;
use App\Models\JurusanSmk;
use App\Models\Skill;
use App\Models\User;

// ══════════════════════════════════════════════════════════════
// STORE
// ══════════════════════════════════════════════════════════════

it('admin dapat menambah bidang baru', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.bidang.store'), [
            'nama'      => 'Teknologi Informasi',
            'deskripsi' => 'Bidang TI',
        ])
        ->assertRedirect(route('admin.bidang.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('bidang', ['nama' => 'Teknologi Informasi']);
});

it('admin dapat menambah bidang beserta skill', function () {
    $admin  = User::factory()->admin()->create();
    $skills = Skill::factory()->count(2)->create();

    $this->actingAs($admin)
        ->post(route('admin.bidang.store'), [
            'nama'      => 'Keamanan Siber',
            'skill_ids' => $skills->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.bidang.index'));

    $bidang = Bidang::where('nama', 'Keamanan Siber')->first();
    expect($bidang->skills)->toHaveCount(2);
});

it('store bidang gagal jika nama kosong', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.bidang.store'), ['nama' => ''])
        ->assertSessionHasErrors('nama');
});

it('store bidang gagal jika nama sudah ada (unique)', function () {
    $admin = User::factory()->admin()->create();
    Bidang::factory()->create(['nama' => 'Duplikat']);

    $this->actingAs($admin)
        ->post(route('admin.bidang.store'), ['nama' => 'Duplikat'])
        ->assertSessionHasErrors('nama');
});

// ══════════════════════════════════════════════════════════════
// UPDATE
// ══════════════════════════════════════════════════════════════

it('admin dapat mengupdate bidang dan sync skill', function () {
    $admin      = User::factory()->admin()->create();
    $bidang     = Bidang::factory()->create();
    $skillBaru  = Skill::factory()->create();

    $this->actingAs($admin)
        ->put(route('admin.bidang.update', $bidang->id), [
            'nama'      => 'Diupdate',
            'skill_ids' => [$skillBaru->id],
        ])
        ->assertRedirect(route('admin.bidang.index'))
        ->assertSessionHas('success');

    $bidang->refresh();
    expect($bidang->nama)->toBe('Diupdate');
    expect($bidang->skills->pluck('id')->toArray())->toContain($skillBaru->id);
});

// ══════════════════════════════════════════════════════════════
// DESTROY — termasuk proteksi "masih digunakan"
// ══════════════════════════════════════════════════════════════

it('admin dapat menghapus bidang yang tidak digunakan', function () {
    $admin  = User::factory()->admin()->create();
    $bidang = Bidang::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.bidang.destroy', $bidang->id))
        ->assertRedirect(route('admin.bidang.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('bidang', ['id' => $bidang->id]);
});

it('bidang tidak bisa dihapus jika masih dipakai jurusan kuliah', function () {
    $admin   = User::factory()->admin()->create();
    $bidang  = Bidang::factory()->create();
    $jurusan = JurusanKuliah::factory()->create();
    $jurusan->bidangs()->attach($bidang->id);

    $this->actingAs($admin)
        ->delete(route('admin.bidang.destroy', $bidang->id))
        ->assertRedirect()
        ->assertSessionHas('error');

    $this->assertDatabaseHas('bidang', ['id' => $bidang->id]);
});

it('bidang tidak bisa dihapus jika masih dipakai jurusan smk', function () {
    $admin   = User::factory()->admin()->create();
    $bidang  = Bidang::factory()->create();
    $jurusan = JurusanSmk::factory()->create();
    $jurusan->bidangs()->attach($bidang->id);

    $this->actingAs($admin)
        ->delete(route('admin.bidang.destroy', $bidang->id))
        ->assertRedirect()
        ->assertSessionHas('error');

    $this->assertDatabaseHas('bidang', ['id' => $bidang->id]);
});