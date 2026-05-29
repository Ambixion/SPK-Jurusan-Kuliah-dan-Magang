<?php

use App\Models\JurusanSmk;
use App\Models\Skill;
use App\Models\Bidang;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model jurusan SMK
// ══════════════════════════════════════════════════════════════

it('model jurusan smk memiliki atribut fillable yang sesuai', function () {
    $jurusanSmk = new JurusanSmk();

    expect($jurusanSmk->getFillable())->toBe([
        'nama_jurusan',
    ]);
});

it('model jurusan smk menggunakan nama tabel jurusan_smk', function () {
    $jurusanSmk = new JurusanSmk();

    expect($jurusanSmk->getTable())->toBe('jurusan_smk');
});

// ══════════════════════════════════════════════════════════════
// Relasi many to many pada model jurusan SMK
// ══════════════════════════════════════════════════════════════

it('jurusan smk memiliki relasi many to many ke skill', function () {
    $jurusanSmk = new JurusanSmk();

    expect($jurusanSmk->skills())->toBeInstanceOf(BelongsToMany::class);
    expect($jurusanSmk->skills()->getRelated())->toBeInstanceOf(Skill::class);
    expect($jurusanSmk->skills()->getTable())->toBe('jurusan_smk_skill');
    expect($jurusanSmk->skills()->getForeignPivotKeyName())->toBe('jurusan_smk_id');
    expect($jurusanSmk->skills()->getRelatedPivotKeyName())->toBe('skill_id');
});

it('jurusan smk memiliki relasi many to many ke bidang', function () {
    $jurusanSmk = new JurusanSmk();

    expect($jurusanSmk->bidangs())->toBeInstanceOf(BelongsToMany::class);
    expect($jurusanSmk->bidangs()->getRelated())->toBeInstanceOf(Bidang::class);
    expect($jurusanSmk->bidangs()->getTable())->toBe('jurusan_smk_bidang');
    expect($jurusanSmk->bidangs()->getForeignPivotKeyName())->toBe('jurusan_smk_id');
    expect($jurusanSmk->bidangs()->getRelatedPivotKeyName())->toBe('bidang_id');
});

// ══════════════════════════════════════════════════════════════
// Relasi has many pada model jurusan SMK
// ══════════════════════════════════════════════════════════════

it('jurusan smk memiliki relasi has many ke siswa', function () {
    $jurusanSmk = new JurusanSmk();

    expect($jurusanSmk->siswa())->toBeInstanceOf(HasMany::class);
    expect($jurusanSmk->siswa()->getRelated())->toBeInstanceOf(Siswa::class);
    expect($jurusanSmk->siswa()->getForeignKeyName())->toBe('jurusan_smk_id');
});