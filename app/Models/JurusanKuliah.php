<?php

namespace App\Models;

use App\Models\SkorJurusan;
use Illuminate\Database\Eloquent\Model;

class JurusanKuliah extends Model
{
    protected $table = 'jurusan_kuliah';

    protected $fillable = ['nama', 'deskripsi', 'bidang_studi'];

    public function skorJurusan() {
        return $this->hasMany(SkorJurusan::class, 'jurusan_kuliah_id');
    }

    public function hasilJurusan() {
        return $this->hasMany(HasilJurusan::class, 'jurusan_kuliah_id');
    }
}
