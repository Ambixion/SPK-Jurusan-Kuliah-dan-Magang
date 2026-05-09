<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'bidang';
    protected $fillable = ['nama', 'deskripsi'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'bidang_skill', 'bidang_id', 'skill_id')
                    ->withTimestamps();
    }

    public function jurusanKuliah()
    {
        return $this->belongsToMany(JurusanKuliah::class, 'jurusan_kuliah_bidang', 'bidang_id', 'jurusan_kuliah_id')
                    ->withTimestamps();
    }

    public function jurusanSmk()
    {
        return $this->belongsToMany(JurusanSmk::class, 'jurusan_smk_bidang', 'bidang_id', 'jurusan_smk_id')
                    ->withTimestamps();
    }

    public function tempatMagang()
    {
        return $this->belongsToMany(TempatMagang::class, 'tempat_magang_bidang', 'bidang_id', 'tempat_magang_id')
                    ->withTimestamps();
    }

    public function kuisoner()
    {
        return $this->hasMany(Kuisoner::class, 'bidang_id');
    }
}
