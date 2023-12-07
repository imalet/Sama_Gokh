<?php

namespace App\Models;

use App\Models\EtatProjet;
use App\Models\TypeProjet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    public function typeprojet(){
        return $this->belongsTo(TypeProjet::class);
    }

    public function etatprojet(){
        return $this->belongsTo(EtatProjet::class);
    }
}
