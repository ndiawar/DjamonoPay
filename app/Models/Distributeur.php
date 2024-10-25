<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Distributeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'solde',
    ];

    protected $casts = [
        'solde' => 'decimal:2'
    ];

    /**
     * Obtenir l'utilisateur associé au distributeur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtenir le compte associé au distributeur
     */
    public function compte(): BelongsTo
    {
        return $this->belongsTo(Compte::class, 'compte_id');
    }

    /**
     * Créer un nouveau distributeur avec un utilisateur associé
     */
    public static function createWithUser(array $userData): self
    {
        $user = User::create(array_merge(
            $userData,
            ['role' => UserRole::DISTRIBUTEUR]
        ));

        $compte = Compte::createWithNumber([
            'solde' => 0,
            'est_bloque' => false
        ], $user);

        return self::create([
            'user_id' => $user->id,
            'solde' => 0 // Solde initial à 0
        ]);
    }

    /**
     * Vérifier si le distributeur peut effectuer une transaction
     */
    public function peutEffectuerTransaction(float $montant): bool
    {
        return $this->compte && $this->compte->solde >= $montant;
    }

    /**
     * Relation avec les utilisateurs (pour la rétrocompatibilité)
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}