<?php

use App\Models\NilaiSiswa;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model nilai siswa
// ══════════════════════════════════════════════════════════════

it('model nilai siswa memiliki atribut fillable yang sesuai', function () {
    $nilaiSiswa = new NilaiSiswa();

    expect($nilaiSiswa->getFillable())->toBe([
        'siswa_id',
        'mata_pelajaran',
        'nilai',
        'semester',
        'tahun_ajaran',
    ]);
});

it('model nilai siswa menggunakan nama tabel nilai_siswa', function () {
    $nilaiSiswa = new NilaiSiswa();

    expect($nilaiSiswa->getTable())->toBe('nilai_siswa');
});

// ══════════════════════════════════════════════════════════════
// Relasi belongs to pada model nilai siswa
// ══════════════════════════════════════════════════════════════

it('nilai siswa memiliki relasi belongs to ke siswa', function () {
    $nilaiSiswa = new NilaiSiswa();

    expect($nilaiSiswa->siswa())->toBeInstanceOf(BelongsTo::class);
    expect($nilaiSiswa->siswa()->getRelated())->toBeInstanceOf(Siswa::class);
    expect($nilaiSiswa->siswa()->getForeignKeyName())->toBe('siswa_id');
});