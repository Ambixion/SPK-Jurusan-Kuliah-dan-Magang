<?php

use App\Models\User;

// ══════════════════════════════════════════════════════════════
// Halaman login
// ══════════════════════════════════════════════════════════════

it('halaman login dapat diakses oleh guest', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

it('halaman login dapat diakses via route name', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
});

it('halaman login menampilkan field login dan password', function () {
    $response = $this->get('/login');

    $response->assertSee('login',    false);
    $response->assertSee('password', false);
});

it('user yang sudah login tidak bisa mengakses halaman login', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/login')
        ->assertRedirect();
});

// ══════════════════════════════════════════════════════════════
// Login sukses per role
// ══════════════════════════════════════════════════════════════

it('admin dapat login menggunakan email dan diredirect ke admin dashboard', function () {
    $user = User::factory()->admin()->create([
        'email'    => 'admin@spk.test',
        'password' => bcrypt('password'),
    ]);

    $this->post('/login', [
        'login'    => 'admin@spk.test',
        'password' => 'password',
    ])->assertRedirect('/admin/dashboard');

    $this->assertAuthenticatedAs($user);
});

it('admin dapat login menggunakan nama dan diredirect ke admin dashboard', function () {
    $user = User::factory()->admin()->create([
        'nama'     => 'AdminSPK',
        'password' => bcrypt('password'),
    ]);

    $this->post('/login', [
        'login'    => 'AdminSPK',
        'password' => 'password',
    ])->assertRedirect('/admin/dashboard');

    $this->assertAuthenticatedAs($user);
});

it('guru dapat login dan diredirect ke guru dashboard', function () {
    $user = User::factory()->guru()->create([
        'email'    => 'guru@spk.test',
        'password' => bcrypt('password'),
    ]);

    $this->post('/login', [
        'login'    => 'guru@spk.test',
        'password' => 'password',
    ])->assertRedirect('/guru/dashboard');

    $this->assertAuthenticatedAs($user);
});

it('siswa dapat login dan diredirect ke siswa dashboard', function () {
    $user = User::factory()->siswa()->create([
        'email'    => 'siswa@spk.test',
        'password' => bcrypt('password'),
    ]);

    $this->post('/login', [
        'login'    => 'siswa@spk.test',
        'password' => 'password',
    ])->assertRedirect('/siswa/dashboard');

    $this->assertAuthenticatedAs($user);
});

// ══════════════════════════════════════════════════════════════
// Login gagal
// ══════════════════════════════════════════════════════════════

it('login gagal jika password salah', function () {
    User::factory()->create([
        'email'    => 'user@spk.test',
        'password' => bcrypt('password_benar'),
    ]);

    $response = $this->post('/login', [
        'login'    => 'user@spk.test',
        'password' => 'password_salah',
    ]);

    $response->assertSessionHasErrors('login');
    $this->assertGuest();
});

it('login gagal jika email tidak terdaftar', function () {
    $response = $this->post('/login', [
        'login'    => 'tidakada@spk.test',
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors('login');
    $this->assertGuest();
});

it('login gagal jika nama tidak terdaftar', function () {
    $response = $this->post('/login', [
        'login'    => 'NamaTidakAda',
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors('login');
    $this->assertGuest();
});

it('login gagal jika field login kosong', function () {
    $response = $this->post('/login', [
        'login'    => '',
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors('login');
    $this->assertGuest();
});

it('login gagal jika field password kosong', function () {
    $response = $this->post('/login', [
        'login'    => 'siapapun@spk.test',
        'password' => '',
    ]);

    $response->assertSessionHasErrors('password');
    $this->assertGuest();
});

it('pesan error login menggunakan key login bukan email', function () {
    User::factory()->create(['email' => 'cek@spk.test']);

    $response = $this->post('/login', [
        'login'    => 'cek@spk.test',
        'password' => 'salah',
    ]);

    // Pastikan error ada di key 'login', bukan 'email'
    $response->assertSessionHasErrors('login');
    $response->assertSessionMissing('errors.email');
});

// ══════════════════════════════════════════════════════════════
// Logout
// ══════════════════════════════════════════════════════════════

it('user yang login dapat logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/logout')
        ->assertRedirect('/');

    $this->assertGuest();
});

it('logout menghapus session dan mengembalikan pesan sukses', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect('/');
    $response->assertSessionHas('success');
    $this->assertGuest();
});

it('guest tidak bisa mengakses route logout via GET', function () {
    
    $response = $this->get('/logout');

    $response->assertStatus(405); 
});

// ══════════════════════════════════════════════════════════════
//  Proteksi route (guest middleware)
// ══════════════════════════════════════════════════════════════

it('guest yang akses admin dashboard diredirect ke login', function () {
    $this->get('/admin/dashboard')
        ->assertRedirect(route('login'));
});

it('guest yang akses guru dashboard diredirect ke login', function () {
    $this->get('/guru/dashboard')
        ->assertRedirect(route('login'));
});

it('guest yang akses siswa dashboard diredirect ke login', function () {
    $this->get('/siswa/dashboard')
        ->assertRedirect(route('login'));
});