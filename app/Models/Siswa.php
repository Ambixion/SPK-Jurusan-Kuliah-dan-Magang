<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = ['users_id', 'jurusan_siswa'];

    public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function skorSiswa() {
        return $this->hasMany(SkorSiswa::class, 'siswa_id');
    }

    public function jawabanSiswa() {
        return $this->hasMany(JawabanSiswa::class, 'siswa_id');
    }

    public function nilaiSiswa() {
        return $this->hasMany(NilaiSiswa::class, 'siswa_id');
    }

    public function hasilJurusan() {
        return $this->hasMany(HasilJurusan::class, 'siswa_id');
    }

    public function hasilMagang() {
        return $this->hasMany(HasilMagang::class, 'siswa_id');
    }
}
