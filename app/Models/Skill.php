<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skill';
    protected $fillable = ['jenis_skill'];

    public function tempatMagang()
    {
        return $this->belongsToMany(TempatMagang::class, 'tempat_magang_skill', 'skill_id', 'tempat_magang_id')->withTimestamps();
    }

    public function jurusanSmk()
    {
        return $this->belongsToMany(JurusanSmk::class, 'jurusan_smk_skill', 'skill_id', 'jurusan_smk_id')->withTimestamps();
    }

    public function jurusanSmkSkills()
    {
        return $this->hasMany(JurusanSmkSkill::class, 'skill_id');
    }

    public function tempatMagangSkills()
    {
        return $this->hasMany(TempatMagangSkill::class, 'skill_id');
    }

    public function jurusanSmkPivots()
    {
        return $this->belongsToMany(JurusanSmk::class, 'jurusan_smk_skill', 'skill_id', 'jurusan_smk_id')->withTimestamps();
    }

    public function tempatMagangPivots()
    {
        return $this->belongsToMany(TempatMagang::class, 'tempat_magang_skill', 'skill_id', 'tempat_magang_id')->withTimestamps();
    }
}
