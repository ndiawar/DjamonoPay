<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'montant',
        'frais',
        'commission',
        'etat',
        'motif',
        'date'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'frais' => 'decimal:2',
        'commission' => 'decimal:2',
        'date' => 'datetime'
    ];

    public function user() {
        return $this->belongsTo(User::class); // Ok, la clé étrangère doit être 'user_id' ou 'client_id' selon la logique
    }

    public function compte() {
        return $this->belongsTo(Compte::class); // Pas de clé étrangère définie ici. Tu devrais avoir 'compte_id' dans la table transactions.
    }

    public function distributeur() {
        return $this->belongsTo(User::class, 'distributeur_id'); // Ok, la clé étrangère est 'distributeur_id'
    }
}