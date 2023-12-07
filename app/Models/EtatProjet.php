<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtatProjet extends Model
{
    use HasFactory;

    public function projets(){
        return $this->hasMany(Projet::class);
    }
}
