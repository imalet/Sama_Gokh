<?php

namespace App\Http\Resources;

use App\Http\Resources\TypeProjetResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "titre" => $this->titre,
            "description" => $this->description,
            "image" => $this->image,
            "couts" => $this->couts,
            "delai" => $this->delai,
            "etat" => $this->etat,
            "type_projet_id" => new TypeProjetResource($this->typeProjet),
            "etat_projet_id" => new EtatProjetResource($this->etatProjet),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
