<?php

use App\Models\JurusanSmk;
use App\Models\Skill;
use App\Models\TempatMagang;
use App\Models\User;

// ══════════════════════════════════════════════════════════════
// STORE
// ══════════════════════════════════════════════════════════════

it('admin dapat menambah skill baru', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.skill.store'), ['jenis_skill' => 'Laravel'])
        ->assertRedirect(route('admin.skill.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('skill', ['jenis_skill' => 'Laravel']);
});

it('store skill gagal jika nama kosong', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.skill.store'), ['jenis_skill' => ''])
        ->assertSessionHasErrors('jenis_skill');
});

it('store skill gagal jika nama sudah ada (unique)', function () {
    $admin = User::factory()->admin()->create();
    Skill::factory()->create(['jenis_skill' => 'Laravel']);

    $this->actingAs($admin)
        ->post(route('admin.skill.store'), ['jenis_skill' => 'Laravel'])
        ->assertSessionHasErrors('jenis_skill');
});

// ══════════════════════════════════════════════════════════════
// UPDATE
// ══════════════════════════════════════════════════════════════

it('admin dapat mengupdate skill', function () {
    $admin = User::factory()->admin()->create();
    $skill = Skill::factory()->create(['jenis_skill' => 'Lama']);

    $this->actingAs($admin)
        ->put(route('admin.skill.update', $skill->id), ['jenis_skill' => 'Baru'])
        ->assertRedirect(route('admin.skill.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('skill', ['jenis_skill' => 'Baru']);
});

it('update skill tidak gagal jika nama sama dengan miliknya sendiri', function () {
    $admin = User::factory()->admin()->create();
    $skill = Skill::factory()->create(['jenis_skill' => 'Laravel']);

    // update dengan nama yang sama — tidak boleh trigger unique error
    $this->actingAs($admin)
        ->put(route('admin.skill.update', $skill->id), ['jenis_skill' => 'Laravel'])
        ->assertRedirect(route('admin.skill.index'))
        ->assertSessionHas('success');
});

// ══════════════════════════════════════════════════════════════
// DESTROY — termasuk proteksi "masih digunakan"
// ══════════════════════════════════════════════════════════════

it('admin dapat menghapus skill yang tidak digunakan', function () {
    $admin = User::factory()->admin()->create();
    $skill = Skill::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.skill.destroy', $skill->id))
        ->assertRedirect(route('admin.skill.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('skill', ['id' => $skill->id]);
});

it('skill tidak bisa dihapus jika masih dipakai jurusan smk', function () {
    $admin   = User::factory()->admin()->create();
    $skill   = Skill::factory()->create();
    $jurusan = JurusanSmk::factory()->create();
    $jurusan->skills()->attach($skill->id);

    $this->actingAs($admin)
        ->delete(route('admin.skill.destroy', $skill->id))
        ->assertRedirect()
        ->assertSessionHas('error');

    $this->assertDatabaseHas('skill', ['id' => $skill->id]);
});

it('skill tidak bisa dihapus jika masih dipakai tempat magang', function () {
    $admin  = User::factory()->admin()->create();
    $skill  = Skill::factory()->create();
    $tempat = TempatMagang::factory()->create();
    $tempat->skills()->attach($skill->id);

    $this->actingAs($admin)
        ->delete(route('admin.skill.destroy', $skill->id))
        ->assertRedirect()
        ->assertSessionHas('error');

    $this->assertDatabaseHas('skill', ['id' => $skill->id]);
});