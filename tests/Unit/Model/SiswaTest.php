<?php

use App\Models\Siswa;
use App\Models\User;
use App\Models\JurusanSmk;
use App\Models\Skill;
use App\Models\SkorSiswa;
use App\Models\JawabanSiswa;
use App\Models\NilaiSiswa;
use App\Models\HasilJurusan;
use App\Models\HasilMagang;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ══════════════════════════════════════════════════════════════
// Konfigurasi dasar model siswa
// ══════════════════════════════════════════════════════════════

it('model siswa memiliki atribut fillable yang sesuai', function () {
    $siswa = new Siswa();

    expect($siswa->getFillable())->toBe([
        'users_id',
        'jurusan_smk_id',
        'nisn',
        'kelas',
        'semester',
        'no_telp',
        'alamat',
        'preferensi_lokasi',
    ]);
});

it('model siswa menggunakan nama tabel siswa', function () {
    $siswa = new Siswa();

    expect($siswa->getTable())->toBe('siswa');
});

// ══════════════════════════════════════════════════════════════
// Relasi belongs to pada model siswa
// ══════════════════════════════════════════════════════════════

it('siswa memiliki relasi belongs to ke user', function () {
    $siswa = new Siswa();

    expect($siswa->user())->toBeInstanceOf(BelongsTo::class);
    expect($siswa->user()->getRelated())->toBeInstanceOf(User::class);
    expect($siswa->user()->getForeignKeyName())->toBe('users_id');
});

it('siswa memiliki relasi belongs to ke jurusan smk', function () {
    $siswa = new Siswa();

    expect($siswa->jurusanSmk())->toBeInstanceOf(BelongsTo::class);
    expect($siswa->jurusanSmk()->getRelated())->toBeInstanceOf(JurusanSmk::class);
    expect($siswa->jurusanSmk()->getForeignKeyName())->toBe('jurusan_smk_id');
});

// ══════════════════════════════════════════════════════════════
// Relasi many to many pada model siswa
// ══════════════════════════════════════════════════════════════

it('siswa memiliki relasi many to many ke skill tambahan', function () {
    $siswa = new Siswa();

    expect($siswa->skillTambahan())->toBeInstanceOf(BelongsToMany::class);
    expect($siswa->skillTambahan()->getRelated())->toBeInstanceOf(Skill::class);
    expect($siswa->skillTambahan()->getTable())->toBe('siswa_skill');
});

// ══════════════════════════════════════════════════════════════
// Relasi has many pada model siswa
// ══════════════════════════════════════════════════════════════

it('siswa memiliki relasi has many ke skor siswa', function () {
    $siswa = new Siswa();

    expect($siswa->skorSiswa())->toBeInstanceOf(HasMany::class);
    expect($siswa->skorSiswa()->getRelated())->toBeInstanceOf(SkorSiswa::class);
    expect($siswa->skorSiswa()->getForeignKeyName())->toBe('siswa_id');
});

it('siswa memiliki relasi has many ke jawaban siswa', function () {
    $siswa = new Siswa();

    expect($siswa->jawabanSiswa())->toBeInstanceOf(HasMany::class);
    expect($siswa->jawabanSiswa()->getRelated())->toBeInstanceOf(JawabanSiswa::class);
    expect($siswa->jawabanSiswa()->getForeignKeyName())->toBe('siswa_id');
});

it('siswa memiliki relasi has many ke nilai siswa', function () {
    $siswa = new Siswa();

    expect($siswa->nilaiSiswa())->toBeInstanceOf(HasMany::class);
    expect($siswa->nilaiSiswa()->getRelated())->toBeInstanceOf(NilaiSiswa::class);
    expect($siswa->nilaiSiswa()->getForeignKeyName())->toBe('siswa_id');
});

it('relasi nilai merupakan alias dari relasi nilai siswa', function () {
    $siswa = new Siswa();

    expect($siswa->nilai())->toBeInstanceOf(HasMany::class);
    expect($siswa->nilai()->getRelated())->toBeInstanceOf(NilaiSiswa::class);
    expect($siswa->nilai()->getForeignKeyName())->toBe('siswa_id');
});

it('siswa memiliki relasi has many ke hasil jurusan', function () {
    $siswa = new Siswa();

    expect($siswa->hasilJurusan())->toBeInstanceOf(HasMany::class);
    expect($siswa->hasilJurusan()->getRelated())->toBeInstanceOf(HasilJurusan::class);
    expect($siswa->hasilJurusan()->getForeignKeyName())->toBe('siswa_id');
});

it('siswa memiliki relasi has many ke hasil magang', function () {
    $siswa = new Siswa();

    expect($siswa->hasilMagang())->toBeInstanceOf(HasMany::class);
    expect($siswa->hasilMagang()->getRelated())->toBeInstanceOf(HasilMagang::class);
    expect($siswa->hasilMagang()->getForeignKeyName())->toBe('siswa_id');
});

// ══════════════════════════════════════════════════════════════
// Accessor pada model siswa
// ══════════════════════════════════════════════════════════════

it('siswa dapat mengambil atribut jurusan siswa dari relasi jurusan smk', function () {
    $siswa = new Siswa();

    $jurusan = new JurusanSmk();
    $jurusan->nama_jurusan = 'Rekayasa Perangkat Lunak';

    $siswa->setRelation('jurusanSmk', $jurusan);

    expect($siswa->jurusan_siswa)->toBe('Rekayasa Perangkat Lunak');
});

it('siswa mengembalikan tanda strip jika relasi jurusan smk kosong', function () {
    $siswa = new Siswa();

    $siswa->setRelation('jurusanSmk', null);

    expect($siswa->jurusan_siswa)->toBe('-');
});