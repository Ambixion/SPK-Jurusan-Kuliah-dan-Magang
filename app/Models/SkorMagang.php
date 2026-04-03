<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkorMagang extends Model
{
    protected $table = 'skor_magang';

    protected $fillable = ['tempat_magang_id', 'kriteria_id', 'score'];

    public function tempatMagang() {
        return $this->belongsTo(TempatMagang::class, 'tempat_magang_id');
    }

    public function kriteria() {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
