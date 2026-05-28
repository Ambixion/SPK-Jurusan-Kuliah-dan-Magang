<?php



use App\Models\User;

// ══════════════════════════════════════════════════════════════
// Guest: ditangkap middleware AUTH (redirect login)
// ══════════════════════════════════════════════════════════════

it('guest akses admin dashboard diredirect ke login', function () {
    $this->get('/admin/dashboard')
        ->assertRedirect(route('login'));
});

it('guest akses guru dashboard diredirect ke login', function () {
    $this->get('/guru/dashboard')
        ->assertRedirect(route('login'));
});

it('guest akses siswa dashboard diredirect ke login', function () {
    $this->get('/siswa/dashboard')
        ->assertRedirect(route('login'));
});

// ══════════════════════════════════════════════════════════════
// Role salah: lolos auth, ditangkap CheckRole (403)
// ══════════════════════════════════════════════════════════════

it('siswa akses route admin mendapat 403', function () {
    $siswa = User::factory()->siswa()->create();

    $this->actingAs($siswa)
        ->get('/admin/dashboard')
        ->assertStatus(403);
});

it('siswa akses route guru mendapat 403', function () {
    $siswa = User::factory()->siswa()->create();

    $this->actingAs($siswa)
        ->get('/guru/dashboard')
        ->assertStatus(403);
});

it('guru akses route admin mendapat 403', function () {
    $guru = User::factory()->guru()->create();

    $this->actingAs($guru)
        ->get('/admin/dashboard')
        ->assertStatus(403);
});

it('guru akses route siswa mendapat 403', function () {
    $guru = User::factory()->guru()->create();

    $this->actingAs($guru)
        ->get('/siswa/dashboard')
        ->assertStatus(403);
});

it('admin akses route guru mendapat 403', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/guru/dashboard')
        ->assertStatus(403);
});

it('admin akses route siswa mendapat 403', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/siswa/dashboard')
        ->assertStatus(403);
});

// ══════════════════════════════════════════════════════════════
// Role benar: lolos auth + lolos CheckRole (200)
// ══════════════════════════════════════════════════════════════

it('admin akses admin dashboard berhasil', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/dashboard')
        ->assertStatus(200);
});

it('guru akses guru dashboard berhasil', function () {
    $guru = User::factory()->guru()->create();

    $this->actingAs($guru)
        ->get('/guru/dashboard')
        ->assertStatus(200);
});

it('siswa akses siswa dashboard berhasil', function () {
    $siswa = \App\Models\Siswa::factory()->create();

    $this->actingAs($siswa->user)
        ->get('/siswa/dashboard')
        ->assertStatus(200);
});

// ══════════════════════════════════════════════════════════════
// Root redirect sesuai role (route '/')
// ══════════════════════════════════════════════════════════════

it('root redirect admin ke admin dashboard', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/')
        ->assertRedirect('/admin/dashboard');
});

it('root redirect guru ke guru dashboard', function () {
    $guru = User::factory()->guru()->create();

    $this->actingAs($guru)
        ->get('/')
        ->assertRedirect('/guru/dashboard');
});

it('root redirect siswa ke siswa dashboard', function () {
    $siswa = User::factory()->siswa()->create();

    $this->actingAs($siswa)
        ->get('/')
        ->assertRedirect('/siswa/dashboard');
});

it('root menampilkan halaman welcome untuk guest', function () {
    $this->get('/')
        ->assertStatus(200)
        ->assertViewIs('welcome');
});

// ══════════════════════════════════════════════════════════════
// Isolasi resource admin (spot check sub-route)
// ══════════════════════════════════════════════════════════════

it('siswa akses admin users index mendapat 403', function () {
    $siswa = User::factory()->siswa()->create();

    $this->actingAs($siswa)
        ->get('/admin/users')
        ->assertStatus(403);
});

it('siswa akses admin jurusan kuliah mendapat 403', function () {
    $siswa = User::factory()->siswa()->create();

    $this->actingAs($siswa)
        ->get('/admin/jurusan_kuliah')
        ->assertStatus(403);
});

it('guru akses admin kriteria mendapat 403', function () {
    $guru = User::factory()->guru()->create();

    $this->actingAs($guru)
        ->get('/admin/kriteria')
        ->assertStatus(403);
});

it('admin akses siswa kuisoner pkl mendapat 403', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/siswa/pkl')
        ->assertStatus(403);
});