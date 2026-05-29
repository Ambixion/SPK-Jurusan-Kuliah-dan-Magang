<?php

use App\Models\JurusanKuliah;
use App\Models\SkorJurusan;
use App\Models\HasilJurusan;
use App\Models\Bidang;
use App\Models\Kuisoner;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model jurusan kuliah
// ══════════════════════════════════════════════════════════════

it('model jurusan kuliah memiliki atribut fillable yang sesuai', function () {
    $jurusanKuliah = new JurusanKuliah();

    expect($jurusanKuliah->getFillable())->toBe([
        'nama',
        'deskripsi',
        'bidang_studi',
    ]);
});

it('model jurusan kuliah menggunakan nama tabel jurusan_kuliah', function () {
    $jurusanKuliah = new JurusanKuliah();

    expect($jurusanKuliah->getTable())->toBe('jurusan_kuliah');
});

// ══════════════════════════════════════════════════════════════
// Relasi has many pada model jurusan kuliah
// ══════════════════════════════════════════════════════════════

it('jurusan kuliah memiliki relasi has many ke skor jurusan', function () {
    $jurusanKuliah = new JurusanKuliah();

    expect($jurusanKuliah->skorJurusan())->toBeInstanceOf(HasMany::class);
    expect($jurusanKuliah->skorJurusan()->getRelated())->toBeInstanceOf(SkorJurusan::class);
    expect($jurusanKuliah->skorJurusan()->getForeignKeyName())->toBe('jurusan_kuliah_id');
});

it('jurusan kuliah memiliki relasi has many ke hasil jurusan', function () {
    $jurusanKuliah = new JurusanKuliah();

    expect($jurusanKuliah->hasilJurusan())->toBeInstanceOf(HasMany::class);
    expect($jurusanKuliah->hasilJurusan()->getRelated())->toBeInstanceOf(HasilJurusan::class);
    expect($jurusanKuliah->hasilJurusan()->getForeignKeyName())->toBe('jurusan_kuliah_id');
});

it('jurusan kuliah memiliki relasi has many ke kuisoner', function () {
    $jurusanKuliah = new JurusanKuliah();

    expect($jurusanKuliah->kuisoner())->toBeInstanceOf(HasMany::class);
    expect($jurusanKuliah->kuisoner()->getRelated())->toBeInstanceOf(Kuisoner::class);
    expect($jurusanKuliah->kuisoner()->getForeignKeyName())->toBe('jurusan_kuliah_id');
});

// ══════════════════════════════════════════════════════════════
// Relasi many to many pada model jurusan kuliah
// ══════════════════════════════════════════════════════════════

it('jurusan kuliah memiliki relasi many to many ke bidang', function () {
    $jurusanKuliah = new JurusanKuliah();

    expect($jurusanKuliah->bidangs())->toBeInstanceOf(BelongsToMany::class);
    expect($jurusanKuliah->bidangs()->getRelated())->toBeInstanceOf(Bidang::class);
    expect($jurusanKuliah->bidangs()->getTable())->toBe('jurusan_kuliah_bidang');
    expect($jurusanKuliah->bidangs()->getForeignPivotKeyName())->toBe('jurusan_kuliah_id');
    expect($jurusanKuliah->bidangs()->getRelatedPivotKeyName())->toBe('bidang_id');
});

// ══════════════════════════════════════════════════════════════
// Query skill pada model jurusan kuliah
// ══════════════════════════════════════════════════════════════

it('jurusan kuliah dapat membuat query skill berdasarkan bidang yang dimiliki', function () {
    $jurusanKuliah = new JurusanKuliah();
    $jurusanKuliah->id = 1;

    $query = $jurusanKuliah->skills();

    expect($query)->toBeInstanceOf(Builder::class);
    expect($query->getModel())->toBeInstanceOf(Skill::class);
});