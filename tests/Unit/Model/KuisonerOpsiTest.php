<?php

use App\Models\KuisonerOpsi;
use App\Models\Kuisoner;
use App\Models\JawabanSiswa;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model kuisoner opsi
// ══════════════════════════════════════════════════════════════

it('model kuisoner opsi memiliki atribut fillable yang sesuai', function () {
    $kuisonerOpsi = new KuisonerOpsi();

    expect($kuisonerOpsi->getFillable())->toBe([
        'kuisoner_id',
        'jawaban',
        'nilai',
    ]);
});

it('model kuisoner opsi menggunakan nama tabel kuisoner_opsi', function () {
    $kuisonerOpsi = new KuisonerOpsi();

    expect($kuisonerOpsi->getTable())->toBe('kuisoner_opsi');
});

// ══════════════════════════════════════════════════════════════
// Relasi belongs to pada model kuisoner opsi
// ══════════════════════════════════════════════════════════════

it('kuisoner opsi memiliki relasi belongs to ke kuisoner', function () {
    $kuisonerOpsi = new KuisonerOpsi();

    expect($kuisonerOpsi->kuisoner())->toBeInstanceOf(BelongsTo::class);
    expect($kuisonerOpsi->kuisoner()->getRelated())->toBeInstanceOf(Kuisoner::class);
    expect($kuisonerOpsi->kuisoner()->getForeignKeyName())->toBe('kuisoner_id');
});

// ══════════════════════════════════════════════════════════════
// Relasi has many pada model kuisoner opsi
// ══════════════════════════════════════════════════════════════

it('kuisoner opsi memiliki relasi has many ke jawaban siswa', function () {
    $kuisonerOpsi = new KuisonerOpsi();

    expect($kuisonerOpsi->jawabanSiswa())->toBeInstanceOf(HasMany::class);
    expect($kuisonerOpsi->jawabanSiswa()->getRelated())->toBeInstanceOf(JawabanSiswa::class);
    expect($kuisonerOpsi->jawabanSiswa()->getForeignKeyName())->toBe('kuisoner_opsi_id');
});