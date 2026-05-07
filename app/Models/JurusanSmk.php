<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurusanSmk extends Model
{
    protected $table = 'jurusan_smk';
    protected $fillable = ['nama_jurusan'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'jurusan_smk_skill', 'jurusan_smk_id', 'skill_id')->withTimestamps();
    }

    public function skillPivots()
    {
        return $this->hasMany(JurusanSmkSkill::class, 'jurusan_smk_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'jurusan_smk_id');
    }
}
