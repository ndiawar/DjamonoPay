<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'distributeur_id' => $this->distributeur_id,
            'type' => $this->type,
            'montant' => $this->montant,
            'frais' => $this->frais,
            'commission' => $this->commission,
            'etat' => $this->etat,
            'motif' => $this->motif,
            'date' => $this->date,
        ];
    }
}
