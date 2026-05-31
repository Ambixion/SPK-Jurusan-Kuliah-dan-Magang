<?php

use App\Models\JurusanSmk;
use App\Models\Skill;
use App\Models\User;

// ══════════════════════════════════════════════════════════════
// INDEX
// ══════════════════════════════════════════════════════════════

it('admin dapat melihat daftar jurusan smk', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.jurusan_smk.index'))
        ->assertStatus(200)
        ->assertViewIs('admin.jurusan_smk.index');
});

// ══════════════════════════════════════════════════════════════
// STORE
// ══════════════════════════════════════════════════════════════

it('admin dapat menambah jurusan smk beserta skill', function () {
    $admin  = User::factory()->admin()->create();
    $skills = Skill::factory()->count(2)->create();

    $this->actingAs($admin)
        ->post(route('admin.jurusan_smk.store'), [
            'nama_jurusan' => 'Teknik Komputer dan Jaringan',
            'skill_ids'    => $skills->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.jurusan_smk.index'))
        ->assertSessionHas('success');

    $jurusan = JurusanSmk::where('nama_jurusan', 'Teknik Komputer dan Jaringan')->first();
    expect($jurusan)->not->toBeNull();
    expect($jurusan->skills)->toHaveCount(2);
});

it('store jurusan smk gagal jika nama kosong', function () {
    $admin  = User::factory()->admin()->create();
    $skills = Skill::factory()->count(1)->create();

    $this->actingAs($admin)
        ->post(route('admin.jurusan_smk.store'), [
            'nama_jurusan' => '',
            'skill_ids'    => $skills->pluck('id')->toArray(),
        ])->assertSessionHasErrors('nama_jurusan');
});

it('store jurusan smk gagal jika skill ids kosong', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.jurusan_smk.store'), [
            'nama_jurusan' => 'Multimedia',
            'skill_ids'    => [],
        ])->assertSessionHasErrors('skill_ids');
});

it('store jurusan smk gagal jika skill id tidak ada di database', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.jurusan_smk.store'), [
            'nama_jurusan' => 'Multimedia',
            'skill_ids'    => [99999],
        ])->assertSessionHasErrors('skill_ids.0');
});

// ══════════════════════════════════════════════════════════════
// UPDATE
// ══════════════════════════════════════════════════════════════

it('admin dapat mengupdate jurusan smk dan sync skill', function () {
    $admin      = User::factory()->admin()->create();
    $jurusan    = JurusanSmk::factory()->create();
    $skillLama  = Skill::factory()->create();
    $skillBaru  = Skill::factory()->create();
    $jurusan->skills()->attach($skillLama->id);

    $this->actingAs($admin)
        ->put(route('admin.jurusan_smk.update', $jurusan->id), [
            'nama_jurusan' => 'Diupdate',
            'skill_ids'    => [$skillBaru->id],
        ])
        ->assertRedirect(route('admin.jurusan_smk.index'))
        ->assertSessionHas('success');

    $jurusan->refresh();
    expect($jurusan->nama_jurusan)->toBe('Diupdate');
    // skill lama diganti skill baru (sync)
    expect($jurusan->skills->pluck('id')->toArray())->toContain($skillBaru->id);
    expect($jurusan->skills->pluck('id')->toArray())->not->toContain($skillLama->id);
});

// ══════════════════════════════════════════════════════════════
// DESTROY
// ══════════════════════════════════════════════════════════════

it('admin dapat menghapus jurusan smk', function () {
    $admin   = User::factory()->admin()->create();
    $jurusan = JurusanSmk::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.jurusan_smk.destroy', $jurusan->id))
        ->assertRedirect(route('admin.jurusan_smk.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('jurusan_smk', ['id' => $jurusan->id]);
});