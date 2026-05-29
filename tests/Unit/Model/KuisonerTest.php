<?php

use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use App\Models\JurusanKuliah;
use App\Models\Bidang;
use App\Models\Skill;
use App\Models\Kriteria;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model kuisoner
// ══════════════════════════════════════════════════════════════

it('model kuisoner memiliki atribut fillable yang sesuai', function () {
    $kuisoner = new Kuisoner();

    expect($kuisoner->getFillable())->toBe([
        'soal',
        'type',
        'jurusan_kuliah_id',
        'bidang_id',
        'skill_id',
        'kriteria_id',
        'urutan',
    ]);
});

it('model kuisoner menggunakan nama tabel kuisoner', function () {
    $kuisoner = new Kuisoner();

    expect($kuisoner->getTable())->toBe('kuisoner');
});

// ══════════════════════════════════════════════════════════════
// Relasi has many pada model kuisoner
// ══════════════════════════════════════════════════════════════

it('kuisoner memiliki relasi has many ke kuisoner opsi', function () {
    $kuisoner = new Kuisoner();

    expect($kuisoner->opsi())->toBeInstanceOf(HasMany::class);
    expect($kuisoner->opsi()->getRelated())->toBeInstanceOf(KuisonerOpsi::class);
    expect($kuisoner->opsi()->getForeignKeyName())->toBe('kuisoner_id');
});

// ══════════════════════════════════════════════════════════════
// Relasi belongs to pada model kuisoner
// ══════════════════════════════════════════════════════════════

it('kuisoner memiliki relasi belongs to ke jurusan kuliah', function () {
    $kuisoner = new Kuisoner();

    expect($kuisoner->jurusanKuliah())->toBeInstanceOf(BelongsTo::class);
    expect($kuisoner->jurusanKuliah()->getRelated())->toBeInstanceOf(JurusanKuliah::class);
    expect($kuisoner->jurusanKuliah()->getForeignKeyName())->toBe('jurusan_kuliah_id');
});

it('kuisoner memiliki relasi belongs to ke bidang', function () {
    $kuisoner = new Kuisoner();

    expect($kuisoner->bidang())->toBeInstanceOf(BelongsTo::class);
    expect($kuisoner->bidang()->getRelated())->toBeInstanceOf(Bidang::class);
    expect($kuisoner->bidang()->getForeignKeyName())->toBe('bidang_id');
});

it('kuisoner memiliki relasi belongs to ke skill', function () {
    $kuisoner = new Kuisoner();

    expect($kuisoner->skill())->toBeInstanceOf(BelongsTo::class);
    expect($kuisoner->skill()->getRelated())->toBeInstanceOf(Skill::class);
    expect($kuisoner->skill()->getForeignKeyName())->toBe('skill_id');
});

it('kuisoner memiliki relasi belongs to ke kriteria', function () {
    $kuisoner = new Kuisoner();

    expect($kuisoner->kriteria())->toBeInstanceOf(BelongsTo::class);
    expect($kuisoner->kriteria()->getRelated())->toBeInstanceOf(Kriteria::class);
    expect($kuisoner->kriteria()->getForeignKeyName())->toBe('kriteria_id');
});

// ══════════════════════════════════════════════════════════════
// Scope query pada model kuisoner
// ══════════════════════════════════════════════════════════════

it('scope untuk jurusan menambahkan kondisi jurusan kuliah atau global', function () {
    $query = Kuisoner::query()->untukJurusan(1);

    expect($query->toSql())->toContain('jurusan_kuliah_id');
    expect($query->getBindings())->toContain(1);
});

it('scope untuk bidang menambahkan kondisi bidang atau global', function () {
    $query = Kuisoner::query()->untukBidang(2);

    expect($query->toSql())->toContain('bidang_id');
    expect($query->getBindings())->toContain(2);
});

it('scope untuk skills menambahkan kondisi skill atau global', function () {
    $query = Kuisoner::query()->untukSkills([1, 2, 3]);

    expect($query->toSql())->toContain('skill_id');
    expect($query->getBindings())->toBe([1, 2, 3]);
});