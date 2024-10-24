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
                'id' => $this->users2->id,
                'nom' => $this->users2->nom,
                'prenom' => $this->users2->prenom,
                'email' => $this->users2->email,
                'photo' => $this->users2->photo,
                'role' => $this->users2->role,
                'telephone' => $this->users2->telephone,
                'adresse' => $this->users2->adresse,
                'date_naissance' => $this->users2->date_naissance,
                'numero_identite' => $this->users2->numero_identite,
                'etat_compte' => $this->users2->etat_compte,
            ],
        ];
    }
}
