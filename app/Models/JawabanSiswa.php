<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    protected $table = 'jawaban_siswa';

    protected $fillable = ['kuisoner_opsi_id', 'siswa_id'];

    public function siswa() {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function opsi() {
        return $this->belongsTo(KuisonerOpsi::class, 'kuisoner_opsi_id');
    }
}
