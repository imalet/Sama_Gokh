<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    public function annonce(){
        return $this->belongsTo(User::class);
    }
    
    public function commentaires(){
        return $this->hasMany(Commentaire::class);
    }
    
}
