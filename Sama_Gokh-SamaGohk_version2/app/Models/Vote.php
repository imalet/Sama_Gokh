<?php

namespace App\Models;

use App\Models\Projet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    public function projet(){
        return $this->belongsTo(Projet::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
