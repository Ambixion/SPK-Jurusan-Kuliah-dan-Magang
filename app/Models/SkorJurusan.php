<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkorJurusan extends Model
{
    use HasFactory;
    protected $table = 'skor_jurusan';

    protected $fillable = ['jurusan_kuliah_id', 'kriteria_id', 'score'];

    protected $casts = [
        'score' => 'integer',
    ];

    public function jurusan() {
        return $this->belongsTo(JurusanKuliah::class, 'jurusan_kuliah_id');
    }

    public function kriteria() {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
