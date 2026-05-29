<?php

use App\Models\HasilMagang;
use App\Models\Siswa;
use App\Models\TempatMagang;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model hasil magang
// ══════════════════════════════════════════════════════════════

it('model hasil magang memiliki atribut fillable yang sesuai', function () {
    $hasilMagang = new HasilMagang();

    expect($hasilMagang->getFillable())->toBe([
        'siswa_id',
        'tempat_magang_id',
        'score',
        'rank',
    ]);
});

it('model hasil magang menggunakan nama tabel hasil_magang', function () {
    $hasilMagang = new HasilMagang();

    expect($hasilMagang->getTable())->toBe('hasil_magang');
});

// ══════════════════════════════════════════════════════════════
// Relasi belongs to pada model hasil magang
// ══════════════════════════════════════════════════════════════

it('hasil magang memiliki relasi belongs to ke siswa', function () {
    $hasilMagang = new HasilMagang();

    expect($hasilMagang->siswa())->toBeInstanceOf(BelongsTo::class);
    expect($hasilMagang->siswa()->getRelated())->toBeInstanceOf(Siswa::class);
    expect($hasilMagang->siswa()->getForeignKeyName())->toBe('siswa_id');
});

it('hasil magang memiliki relasi belongs to ke tempat magang', function () {
    $hasilMagang = new HasilMagang();

    expect($hasilMagang->tempatMagang())->toBeInstanceOf(BelongsTo::class);
    expect($hasilMagang->tempatMagang()->getRelated())->toBeInstanceOf(TempatMagang::class);
    expect($hasilMagang->tempatMagang()->getForeignKeyName())->toBe('tempat_magang_id');
});