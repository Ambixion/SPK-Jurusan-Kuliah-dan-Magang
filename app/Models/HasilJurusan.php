<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilJurusan extends Model
{
    protected $table = 'hasil_jurusan';

    protected $fillable = ['siswa_id', 'jurusan_kuliah_id', 'score', 'rank'];

    public function siswa() {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function jurusan() {
        return $this->belongsTo(JurusanKuliah::class, 'jurusan_kuliah_id');
    }
}
