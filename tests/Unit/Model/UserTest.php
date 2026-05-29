<?php

use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Database\Eloquent\Relations\HasOne;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model user
// ══════════════════════════════════════════════════════════════

it('model user memiliki atribut fillable yang sesuai', function () {
    $user = new User();

    expect($user->getFillable())->toBe([
        'nama',
        'email',
        'password',
        'role',
    ]);
});

it('model user memiliki atribut hidden yang sesuai', function () {
    $user = new User();

    expect($user->getHidden())->toBe([
        'password',
        'remember_token',
    ]);
});

it('model user memiliki cast yang sesuai', function () {
    $user = new User();

    expect($user->getCasts())->toMatchArray([
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ]);
});

// ══════════════════════════════════════════════════════════════
// Relasi has one pada model user
// ══════════════════════════════════════════════════════════════

it('user memiliki relasi has one ke siswa', function () {
    $user = new User();

    expect($user->siswa())->toBeInstanceOf(HasOne::class);
    expect($user->siswa()->getRelated())->toBeInstanceOf(Siswa::class);
    expect($user->siswa()->getForeignKeyName())->toBe('users_id');
});

it('user memiliki relasi has one ke guru', function () {
    $user = new User();

    expect($user->guru())->toBeInstanceOf(HasOne::class);
    expect($user->guru()->getRelated())->toBeInstanceOf(Guru::class);
    expect($user->guru()->getForeignKeyName())->toBe('users_id');
});

// ══════════════════════════════════════════════════════════════
// Method pengecekan role pada model user
// ══════════════════════════════════════════════════════════════

it('method isAdmin mengembalikan true jika role user adalah admin', function () {
    $user = new User([
        'role' => 'admin',
    ]);

    expect($user->isAdmin())->toBeTrue();
});

it('method isAdmin mengembalikan false jika role user bukan admin', function () {
    $user = new User([
        'role' => 'guru',
    ]);

    expect($user->isAdmin())->toBeFalse();
});

it('method isGuru mengembalikan true jika role user adalah guru', function () {
    $user = new User([
        'role' => 'guru',
    ]);

    expect($user->isGuru())->toBeTrue();
});

it('method isGuru mengembalikan false jika role user bukan guru', function () {
    $user = new User([
        'role' => 'siswa',
    ]);

    expect($user->isGuru())->toBeFalse();
});

it('method isSiswa mengembalikan true jika role user adalah siswa', function () {
    $user = new User([
        'role' => 'siswa',
    ]);

    expect($user->isSiswa())->toBeTrue();
});

it('method isSiswa mengembalikan false jika role user bukan siswa', function () {
    $user = new User([
        'role' => 'admin',
    ]);

    expect($user->isSiswa())->toBeFalse();
});