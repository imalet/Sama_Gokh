<?php

namespace App\Http\Resources;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "nom" => $this->nom,
            "prenom" => $this->prenom,
            "email" => $this->email,
            "telephone" => $this->telephone,
            "etat" => $this->etat,
            "username" => $this->username,
            "CNI" => $this->CNI,
            "sexe" => $this->sexe,
            "role_id" => new RoleResource($this->role),
            "commune_id" => new CommuneResource($this->commune),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
