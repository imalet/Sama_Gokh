<?php

namespace App\Models;

use App\Models\EtatProjet;
use App\Models\TypeProjet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    public function typeProjet(){
        return $this->belongsTo(TypeProjet::class);
    }

    public function etatProjet(){
        return $this->belongsTo(EtatProjet::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }
}
