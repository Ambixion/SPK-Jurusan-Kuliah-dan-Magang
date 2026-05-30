<?php

use App\Models\User;
use App\Models\Siswa;
use App\Models\JurusanSmk;
use App\Models\NilaiSiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->guru = User::factory()->create([
        'role' => 'guru',
    ]);

    $this->jurusanSmk = JurusanSmk::factory()->create([
        'nama_jurusan' => 'Rekayasa Perangkat Lunak',
    ]);
});

it('guru dapat melihat halaman daftar siswa', function () {
    $response = $this->actingAs($this->guru)
        ->get(route('guru.siswa.index'));

    $response->assertOk();
    $response->assertViewIs('guru.siswa.index');
    $response->assertViewHas('siswas');
    $response->assertViewHas('jurusanSmk');
});

it('guru dapat menambahkan siswa beserta nilai rata-rata', function () {
    $payload = [
        'nama' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'nisn' => '1234567890',
        'kelas' => '12',
        'semester' => 6,
        'jurusan_smk_id' => $this->jurusanSmk->id,
        'no_telp' => '08123456789',
        'alamat' => 'Jember',
        'nilai_rata_rata' => 88,
    ];

    $response = $this->actingAs($this->guru)
        ->post(route('guru.siswa.store'), $payload);

    $response->assertRedirect(route('guru.siswa.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'nama' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'role' => 'siswa',
    ]);

    $user = User::where('email', 'budi@example.com')->first();

    expect(Hash::check('smkn5jember', $user->password))->toBeTrue();

    $this->assertDatabaseHas('siswa', [
        'users_id' => $user->id,
        'jurusan_smk_id' => $this->jurusanSmk->id,
        'nisn' => '1234567890',
        'kelas' => '12',
        'semester' => 6,
        'no_telp' => '08123456789',
        'alamat' => 'Jember',
    ]);

    $siswa = Siswa::where('users_id', $user->id)->first();

    $this->assertDatabaseHas('nilai_siswa', [
        'siswa_id' => $siswa->id,
        'mata_pelajaran' => 'Rata-rata',
        'nilai' => 88,
        'semester' => 6,
        'tahun_ajaran' => date('Y'),
    ]);
});

it('guru tidak dapat menambahkan siswa jika email sudah digunakan', function () {
    User::factory()->create([
        'email' => 'duplikat@example.com',
    ]);

    $payload = [
        'nama' => 'Siswa Baru',
        'email' => 'duplikat@example.com',
        'nisn' => '99887766',
        'kelas' => '11',
        'semester' => 4,
        'jurusan_smk_id' => $this->jurusanSmk->id,
        'nilai_rata_rata' => 80,
    ];

    $response = $this->actingAs($this->guru)
        ->post(route('guru.siswa.store'), $payload);

    $response->assertSessionHasErrors('email');
});

it('guru dapat melihat detail siswa melalui modal di halaman daftar siswa', function () {
    $userSiswa = User::factory()->create([
        'role' => 'siswa',
        'nama' => 'Andi Pratama',
        'email' => 'andi@example.com',
    ]);

    $siswa = Siswa::factory()->create([
        'users_id' => $userSiswa->id,
        'jurusan_smk_id' => $this->jurusanSmk->id,
        'nisn' => '1231231231',
        'kelas' => '12',
        'semester' => 6,
        'no_telp' => '081234567890',
        'alamat' => 'Jember',
    ]);

    NilaiSiswa::create([
        'siswa_id' => $siswa->id,
        'mata_pelajaran' => 'Rata-rata',
        'nilai' => 85,
        'semester' => 6,
        'tahun_ajaran' => date('Y'),
    ]);

    $response = $this->actingAs($this->guru)
        ->get(route('guru.siswa.index'));

    $response->assertOk();
    $response->assertViewIs('guru.siswa.index');

    $response->assertSee('Andi Pratama');
    $response->assertSee('Rekayasa Perangkat Lunak');
    $response->assertSee('85');

    $response->assertSee('data-nama="Andi Pratama"', false);
    $response->assertSee('data-email="andi@example.com"', false);
    $response->assertSee('data-nisn="1231231231"', false);
    $response->assertSee('data-kelas="12"', false);
    $response->assertSee('data-semester="6"', false);
    $response->assertSee('data-no-telp="081234567890"', false);
    $response->assertSee('data-alamat="Jember"', false);
});

it('guru dapat membuka halaman edit siswa', function () {
    $userSiswa = User::factory()->create([
        'role' => 'siswa',
    ]);

    $siswa = Siswa::factory()->create([
        'users_id' => $userSiswa->id,
        'jurusan_smk_id' => $this->jurusanSmk->id,
    ]);

    $response = $this->actingAs($this->guru)
        ->get(route('guru.siswa.edit', $siswa->id));

    $response->assertOk();
    $response->assertViewIs('guru.siswa.edit');
    $response->assertViewHas('siswa');
    $response->assertViewHas('jurusanSmk');
});

it('guru dapat memperbarui data siswa dan nilai rata-rata', function () {
    $userSiswa = User::factory()->create([
        'role' => 'siswa',
        'nama' => 'Nama Lama',
        'email' => 'lama@example.com',
    ]);

    $siswa = Siswa::factory()->create([
        'users_id' => $userSiswa->id,
        'jurusan_smk_id' => $this->jurusanSmk->id,
        'nisn' => '111111',
        'kelas' => '10',
        'semester' => 1,
    ]);

    NilaiSiswa::factory()->create([
        'siswa_id' => $siswa->id,
        'mata_pelajaran' => 'Rata-rata',
        'nilai' => 70,
        'semester' => 1,
        'tahun_ajaran' => date('Y'),
    ]);

    $payload = [
        'nama' => 'Nama Baru',
        'email' => 'baru@example.com',
        'nisn' => '222222',
        'kelas' => '12',
        'semester' => 6,
        'jurusan_smk_id' => $this->jurusanSmk->id,
        'no_telp' => '08999999999',
        'alamat' => 'Alamat Baru',
        'nilai_rata_rata' => 90,
    ];

    $response = $this->actingAs($this->guru)
        ->put(route('guru.siswa.update', $siswa->id), $payload);

    $response->assertRedirect(route('guru.siswa.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'id' => $userSiswa->id,
        'nama' => 'Nama Baru',
        'email' => 'baru@example.com',
    ]);

    $this->assertDatabaseHas('siswa', [
        'id' => $siswa->id,
        'nisn' => '222222',
        'kelas' => '12',
        'semester' => 6,
        'no_telp' => '08999999999',
        'alamat' => 'Alamat Baru',
    ]);

    $this->assertDatabaseHas('nilai_siswa', [
        'siswa_id' => $siswa->id,
        'mata_pelajaran' => 'Rata-rata',
        'nilai' => 90,
        'semester' => 6,
        'tahun_ajaran' => date('Y'),
    ]);
});

it('guru dapat menghapus siswa', function () {
    $userSiswa = User::factory()->create([
        'role' => 'siswa',
    ]);

    $siswa = Siswa::factory()->create([
        'users_id' => $userSiswa->id,
        'jurusan_smk_id' => $this->jurusanSmk->id,
    ]);

    $response = $this->actingAs($this->guru)
        ->delete(route('guru.siswa.destroy', $siswa->id));

    $response->assertRedirect(route('guru.siswa.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('users', [
        'id' => $userSiswa->id,
    ]);
});