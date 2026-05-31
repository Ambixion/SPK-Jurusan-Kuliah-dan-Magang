<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurusanKuliah extends Model
{

    use HasFactory;

    protected $table = 'jurusan_kuliah';
    protected $fillable = ['nama', 'deskripsi', 'bidang_studi'];

    public function skorJurusan()
    {
        return $this->hasMany(SkorJurusan::class, 'jurusan_kuliah_id');
    }

    public function hasilJurusan()
    {
        return $this->hasMany(HasilJurusan::class, 'jurusan_kuliah_id');
    }

    // Bidang yang dimiliki jurusan ini
    public function bidangs()
    {
        return $this->belongsToMany(Bidang::class, 'jurusan_kuliah_bidang', 'jurusan_kuliah_id', 'bidang_id')
            ->withTimestamps();
    }

    // Kuisoner khusus jurusan ini
    public function kuisoner()
    {
        return $this->hasMany(Kuisoner::class, 'jurusan_kuliah_id');
    }

    // Semua skill dari semua bidang yang dimiliki jurusan ini
    public function skills()
    {
        return Skill::whereHas('bidangs', function ($q) {
            $q->whereHas('jurusanKuliah', fn($q2) => $q2->where('jurusan_kuliah.id', $this->id));
        });
    }
}
