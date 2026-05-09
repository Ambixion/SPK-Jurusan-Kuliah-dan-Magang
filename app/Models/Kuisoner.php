<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuisoner extends Model
{
    protected $table = 'kuisoner';
    protected $fillable = [
        'soal', 'type',
        'jurusan_kuliah_id', 'bidang_id', 'kriteria_id', 'urutan'
    ];

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

    // Relasi ke kriteria SAW — ini kunci scoring yang akurat
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    // Scope: soal untuk jurusan tertentu atau global (null)
    public function scopeUntukJurusan($query, ?int $jurusanKuliahId)
    {
        return $query->where(function ($q) use ($jurusanKuliahId) {
            $q->where('jurusan_kuliah_id', $jurusanKuliahId)
              ->orWhereNull('jurusan_kuliah_id');
        });
    }

    // Scope: soal untuk bidang tertentu atau global (null)
    public function scopeUntukBidang($query, ?int $bidangId)
    {
        return $query->where(function ($q) use ($bidangId) {
            $q->where('bidang_id', $bidangId)
              ->orWhereNull('bidang_id');
        });
    }
}
