<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurusanSmkSkill extends Model
{
    protected $table = 'jurusan_smk_skill';
    protected $fillable = ['jurusan_smk_id', 'skill_id'];

    public function jurusanSmk()
    {
        return $this->belongsTo(JurusanSmk::class, 'jurusan_smk_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }
}
