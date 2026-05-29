<?php

use App\Models\TempatMagang;
use App\Models\Skill;
use App\Models\Bidang;
use App\Models\SkorMagang;
use App\Models\HasilMagang;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model tempat magang
// ══════════════════════════════════════════════════════════════

it('model tempat magang memiliki atribut fillable yang sesuai', function () {
    $tempatMagang = new TempatMagang();

    expect($tempatMagang->getFillable())->toBe([
        'nama',
        'deskripsi',
        'latitude',
        'longitude',
        'bidang',
        'kuota',
        'kontak',
    ]);
});

it('model tempat magang menggunakan nama tabel tempat_magang', function () {
    $tempatMagang = new TempatMagang();

    expect($tempatMagang->getTable())->toBe('tempat_magang');
});

// ══════════════════════════════════════════════════════════════
// Relasi many to many pada model tempat magang
// ══════════════════════════════════════════════════════════════

it('tempat magang memiliki relasi many to many ke skill', function () {
    $tempatMagang = new TempatMagang();

    expect($tempatMagang->skills())->toBeInstanceOf(BelongsToMany::class);
    expect($tempatMagang->skills()->getRelated())->toBeInstanceOf(Skill::class);
    expect($tempatMagang->skills()->getTable())->toBe('tempat_magang_skill');
    expect($tempatMagang->skills()->getForeignPivotKeyName())->toBe('tempat_magang_id');
    expect($tempatMagang->skills()->getRelatedPivotKeyName())->toBe('skill_id');
});

it('tempat magang memiliki relasi many to many ke bidang', function () {
    $tempatMagang = new TempatMagang();

    expect($tempatMagang->bidangs())->toBeInstanceOf(BelongsToMany::class);
    expect($tempatMagang->bidangs()->getRelated())->toBeInstanceOf(Bidang::class);
    expect($tempatMagang->bidangs()->getTable())->toBe('tempat_magang_bidang');
    expect($tempatMagang->bidangs()->getForeignPivotKeyName())->toBe('tempat_magang_id');
    expect($tempatMagang->bidangs()->getRelatedPivotKeyName())->toBe('bidang_id');
});

// ══════════════════════════════════════════════════════════════
// Relasi has many pada model tempat magang
// ══════════════════════════════════════════════════════════════

it('tempat magang memiliki relasi has many ke skor magang', function () {
    $tempatMagang = new TempatMagang();

    expect($tempatMagang->skorMagang())->toBeInstanceOf(HasMany::class);
    expect($tempatMagang->skorMagang()->getRelated())->toBeInstanceOf(SkorMagang::class);
    expect($tempatMagang->skorMagang()->getForeignKeyName())->toBe('tempat_magang_id');
});

it('tempat magang memiliki relasi has many ke hasil magang', function () {
    $tempatMagang = new TempatMagang();

    expect($tempatMagang->hasilMagang())->toBeInstanceOf(HasMany::class);
    expect($tempatMagang->hasilMagang()->getRelated())->toBeInstanceOf(HasilMagang::class);
    expect($tempatMagang->hasilMagang()->getForeignKeyName())->toBe('tempat_magang_id');
});