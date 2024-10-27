<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // protected $table = 'users'; // Indiquer la table si différente du nom par défaut

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
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

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_naissance' => 'date',
    ];

    /**
     * Les accesseurs à ajouter au tableau du modèle.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'nom_complet'
    ];
    public function comptes() {
        return $this->hasMany(Compte::class); // Ok, la clé étrangère est 'user_id'
    }
    
    public function distributeurs()
        {
            return $this->hasMany(Distributeur::class, 'user_id');
        }

    public function transactions() {
        return $this->hasMany(Transaction::class); // Pas de clé étrangère définie ici. Cela dépend de la logique d'association.
    }
    // Méthode pour vérifier si un utilisateur est un distributeur
    public function isDistributeur()
    {
        return $this->role === 'distributeur';
    }
}
 