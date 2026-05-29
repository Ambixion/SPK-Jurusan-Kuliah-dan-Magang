<?php

use App\Models\JawabanSiswa;
use App\Models\Siswa;
use App\Models\KuisonerOpsi;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model jawaban siswa
// ══════════════════════════════════════════════════════════════

it('model jawaban siswa memiliki atribut fillable yang sesuai', function () {
    $jawabanSiswa = new JawabanSiswa();

    expect($jawabanSiswa->getFillable())->toBe([
        'kuisoner_opsi_id',
        'siswa_id',
    ]);
});

it('model jawaban siswa menggunakan nama tabel jawaban_siswa', function () {
    $jawabanSiswa = new JawabanSiswa();

    expect($jawabanSiswa->getTable())->toBe('jawaban_siswa');
});

// ══════════════════════════════════════════════════════════════
// Relasi belongs to pada model jawaban siswa
// ══════════════════════════════════════════════════════════════

it('jawaban siswa memiliki relasi belongs to ke siswa', function () {
    $jawabanSiswa = new JawabanSiswa();

    expect($jawabanSiswa->siswa())->toBeInstanceOf(BelongsTo::class);
    expect($jawabanSiswa->siswa()->getRelated())->toBeInstanceOf(Siswa::class);
    expect($jawabanSiswa->siswa()->getForeignKeyName())->toBe('siswa_id');
});

it('jawaban siswa memiliki relasi belongs to ke kuisoner opsi', function () {
    $jawabanSiswa = new JawabanSiswa();

    expect($jawabanSiswa->opsi())->toBeInstanceOf(BelongsTo::class);
    expect($jawabanSiswa->opsi()->getRelated())->toBeInstanceOf(KuisonerOpsi::class);
    expect($jawabanSiswa->opsi()->getForeignKeyName())->toBe('kuisoner_opsi_id');
});