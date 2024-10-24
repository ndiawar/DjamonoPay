<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

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
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
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

    /**
     * Obtenir le nom complet de l'utilisateur
     *
     * @return string
     */
    public function getNomCompletAttribute(): string
    {
        return "{$this->nom} {$this->prenom}";
    }

    /**
     * Obtenir toutes les transactions où l'utilisateur est le client
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Obtenir toutes les transactions où l'utilisateur est le distributeur
     *
     * @return HasMany
     */
    public function transactionsDistribuees(): HasMany
    {
        return $this->hasMany(Transaction::class, 'distributeur_id');
    }

    /**
     * Obtenir toutes les transactions où l'utilisateur est l'agent
     *
     * @return HasMany
     */
    public function transactionsAgent(): HasMany
    {
        return $this->hasMany(Transaction::class, 'agent_id');
    }

    /**
     * Définir une requête pour inclure uniquement les utilisateurs d'un rôle donné
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Vérifier si l'utilisateur est un agent
     *
     * @return bool
     */
    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    /**
     * Vérifier si l'utilisateur est un distributeur
     *
     * @return bool
     */
    public function isDistributeur(): bool
    {
        return $this->role === 'distributeur';
    }

    /**
     * Vérifier si l'utilisateur est un client
     *
     * @return bool
     */
    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    /**
     * Obtenir les transactions actives de l'utilisateur
     *
     * @return HasMany
     */
    public function transactionsActives(): HasMany
    {
        return $this->transactions()->where('etat', 'en_attente');
    }
}