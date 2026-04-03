<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuisoner extends Model
{
    protected $table = 'kuisoner';

    protected $fillable = ['soal', 'type'];

    public function opsi() {
        return $this->hasMany(KuisonerOpsi::class, 'kuisoner_id');
    }
}
