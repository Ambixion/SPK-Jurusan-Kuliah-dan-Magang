<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurusanKuliah extends Model
{
    protected $table = 'jurusan_kuliah';
    protected $fillable = ['nama', 'deskripsi', 'bidang_studi'];

    // ✅ FIX: hapus use Database\Seeders\SkorJurusan yang salah
    public function skorJurusan()
    {
        return $this->hasMany(\App\Models\SkorJurusan::class, 'jurusan_kuliah_id');
    }

    public function hasilJurusan()
    {
        return $this->hasMany(HasilJurusan::class, 'jurusan_kuliah_id');
    }
}
