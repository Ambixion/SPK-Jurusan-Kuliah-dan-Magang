<?php

use App\Models\SkorSiswa;
use App\Models\Siswa;
use App\Models\Kriteria;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model skor siswa
// ══════════════════════════════════════════════════════════════

it('model skor siswa memiliki atribut fillable yang sesuai', function () {
    $skorSiswa = new SkorSiswa();

    expect($skorSiswa->getFillable())->toBe([
        'siswa_id',
        'kriteria_id',
        'score',
    ]);
});

it('model skor siswa menggunakan nama tabel skor_siswa', function () {
    $skorSiswa = new SkorSiswa();

    expect($skorSiswa->getTable())->toBe('skor_siswa');
});

// ══════════════════════════════════════════════════════════════
// Relasi belongs to pada model skor siswa
// ══════════════════════════════════════════════════════════════

it('skor siswa memiliki relasi belongs to ke siswa', function () {
    $skorSiswa = new SkorSiswa();

    expect($skorSiswa->siswa())->toBeInstanceOf(BelongsTo::class);
    expect($skorSiswa->siswa()->getRelated())->toBeInstanceOf(Siswa::class);
    expect($skorSiswa->siswa()->getForeignKeyName())->toBe('siswa_id');
});

it('skor siswa memiliki relasi belongs to ke kriteria', function () {
    $skorSiswa = new SkorSiswa();

    expect($skorSiswa->kriteria())->toBeInstanceOf(BelongsTo::class);
    expect($skorSiswa->kriteria()->getRelated())->toBeInstanceOf(Kriteria::class);
    expect($skorSiswa->kriteria()->getForeignKeyName())->toBe('kriteria_id');
});