<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends User
{
    use HasFactory;

    protected $fillable = [
        // Ajoutez ici les attributs spécifiques au client, si nécessaire
    ];
}
