<?php

namespace App\Models;

use Database\Seeders\SkorJurusan;
use Illuminate\Database\Eloquent\Model;

class JurusanKuliah extends Model
{
    protected $table = 'jurusan_kuliah';

    protected $fillable = ['nama', 'deskripsi', 'universitas', 'akreditasi', 'bidang_studi'];

    public function skorJurusan() {
        return $this->hasMany(SkorJurusan::class, 'jurusan_kuliah_id');
    }

    public function hasilJurusan() {
        return $this->hasMany(HasilJurusan::class, 'jurusan_kuliah_id');
    }
}
