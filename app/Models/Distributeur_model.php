<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributeur_model extends Model
{
    use HasFactory;

    // Nom de la table (users)
    protected $table = 'users';

    // Attributs remplissables
    protected $fillable = [
        'nom', 
        'prenom', 
        'email', 
        'password', 
        'role', 
        'etat_compte', 
        'solde'
    ];

    // Méthode pour filtrer uniquement les distributeurs
    public function scopeDistributeurs($query)
    {
        return $query->where('role', 'distributeur');
    }
}
