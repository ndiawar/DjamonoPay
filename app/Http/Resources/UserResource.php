<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'role' => $this->role,
            'telephone' => $this->telephone,
            'adresse' => $this->adresse,
            'date_naissance' => $this->date_naissance,
            'numero_identite' => $this->numero_identite,
            'photo' => $this->photo,
            'etat_compte' => $this->etat_compte,
        ];
    }
}
