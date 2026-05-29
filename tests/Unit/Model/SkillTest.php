<?php

use App\Models\Skill;
use App\Models\TempatMagang;
use App\Models\JurusanSmk;
use App\Models\JurusanSmkSkill;
use App\Models\TempatMagangSkill;
use App\Models\Bidang;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model skill
// ══════════════════════════════════════════════════════════════

it('model skill memiliki atribut fillable yang sesuai', function () {
    $skill = new Skill();

    expect($skill->getFillable())->toBe([
        'jenis_skill',
    ]);
});

it('model skill menggunakan nama tabel skill', function () {
    $skill = new Skill();

    expect($skill->getTable())->toBe('skill');
});

// ══════════════════════════════════════════════════════════════
// Relasi many to many pada model skill
// ══════════════════════════════════════════════════════════════

it('skill memiliki relasi many to many ke tempat magang', function () {
    $skill = new Skill();

    expect($skill->tempatMagang())->toBeInstanceOf(BelongsToMany::class);
    expect($skill->tempatMagang()->getRelated())->toBeInstanceOf(TempatMagang::class);
    expect($skill->tempatMagang()->getTable())->toBe('tempat_magang_skill');
    expect($skill->tempatMagang()->getForeignPivotKeyName())->toBe('skill_id');
    expect($skill->tempatMagang()->getRelatedPivotKeyName())->toBe('tempat_magang_id');
});

it('skill memiliki relasi many to many ke jurusan smk', function () {
    $skill = new Skill();

    expect($skill->jurusanSmk())->toBeInstanceOf(BelongsToMany::class);
    expect($skill->jurusanSmk()->getRelated())->toBeInstanceOf(JurusanSmk::class);
    expect($skill->jurusanSmk()->getTable())->toBe('jurusan_smk_skill');
    expect($skill->jurusanSmk()->getForeignPivotKeyName())->toBe('skill_id');
    expect($skill->jurusanSmk()->getRelatedPivotKeyName())->toBe('jurusan_smk_id');
});

it('skill memiliki relasi many to many ke jurusan smk melalui jurusan smk pivots', function () {
    $skill = new Skill();

    expect($skill->jurusanSmkPivots())->toBeInstanceOf(BelongsToMany::class);
    expect($skill->jurusanSmkPivots()->getRelated())->toBeInstanceOf(JurusanSmk::class);
    expect($skill->jurusanSmkPivots()->getTable())->toBe('jurusan_smk_skill');
    expect($skill->jurusanSmkPivots()->getForeignPivotKeyName())->toBe('skill_id');
    expect($skill->jurusanSmkPivots()->getRelatedPivotKeyName())->toBe('jurusan_smk_id');
});

it('skill memiliki relasi many to many ke tempat magang melalui tempat magang pivots', function () {
    $skill = new Skill();

    expect($skill->tempatMagangPivots())->toBeInstanceOf(BelongsToMany::class);
    expect($skill->tempatMagangPivots()->getRelated())->toBeInstanceOf(TempatMagang::class);
    expect($skill->tempatMagangPivots()->getTable())->toBe('tempat_magang_skill');
    expect($skill->tempatMagangPivots()->getForeignPivotKeyName())->toBe('skill_id');
    expect($skill->tempatMagangPivots()->getRelatedPivotKeyName())->toBe('tempat_magang_id');
});

it('skill memiliki relasi many to many ke bidang', function () {
    $skill = new Skill();

    expect($skill->bidangs())->toBeInstanceOf(BelongsToMany::class);
    expect($skill->bidangs()->getRelated())->toBeInstanceOf(Bidang::class);
    expect($skill->bidangs()->getTable())->toBe('bidang_skill');
    expect($skill->bidangs()->getForeignPivotKeyName())->toBe('skill_id');
    expect($skill->bidangs()->getRelatedPivotKeyName())->toBe('bidang_id');
});

// ══════════════════════════════════════════════════════════════
// Relasi has many pada model skill
// ══════════════════════════════════════════════════════════════

it('skill memiliki relasi has many ke jurusan smk skill', function () {
    $skill = new Skill();

    expect($skill->jurusanSmkSkills())->toBeInstanceOf(HasMany::class);
    expect($skill->jurusanSmkSkills()->getRelated())->toBeInstanceOf(JurusanSmkSkill::class);
    expect($skill->jurusanSmkSkills()->getForeignKeyName())->toBe('skill_id');
});

it('skill memiliki relasi has many ke tempat magang skill', function () {
    $skill = new Skill();

    expect($skill->tempatMagangSkills())->toBeInstanceOf(HasMany::class);
    expect($skill->tempatMagangSkills()->getRelated())->toBeInstanceOf(TempatMagangSkill::class);
    expect($skill->tempatMagangSkills()->getForeignKeyName())->toBe('skill_id');
});