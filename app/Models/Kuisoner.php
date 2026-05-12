<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuisoner extends Model
{
    protected $table = 'kuisoner';

    protected $fillable = [
        'soal', 'type',
        'jurusan_kuliah_id',
        'bidang_id',
        'skill_id',
        'kriteria_id',
        'urutan',
    ];

    // =====================================================================
    // RELATIONSHIPS
    // =====================================================================

    public function opsi()
    {
        return $this->hasMany(KuisonerOpsi::class, 'kuisoner_id');
    }

    public function jurusanKuliah()
    {
        return $this->belongsTo(JurusanKuliah::class, 'jurusan_kuliah_id');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    // =====================================================================
    // SCOPES
    // =====================================================================

    /**
     * Soal untuk jurusan kuliah tertentu ATAU global (null)
     */
    public function scopeUntukJurusan($query, ?int $jurusanKuliahId)
    {
        return $query->where(function ($q) use ($jurusanKuliahId) {
            $q->where('jurusan_kuliah_id', $jurusanKuliahId)
              ->orWhereNull('jurusan_kuliah_id');
        });
    }

    /**
     * Soal untuk bidang tertentu ATAU global (null)
     */
    public function scopeUntukBidang($query, ?int $bidangId)
    {
        return $query->where(function ($q) use ($bidangId) {
            $q->where('bidang_id', $bidangId)
              ->orWhereNull('bidang_id');
        });
    }

    /**
     * Soal untuk kumpulan skill tertentu ATAU global (null)
     * Dipakai di PKL: ambil soal yang relevan dengan skill jurusan SMK siswa
     */
    public function scopeUntukSkills($query, array $skillIds)
    {
        return $query->where(function ($q) use ($skillIds) {
            $q->whereIn('skill_id', $skillIds)
              ->orWhereNull('skill_id');
        });
    }
}
