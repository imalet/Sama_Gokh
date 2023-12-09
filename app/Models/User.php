<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Controllers\AnnonceController;
use App\Models\Annonce;
use App\Models\Commentaire;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'commune_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function commune(){
        return $this->belongsTo(Commune::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function annonce(){
        return $this->hasMany(Annonce::class);
    }

    public function commentaires(){
        return $this->hasMany(Commentaire::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }
    
}
