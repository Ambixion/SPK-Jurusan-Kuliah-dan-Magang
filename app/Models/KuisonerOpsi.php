<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisonerOpsi extends Model
{
    use HasFactory;
    protected $table = 'kuisoner_opsi';

    protected $fillable = ['kuisoner_id', 'jawaban', 'nilai'];

    public function kuisoner() {
        return $this->belongsTo(Kuisoner::class, 'kuisoner_id');
    }

    public function jawabanSiswa() {
        return $this->hasMany(JawabanSiswa::class, 'kuisoner_opsi_id');
    }
}
