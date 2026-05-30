<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurusanSmk extends Model
{

use HasFactory;
    protected $table = 'jurusan_smk';
    protected $fillable = ['nama_jurusan'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'jurusan_smk_skill', 'jurusan_smk_id', 'skill_id')
                    ->withTimestamps();
    }

    // Bidang yang dimiliki jurusan SMK ini
    public function bidangs()
    {
        return $this->belongsToMany(Bidang::class, 'jurusan_smk_bidang', 'jurusan_smk_id', 'bidang_id')
                    ->withTimestamps();
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'jurusan_smk_id');
    }
}
