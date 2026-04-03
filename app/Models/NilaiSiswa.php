<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiSiswa extends Model
{
    protected $table = 'nilai_siswa';

    protected $fillable = ['siswa_id', 'mata_pelajaran', 'nilai', 'semester', 'tahun_ajaran'];

    public function siswa() {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
