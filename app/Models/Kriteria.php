<?php

namespace App\Models;

use Database\Seeders\SkorJurusan;
use Database\Seeders\SkorSiswa;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected  $table = 'kriteria';

    protected $fillable = ['nama', 'weight', 'type', 'jenis'];

    public function skorSiswa()
    {
        return $this->hasMany(SkorSiswa::class, 'kriteria_id');
    }

    public function skorJurusan()
    {
        return $this->hasMany(SkorJurusan::class, 'kriteria_id');
    }

    public function skorMagang()
    {
        return $this->hasMany(SkorMagang::class, 'kriteria_id');
    }
}
