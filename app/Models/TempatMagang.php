<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempatMagang extends Model
{
    protected $table = 'tempat_magang';

    protected $fillable = ['nama', 'deskripsi', 'latitude', 'longitude', 'bidang', 'kuota', 'kontak'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'tempat_magang_skill', 'tempat_magang_id', 'skill_id')->withTimestamps();
    }

    public function skillPivots()
    {
        return $this->hasMany(TempatMagangSkill::class, 'tempat_magang_id');
    }

    public function skorMagang()
    {
        return $this->hasMany(SkorMagang::class, 'tempat_magang_id');
    }

    public function hasilMagang()
    {
        return $this->hasMany(HasilMagang::class, 'tempat_magang_id');
    }
}
