<?php

namespace App\Http\Resources;

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
        // return parent::toArray($request);
        return[
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'photo' => $this->photo,
            'role' => $this->role,
            'numero_telephone' => $this->numero_telephone,
            'adresse' => $this->adresse,
            'date_naissance' => $this->date_naissance,
            'numero_identite' => $this->numero_carte_identite,
            'etat_compte' => $this->etat_compte,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
