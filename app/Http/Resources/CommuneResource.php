<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\VilleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommuneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
{
    return [
        'nom' => $this->nom,
        'nombreCitoyen' => $this->nombreCitoyen,
        'image' => $this->image,
        'ville' => $this->when($this->ville, new VilleResource($this->ville)),
       
    ];
}
}
