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
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Les attributs qui doivent être convertis.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_naissance' => 'date',
        'etat_compte' => 'string',
        'role' => UserRole::class
    ];

    /**
     * Les accesseurs à ajouter au tableau du modèle.
     */
    protected $appends = [
        'profile_photo_url',
        'nom_complet'
    ];

    /**
     * Valeurs par défaut des attributs
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
            try {
                switch ($user->role) {
                    case UserRole::CLIENT:
                        if (!$user->compte) {
                            Compte::createWithNumber([
                                'solde' => 0,
                                'est_bloque' => false
                            ], $user);
                        }
                        break;

                    case UserRole::DISTRIBUTEUR:
                        if (!$user->distributeur) {
                            $user->distributeur()->create(['solde' => 0]);
                            // Créer aussi un compte pour le distributeur
                            if (!$user->compte) {
                                Compte::createWithNumber([
                                    'solde' => 0,
                                    'est_bloque' => false
                                ], $user);
                            }
                        }
                        break;

                    case UserRole::AGENT:
                        if (!$user->agent) {
                            $user->agent()->create([]);
                        }
                        break;
                }
            } catch (\Exception $e) {
                report($e);
                throw $e;
            }
        });

        // Suppression en cascade
        static::deleting(function ($user) {
            $user->compte()->delete();
            $user->distributeur()->delete();
            $user->agent()->delete();
            $user->transactions()->delete();
            $user->transactionsDistribuees()->delete();
            $user->transactionsAgent()->delete();
        });
    }

    /**
     * Relations
     */
    public function distributeur(): HasOne
    {
        return $this->hasOne(Distributeur::class, 'user_id');
    }

    public function agent(): HasOne
    {
        return $this->hasOne(Agent::class, 'user_id');
    }

    public function compte(): HasOne
    {
        return $this->hasOne(Compte::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function transactionsDistribuees(): HasMany
    {
        return $this->hasMany(Transaction::class, 'distributeur_id');
    }

    public function transactionsAgent(): HasMany
    {
        return $this->hasMany(Transaction::class, 'agent_id');
    }

    /**
     * Accesseurs et Mutateurs
     */
    public function getNomCompletAttribute(): string
    {
        return "{$this->nom} {$this->prenom}";
    }

    /**
     * Scopes
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeActif($query)
    {
        return $query->where('etat_compte', self::ETAT_ACTIF);
    }

    public function scopeBloque($query)
    {
        return $query->where('etat_compte', self::ETAT_BLOQUE);
    }

    /**
     * Méthodes d'assistance
     */
    public function isAgent(): bool
    {
        return $this->role === UserRole::AGENT;
    }

    public function isDistributeur(): bool
    {
        return $this->role === UserRole::DISTRIBUTEUR;
    }

    public function isClient(): bool
    {
        return $this->role === UserRole::CLIENT;
    }

    public function isActive(): bool
    {
        return $this->etat_compte === self::ETAT_ACTIF;
    }

    public function getSolde()
    {
        return match ($this->role) {
            UserRole::CLIENT => $this->compte?->solde ?? 0,
            UserRole::DISTRIBUTEUR => $this->distributeur?->solde ?? 0,
            default => 0
        };
    }

    /**
     * Méthodes de gestion
     */
    public function bloquerCompte(): bool
    {
        $this->etat_compte = self::ETAT_BLOQUE;
        if ($this->compte) {
            $this->compte->est_bloque = true;
            $this->compte->save();
        }
        return $this->save();
    }

    public function debloquerCompte(): bool
    {
        $this->etat_compte = self::ETAT_ACTIF;
        if ($this->compte) {
            $this->compte->est_bloque = false;
            $this->compte->save();
        }
        return $this->save();
    }

    public function getProfilSpecifique()
    {
        return match ($this->role) {
            UserRole::CLIENT => $this->compte,
            UserRole::DISTRIBUTEUR => $this->distributeur,
            UserRole::AGENT => $this->agent,
            default => null
        };
    }
}