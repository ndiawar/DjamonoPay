<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends User
{
    use HasFactory;

    protected $fillable = [
        // Ajoutez ici les attributs spécifiques à l'agent, si nécessaire
    ];

    // Pas besoin de définir des relations ici, car Agent n'a pas de comptes
}
