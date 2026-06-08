<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = ['nama', 'npm', 'prodi_id', 'foto'];

    public function prodi(){
        return $this->belongsTo(Prodi::class);
    }
}
