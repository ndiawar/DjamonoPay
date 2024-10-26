<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id, // Si vous le conservez
            // Ajoutez d'autres champs spécifiques à l'agent ici
            'transactions' => TransactionResource::collection($this->transactions),
            // Notez que les agents n'ont pas de comptes
        ];
    }
}
