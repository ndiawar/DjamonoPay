<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    // Constantes pour l'état du compte
    public const ETAT_ACTIF = 'actif';
    public const ETAT_BLOQUE = 'bloque';

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
        'etat_compte' => 'string',
        'role' => UserRole::class
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
     * Valeurs par défaut des attributs
     *
     * @var array
     */
    protected $attributes = [
        'etat_compte' => self::ETAT_ACTIF
    ];

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            switch ($user->role) {
                case UserRole::CLIENT:
                    Compte::createWithNumber([
                        'solde' => 0,
                        'est_bloque' => false
                    ], $user);
                    break;
                case UserRole::DISTRIBUTEUR:
                    $user->distributeur()->create([
                        'solde' => 0
                    ]);
                    break;
                case UserRole::AGENT:
                    $user->agent()->create([]);
                    break;
            }
        });
    }

    /**
     * Obtenir la relation avec le modèle Distributeur
     */
    public function distributeur(): HasOne
    {
        return $this->hasOne(Distributeur::class, 'user_id');
    }

    /**
     * Obtenir la relation avec le modèle Agent
     */
    public function agent(): HasOne
    {
        return $this->hasOne(Agent::class, 'user_id');
    }

    /**
     * Obtenir la relation avec le modèle Compte
     */
    public function compte(): HasOne
    {
        return $this->hasOne(Compte::class, 'user_id');
    }

    /**
     * Obtenir le profil selon le rôle
     */
    public function profil()
    {
        return match ($this->role) {
            UserRole::CLIENT => $this->compte,
            UserRole::DISTRIBUTEUR => $this->distributeur,
            UserRole::AGENT => $this->agent,
            default => null
        };
    }

    /**
     * Obtenir le nom complet de l'utilisateur
     */
    public function getNomCompletAttribute(): string
    {
        return "{$this->nom} {$this->prenom}";
    }

    /**
     * Obtenir toutes les transactions où l'utilisateur est le client
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Obtenir toutes les transactions où l'utilisateur est le distributeur
     */
    public function transactionsDistribuees(): HasMany
    {
        return $this->hasMany(Transaction::class, 'distributeur_id');
    }

    /**
     * Obtenir toutes les transactions où l'utilisateur est l'agent
     */
    public function transactionsAgent(): HasMany
    {
        return $this->hasMany(Transaction::class, 'agent_id');
    }

    /**
     * Obtenir les transactions actives de l'utilisateur
     */
    public function transactionsActives(): HasMany
    {
        return $this->transactions()->where('etat', 'en_attente');
    }

    /**
     * Définir une requête pour inclure uniquement les utilisateurs d'un rôle donné
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Vérifier si l'utilisateur est un agent
     */
    public function isAgent(): bool
    {
        return $this->role === UserRole::AGENT;
    }

    /**
     * Vérifier si l'utilisateur est un distributeur
     */
    public function isDistributeur(): bool
    {
        return $this->role === UserRole::DISTRIBUTEUR;
    }

    /**
     * Vérifier si l'utilisateur est un client
     */
    public function isClient(): bool
    {
        return $this->role === UserRole::CLIENT;
    }

    /**
     * Vérifier si le compte est actif
     */
    public function isActive(): bool
    {
        return $this->etat_compte === self::ETAT_ACTIF;
    }

    /**
     * Vérifier si le compte est bloqué
     */
    public function isBlocked(): bool
    {
        return $this->etat_compte === self::ETAT_BLOQUE;
    }

    /**
     * Vérifier si l'utilisateur a un profil
     */
    public function hasProfile(): bool
    {
        return $this->profil() !== null;
    }

    /**
     * Obtenir le solde de l'utilisateur
     */
    public function getSolde()
    {
        return match ($this->role) {
            UserRole::CLIENT => $this->compte?->solde ?? 0,
            UserRole::DISTRIBUTEUR => $this->distributeur?->solde ?? 0,
            default => 0
        };
    }

    /**
     * Obtenir la couleur associée au rôle
     */
    public function getRoleColor(): string
    {
        return UserRole::getRoleColors()[$this->role] ?? 'gray';
    }

    /**
     * Obtenir l'icône associée au rôle
     */
    public function getRoleIcon(): string
    {
        return UserRole::getRoleIcon($this->role);
    }

    /**
     * Vérifier si l'utilisateur peut gérer les utilisateurs
     */
    public function canManageUsers(): bool
    {
        return UserRole::canManageUsers($this->role);
    }

    /**
     * Vérifier si l'utilisateur peut gérer les transactions
     */
    public function canManageTransactions(): bool
    {
        return UserRole::canManageTransactions($this->role);
    }
}