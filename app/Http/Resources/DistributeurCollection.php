<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DistributeurCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($distributeur) {
                return [
                    'id' => $distributeur->id,
                    'solde' => $distributeur->solde,
                    'user' => [
                        'id' => $distributeur->users2->id,
                        'nom' => $distributeur->users2->nom,
                        'prenom' => $distributeur->users2->prenom,
                        'email' => $distributeur->users2->email,
                        'telephone' => $distributeur->users2->telephone,
                        'numero_identite' => $distributeur->users2->numero_identite,
                        'etat_compte' => $distributeur->users2->etat_compte,
                    ],
                ];
            }),
            'meta' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage()
            ],
        ];
    }
}
