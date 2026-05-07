<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempatMagangSkill extends Model
{
    protected $table = 'tempat_magang_skill';
    protected $fillable = ['tempat_magang_id', 'skill_id'];

    public function tempatMagang()
    {
        return $this->belongsTo(TempatMagang::class, 'tempat_magang_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }
}
