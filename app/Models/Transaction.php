<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    // Les attributs pouvant être assignés en masse
    protected $fillable = [
        'user_id',     // ID de l'utilisateur qui a effectué la transaction
        'type',        // Type de transaction (dépot, transfert, etc.)
        'montant',     // Montant de la transaction
        'frais',       // Frais associés à la transaction
        'commission',   // Commission sur la transaction
        'etat',        // État de la transaction (réussie, annulée, etc.)
        'motif',       // Motif de la transaction
        'date'         // Date de la transaction
    ];

    // Casts pour formater les attributs
    protected $casts = [
        'montant' => 'decimal:2',     // Montant formaté en décimal avec 2 chiffres après la virgule
        'frais' => 'decimal:2',        // Frais formatés de la même manière
        'commission' => 'decimal:2',   // Commission formatée
        'date' => 'datetime'            // Date formatée en tant que datetime
    ];

    // Relation avec le modèle User
    public function user() {
        return $this->belongsTo(User::class); // La clé étrangère est par défaut 'user_id'
    }

    // Relation avec le modèle Compte
    public function compte() {
        return $this->belongsTo(Compte::class); // S'assurez d'avoir 'compte_id' dans la table transactions
    }

    // Relation avec le modèle User pour le distributeur
    public function distributeur() {
        return $this->belongsTo(User::class, 'distributeur_id'); // La clé étrangère est 'distributeur_id'
    }
}
