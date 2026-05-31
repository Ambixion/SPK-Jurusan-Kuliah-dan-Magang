<?php

use App\Models\Kriteria;
use App\Models\User;

// ══════════════════════════════════════════════════════════════
// STORE
// ══════════════════════════════════════════════════════════════

it('admin dapat menambah kriteria baru', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.kriteria.store'), [
            'nama'   => 'Nilai Akademik',
            'weight' => 0.40,
            'type'   => 'benefit',
            'jenis'  => 'jurusan',
        ])
        ->assertRedirect(route('admin.kriteria.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('kriteria', ['nama' => 'Nilai Akademik']);
});

it('store kriteria gagal jika total bobot melebihi 1', function () {
    $admin = User::factory()->admin()->create();
    // sudah ada bobot 0.8 untuk jenis jurusan
    Kriteria::factory()->jurusan()->create(['weight' => 0.80]);

    $this->actingAs($admin)
        ->post(route('admin.kriteria.store'), [
            'nama'   => 'Kriteria Baru',
            'weight' => 0.30,  // 0.80 + 0.30 = 1.10 > 1
            'type'   => 'benefit',
            'jenis'  => 'jurusan',
        ])
        ->assertSessionHasErrors('weight');
});

it('store kriteria berhasil jika total bobot tepat 1', function () {
    $admin = User::factory()->admin()->create();
    Kriteria::factory()->jurusan()->create(['weight' => 0.60]);

    $this->actingAs($admin)
        ->post(route('admin.kriteria.store'), [
            'nama'   => 'Kriteria Pelengkap',
            'weight' => 0.40,  // 0.60 + 0.40 = 1.0 — tepat
            'type'   => 'cost',
            'jenis'  => 'jurusan',
        ])
        ->assertRedirect(route('admin.kriteria.index'))
        ->assertSessionHas('success');
});

it('store kriteria gagal jika type bukan benefit atau cost', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.kriteria.store'), [
            'nama'   => 'Kriteria X',
            'weight' => 0.20,
            'type'   => 'invalid',
            'jenis'  => 'jurusan',
        ])
        ->assertSessionHasErrors('type');
});

it('store kriteria gagal jika jenis bukan jurusan atau magang', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.kriteria.store'), [
            'nama'   => 'Kriteria Y',
            'weight' => 0.20,
            'type'   => 'benefit',
            'jenis'  => 'invalid',
        ])
        ->assertSessionHasErrors('jenis');
});

// ══════════════════════════════════════════════════════════════
// UPDATE
// ══════════════════════════════════════════════════════════════

it('admin dapat mengupdate kriteria', function () {
    $admin    = User::factory()->admin()->create();
    $kriteria = Kriteria::factory()->jurusan()->create(['weight' => 0.50]);

    $this->actingAs($admin)
        ->put(route('admin.kriteria.update', $kriteria->id), [
            'nama'   => 'Diupdate',
            'weight' => 0.50, // total tetap 0.50 (kriteria sendiri dikecualikan)
            'type'   => 'cost',
            'jenis'  => 'jurusan',
        ])
        ->assertRedirect(route('admin.kriteria.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('kriteria', ['nama' => 'Diupdate', 'type' => 'cost']);
});

it('update kriteria gagal jika total bobot melebihi 1 setelah dikecualikan dirinya', function () {
    $admin    = User::factory()->admin()->create();
    // kriteria lain sudah punya bobot 0.80
    Kriteria::factory()->jurusan()->create(['weight' => 0.80]);
    // kriteria yang akan diupdate
    $kriteria = Kriteria::factory()->jurusan()->create(['weight' => 0.10]);

    $this->actingAs($admin)
        ->put(route('admin.kriteria.update', $kriteria->id), [
            'nama'   => 'Diupdate',
            'weight' => 0.30, // 0.80 (lain) + 0.30 = 1.10 > 1
            'type'   => 'benefit',
            'jenis'  => 'jurusan',
        ])
        ->assertSessionHasErrors('weight');
});

// ══════════════════════════════════════════════════════════════
// DESTROY
// ══════════════════════════════════════════════════════════════

it('admin dapat menghapus kriteria', function () {
    $admin    = User::factory()->admin()->create();
    $kriteria = Kriteria::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.kriteria.destroy', $kriteria->id))
        ->assertRedirect(route('admin.kriteria.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('kriteria', ['id' => $kriteria->id]);
});