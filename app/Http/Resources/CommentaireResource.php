<?php

namespace App\Http\Resources;

use App\Http\Resources\AnnonceResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentaireResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'contenu' => $this->contenu,
            'annonce' => new AnnonceResource($this->annonce),
            'user' => new UserResource($this->user),
        ];
    }
}
