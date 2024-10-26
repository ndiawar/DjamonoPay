<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id, // Si vous le conservez
            'transactions' => TransactionResource::collection($this->transactions),
            'comptes' => CompteResource::collection($this->comptes),
        ];
    }
}