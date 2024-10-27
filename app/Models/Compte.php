<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'numero',
        'solde',
        'qr_code',
        'est_bloque',
        'qr_code_creation'
    ];

    protected $casts = [
        'solde' => 'decimal:2',
        'est_bloque' => 'boolean',
        'qr_code_creation' => 'datetime',
    ];

    /**
     * Obtenir l'utilisateur propriétaire du compte
     */
    public function user() {
        return $this->belongsTo(User::class); // Ok, la clé étrangère est 'user_id'
    }

    public function transactions() {
        return $this->hasMany(Transaction::class); // Ok, la clé étrangère doit être 'compte_id' dans Transaction
    }
    public function client()
{
    return $this->belongsTo(Client::class);
}
}