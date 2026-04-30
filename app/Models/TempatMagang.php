<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempatMagang extends Model
{
    protected $table = 'tempat_magang';

    protected $fillable = ['nama', 'deskripsi', 'lokasi', 'kuota', 'kontak'];

    public function skorMagang() {
        return $this->hasMany(SkorMagang::class, 'tempat_magang_id');
    }

    public function hasilMagang() {
        return $this->hasMany(HasilMagang::class, 'tempat_magang_id');
    }
}
