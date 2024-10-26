<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'numero' => $this->numero,
            'solde' => $this->solde,
            'qr_code' => $this->qr_code,
            'est_bloque' => $this->est_bloque,
            'qr_code_creation' => $this->qr_code_creation,
        ];
    }
}
