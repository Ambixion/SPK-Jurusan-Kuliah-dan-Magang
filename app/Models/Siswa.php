<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'users_id',
        'jurusan_smk_id',
        'nisn',
        'kelas',
        'semester',
        'no_telp',
        'alamat',
    ];

    // =====================================================================
    // RELATIONSHIPS
    // =====================================================================

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function jurusanSmk()
    {
        return $this->belongsTo(JurusanSmk::class, 'jurusan_smk_id');
    }

    public function skorSiswa()
    {
        return $this->hasMany(SkorSiswa::class, 'siswa_id');
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class, 'siswa_id');
    }

    public function nilaiSiswa()
    {
        return $this->hasMany(NilaiSiswa::class, 'siswa_id');
    }

    // Alias agar bisa dipanggil dengan ->nilai() juga (backward compat)
    public function nilai()
    {
        return $this->nilaiSiswa();
    }

    public function hasilJurusan()
    {
        return $this->hasMany(HasilJurusan::class, 'siswa_id');
    }

    public function hasilMagang()
    {
        return $this->hasMany(HasilMagang::class, 'siswa_id');
    }

    // =====================================================================
    // ACCESSORS
    // =====================================================================

    /**
     * Accessor jurusan_siswa → nama jurusan SMK dari relasi
     * Dipakai di view: $siswa->jurusan_siswa
     */
    public function getJurusanSiswaAttribute(): string
    {
        return $this->jurusanSmk->nama_jurusan ?? '-';
    }

    /**
     * Nilai rata-rata rapot dari tabel nilai_siswa
     * Dipakai di view: $siswa->nilai_rata
     */
    public function getNilaiRataAttribute(): float
    {
        return round($this->nilaiSiswa()->avg('nilai') ?? 0, 2);
    }
}
