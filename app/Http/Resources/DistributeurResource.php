<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistributeurResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id, // Si vous le conservez
            // Ajoutez d'autres champs spécifiques au distributeur ici
            'transactions' => TransactionResource::collection($this->transactions),
            // Si le distributeur a des comptes, ajoutez cette ligne
            // 'comptes' => CompteResource::collection($this->comptes),
        ];
    }
}
