<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilMagang extends Model
{
    protected $table = 'hasil_magang';

    protected $fillable = ['siswa_id', 'tempat_magang_id', 'score', 'rank'];

    public function siswa() {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function tempatMagang() {
        return $this->belongsTo(TempatMagang::class, 'tempat_magang_id');
    }
}
