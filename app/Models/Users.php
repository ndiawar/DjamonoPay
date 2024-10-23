<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserRole;

class Users2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'photo',
        'mot_de_passe',
        'role',
        'telephone',
        'adresse',
        'date_naissance',
        'numero_identite',
        'etat_compte'
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'etat_compte' => 'boolean',
        'role' => UserRole::class,
        'mot_de_passe' => 'hashed',
    ];
}
