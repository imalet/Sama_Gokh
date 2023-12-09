<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'nombreCitoyen',
        'image',
        'ville_id'
    ];

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville_id');
    }
}
