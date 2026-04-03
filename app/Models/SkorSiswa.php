<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkorSiswa extends Model
{
    protected $table = 'skor_siswa';

    protected $fillable = ['siswa_id', 'kriteria_id', 'score'];

    public function siswa() {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kriteria() {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
