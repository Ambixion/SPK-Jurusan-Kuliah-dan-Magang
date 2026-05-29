<?php

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model guru
// ══════════════════════════════════════════════════════════════

it('model guru memiliki atribut fillable yang sesuai', function () {
    $guru = new Guru();

    expect($guru->getFillable())->toBe([
        'users_id',
    ]);
});

it('model guru menggunakan nama tabel guru', function () {
    $guru = new Guru();

    expect($guru->getTable())->toBe('guru');
});

// ══════════════════════════════════════════════════════════════
// Relasi belongs to pada model guru
// ══════════════════════════════════════════════════════════════

it('guru memiliki relasi belongs to ke user', function () {
    $guru = new Guru();

    expect($guru->user())->toBeInstanceOf(BelongsTo::class);
    expect($guru->user()->getRelated())->toBeInstanceOf(User::class);
    expect($guru->user()->getForeignKeyName())->toBe('users_id');
});