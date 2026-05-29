<?php

use App\Models\HasilJurusan;
use App\Models\Siswa;
use App\Models\JurusanKuliah;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model hasil jurusan
// ══════════════════════════════════════════════════════════════

it('model hasil jurusan memiliki atribut fillable yang sesuai', function () {
    $hasilJurusan = new HasilJurusan();

    expect($hasilJurusan->getFillable())->toBe([
        'siswa_id',
        'jurusan_kuliah_id',
        'score',
        'rank',
    ]);
});

it('model hasil jurusan menggunakan nama tabel hasil_jurusan', function () {
    $hasilJurusan = new HasilJurusan();

    expect($hasilJurusan->getTable())->toBe('hasil_jurusan');
});

// ══════════════════════════════════════════════════════════════
// Relasi belongs to pada model hasil jurusan
// ══════════════════════════════════════════════════════════════

it('hasil jurusan memiliki relasi belongs to ke siswa', function () {
    $hasilJurusan = new HasilJurusan();

    expect($hasilJurusan->siswa())->toBeInstanceOf(BelongsTo::class);
    expect($hasilJurusan->siswa()->getRelated())->toBeInstanceOf(Siswa::class);
    expect($hasilJurusan->siswa()->getForeignKeyName())->toBe('siswa_id');
});

it('hasil jurusan memiliki relasi belongs to ke jurusan kuliah', function () {
    $hasilJurusan = new HasilJurusan();

    expect($hasilJurusan->jurusan())->toBeInstanceOf(BelongsTo::class);
    expect($hasilJurusan->jurusan()->getRelated())->toBeInstanceOf(JurusanKuliah::class);
    expect($hasilJurusan->jurusan()->getForeignKeyName())->toBe('jurusan_kuliah_id');
});