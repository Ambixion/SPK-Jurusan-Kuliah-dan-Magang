<?php

use App\Models\JurusanKuliah;
use App\Models\Kriteria;
use App\Models\User;

// helper: login sebagai admin
function asAdmin()
{
    $admin = User::factory()->admin()->create();
    test()->actingAs($admin);
}

// ══════════════════════════════════════════════════════════════
// INDEX
// ══════════════════════════════════════════════════════════════

it('admin dapat melihat daftar jurusan kuliah', function () {
    asAdmin();
    JurusanKuliah::factory()->count(3)->create();

    $this->get(route('admin.jurusan_kuliah.index'))
        ->assertStatus(200)
        ->assertViewIs('admin.jurusan_kuliah.index')
        ->assertViewHas('jurusan');
});

// ══════════════════════════════════════════════════════════════
// STORE
// ══════════════════════════════════════════════════════════════

it('admin dapat menambah jurusan kuliah baru', function () {
    asAdmin();

    $this->post(route('admin.jurusan_kuliah.store'), [
        'nama'         => 'Teknik Informatika',
        'deskripsi'    => 'Mempelajari ilmu komputer',
        'bidang_studi' => 'Teknologi',
    ])
        ->assertRedirect(route('admin.jurusan_kuliah.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('jurusan_kuliah', ['nama' => 'Teknik Informatika']);
});

it('admin dapat store jurusan kuliah beserta skor kriteria', function () {
    asAdmin();
    $kriteria = Kriteria::factory()->jurusan()->create();

    $this->post(route('admin.jurusan_kuliah.store'), [
        'nama'         => 'Sistem Informasi',
        'bidang_studi' => 'Teknologi',
        'skor'         => [$kriteria->id => 80],
    ])->assertRedirect(route('admin.jurusan_kuliah.index'));

    $this->assertDatabaseHas('skor_jurusan', [
        'kriteria_id' => $kriteria->id,
        'score'       => 80,
    ]);
});

it('store jurusan kuliah gagal jika nama kosong', function () {
    asAdmin();

    $this->post(route('admin.jurusan_kuliah.store'), [
        'nama'         => '',
        'bidang_studi' => 'Teknologi',
    ])->assertSessionHasErrors('nama');

    $this->assertDatabaseCount('jurusan_kuliah', 0);
});

it('store jurusan kuliah gagal jika bidang studi kosong', function () {
    asAdmin();

    $this->post(route('admin.jurusan_kuliah.store'), [
        'nama'         => 'Teknik Informatika',
        'bidang_studi' => '',
    ])->assertSessionHasErrors('bidang_studi');
});

// ══════════════════════════════════════════════════════════════
// UPDATE
// ══════════════════════════════════════════════════════════════

it('admin dapat mengupdate jurusan kuliah', function () {
    asAdmin();
    $jurusan = JurusanKuliah::factory()->create(['nama' => 'Lama']);

    $this->put(route('admin.jurusan_kuliah.update', $jurusan->id), [
        'nama'         => 'Baru',
        'bidang_studi' => 'Teknologi',
    ])
        ->assertRedirect(route('admin.jurusan_kuliah.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('jurusan_kuliah', ['nama' => 'Baru']);
    $this->assertDatabaseMissing('jurusan_kuliah', ['nama' => 'Lama']);
});

it('update jurusan kuliah gagal jika nama kosong', function () {
    asAdmin();
    $jurusan = JurusanKuliah::factory()->create();

    $this->put(route('admin.jurusan_kuliah.update', $jurusan->id), [
        'nama'         => '',
        'bidang_studi' => 'Teknologi',
    ])->assertSessionHasErrors('nama');
});

// ══════════════════════════════════════════════════════════════
// DESTROY
// ══════════════════════════════════════════════════════════════

it('admin dapat menghapus jurusan kuliah', function () {
    asAdmin();
    $jurusan = JurusanKuliah::factory()->create();

    $this->delete(route('admin.jurusan_kuliah.destroy', $jurusan->id))
        ->assertRedirect(route('admin.jurusan_kuliah.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('jurusan_kuliah', ['id' => $jurusan->id]);
});

it('hapus jurusan kuliah yang tidak ada menghasilkan 404', function () {
    asAdmin();

    $this->delete(route('admin.jurusan_kuliah.destroy', 99999))
        ->assertStatus(404);
});