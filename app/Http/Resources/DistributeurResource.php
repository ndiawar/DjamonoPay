<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistributeurResource extends JsonResource
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
            'solde' => $this->solde,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // Informations de l'utilisateur associé
            'user' => [
                'id' => $this->user->id,
                'nom' => $this->user->nom,
                'prenom' => $this->user->prenom,
                'email' => $this->user->email,
                'photo' => $this->user->photo,
                'role' => $this->user->role,
                'telephone' => $this->user->telephone,
                'adresse' => $this->user->adresse,
                'date_naissance' => $this->user->date_naissance,
                'numero_identite' => $this->user->numero_identite,
                'etat_compte' => $this->user->etat_compte,
            ],
        ];
    }
}
