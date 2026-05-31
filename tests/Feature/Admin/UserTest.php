<?php

use App\Models\Guru;
use App\Models\JurusanSmk;
use App\Models\Siswa;
use App\Models\User;

// ══════════════════════════════════════════════════════════════
// STORE
// ══════════════════════════════════════════════════════════════

it('admin dapat menambah user baru dengan role admin', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'nama'                  => 'Admin Baru',
            'email'                 => 'adminbaru@spk.test',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'admin',
        ])
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('users', ['email' => 'adminbaru@spk.test', 'role' => 'admin']);
});

it('store user role siswa otomatis membuat record siswa', function () {
    $admin   = User::factory()->admin()->create();
    $jurusan = JurusanSmk::factory()->create();

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'nama'                  => 'Siswa Baru',
            'email'                 => 'siswabaru@spk.test',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'siswa',
            'jurusan_smk_id'        => $jurusan->id,
        ])
        ->assertRedirect(route('admin.users.index'));

    $user = User::where('email', 'siswabaru@spk.test')->first();
    expect($user)->not->toBeNull();
    // record di tabel siswa harus ada
    $this->assertDatabaseHas('siswa', ['users_id' => $user->id]);
});

it('store user role guru otomatis membuat record guru', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'nama'                  => 'Guru Baru',
            'email'                 => 'gurubaru@spk.test',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'guru',
        ])
        ->assertRedirect(route('admin.users.index'));

    $user = User::where('email', 'gurubaru@spk.test')->first();
    $this->assertDatabaseHas('guru', ['users_id' => $user->id]);
});

it('store user role siswa gagal jika jurusan smk tidak diisi', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'nama'                  => 'Siswa Tanpa Jurusan',
            'email'                 => 'tanpajurusan@spk.test',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'siswa',
            'jurusan_smk_id'        => null,
        ])
        ->assertSessionHasErrors('jurusan_smk_id');
});

it('store user gagal jika email sudah terdaftar', function () {
    $admin = User::factory()->admin()->create();
    User::factory()->create(['email' => 'ada@spk.test']);

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'nama'                  => 'User Lain',
            'email'                 => 'ada@spk.test',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'guru',
        ])
        ->assertSessionHasErrors('email');
});

it('store user gagal jika password tidak cocok dengan konfirmasi', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'nama'                  => 'User X',
            'email'                 => 'userx@spk.test',
            'password'              => 'password123',
            'password_confirmation' => 'beda',
            'role'                  => 'guru',
        ])
        ->assertSessionHasErrors('password');
});

// ══════════════════════════════════════════════════════════════
// UPDATE
// ══════════════════════════════════════════════════════════════

it('admin dapat mengupdate data user', function () {
    $admin = User::factory()->admin()->create();
    $user  = User::factory()->guru()->create(['email' => 'lama@spk.test']);
    Guru::factory()->create(['users_id' => $user->id]);

    $this->actingAs($admin)
        ->put(route('admin.users.update', $user->id), [
            'nama'  => 'Nama Baru',
            'email' => 'baru@spk.test',
            'role'  => 'guru',
        ])
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('users', ['email' => 'baru@spk.test']);
});

it('update role dari guru ke siswa menghapus record guru dan membuat record siswa', function () {
    $admin   = User::factory()->admin()->create();
    $jurusan = JurusanSmk::factory()->create();
    $user    = User::factory()->guru()->create();
    Guru::factory()->create(['users_id' => $user->id]);

    $this->actingAs($admin)
        ->put(route('admin.users.update', $user->id), [
            'nama'           => $user->nama,
            'email'          => $user->email,
            'role'           => 'siswa',
            'jurusan_smk_id' => $jurusan->id,
        ])
        ->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseMissing('guru', ['users_id' => $user->id]);
    $this->assertDatabaseHas('siswa', ['users_id' => $user->id]);
});

// ══════════════════════════════════════════════════════════════
// DESTROY
// ══════════════════════════════════════════════════════════════

it('admin dapat menghapus user beserta record siswa', function () {
    $admin = User::factory()->admin()->create();
    $siswa = \App\Models\Siswa::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $siswa->users_id))
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('users', ['id' => $siswa->users_id]);
    $this->assertDatabaseMissing('siswa', ['users_id' => $siswa->users_id]);
});

it('admin dapat menghapus user beserta record guru', function () {
    $admin = User::factory()->admin()->create();
    $guru  = Guru::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $guru->users_id))
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('users', ['id' => $guru->users_id]);
    $this->assertDatabaseMissing('guru', ['users_id' => $guru->users_id]);
});