<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserRole;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // protected $table = 'users'; // Indiquer la table si différente du nom par défaut

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'photo',
        'password',
        'role',
        'telephone',
        'adresse',
        'date_naissance',
        'numero_identite',
        'etat_compte'
    ];

    protected $hidden = [
        'password',
    ];

    // Fonction pour vérifier si l'utilisateur est un agent
    public function isAgent()
    {
        return $this->role === UserRole::AGENT;
    }
}
