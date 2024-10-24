<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'distributeur_id',
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

    protected static function booted()
    {
        static::created(function ($transaction) {
            SystemLogger::createLog(
                auth()->id(),
                $transaction,
                'créée',
                "Création d'une nouvelle transaction de type {$transaction->type}",
                null,
                $transaction->toArray()
            );
        });

        static::updated(function ($transaction) {
            $changes = $transaction->getDirty();
            SystemLogger::createLog(
                auth()->id(),
                $transaction,
                'modifiée',
                "Modification de la transaction",
                $transaction->getOriginal(),
                $changes
            );
        });
    }

    /**
     * Le client qui fait la transaction
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Le distributeur qui gère la transaction
     */
    public function distributeur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'distributeur_id');
    }

    /**
     * Créer un dépôt
     */
    public static function creerDepot(
        $clientId,
        $distributeurId,
        $montant,
        $commission = null
    ) {
        return self::create([
            'client_id' => $clientId,
            'distributeur_id' => $distributeurId,
            'type' => 'depot',
            'montant' => $montant,
            'commission' => $commission,
            'etat' => 'en_attente',
            'date' => now()
        ]);
    }

    /**
     * Créer un retrait
     */
    public static function creerRetrait(
        $clientId,
        $distributeurId,
        $montant,
        $commission = null
    ) {
        return self::create([
            'client_id' => $clientId,
            'distributeur_id' => $distributeurId,
            'type' => 'retrait',
            'montant' => $montant,
            'commission' => $commission,
            'etat' => 'en_attente',
            'date' => now()
        ]);
    }

    /**
     * Créer un transfert
     */
    public static function creerTransfert(
        $clientId,
        $montant,
        $frais = null
    ) {
        return self::create([
            'client_id' => $clientId,
            'type' => 'transfert',
            'montant' => $montant,
            'frais' => $frais,
            'etat' => 'en_attente',
            'date' => now()
        ]);
    }

    /**
     * Annuler la transaction
     */
    public function annuler()
    {
        $this->update([
            'etat' => 'annulee',
            'type' => 'annule'
        ]);

        SystemLogger::createLog(
            auth()->id(),
            $this,
            'annulée',
            'Transaction annulée',
            ['etat' => $this->getOriginal('etat')],
            ['etat' => 'annulee']
        );
    }

    /**
     * Terminer la transaction
     */
    public function terminer()
    {
        $this->update(['etat' => 'terminee']);

        SystemLogger::createLog(
            auth()->id(),
            $this,
            'modifiée',
            'Transaction terminée',
            ['etat' => $this->getOriginal('etat')],
            ['etat' => 'terminee']
        );
    }

    /**
     * Transactions en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('etat', 'en_attente');
    }

    /**
     * Transactions terminées
     */
    public function scopeTerminees($query)
    {
        return $query->where('etat', 'terminee');
    }

    /**
     * Transactions annulées
     */
    public function scopeAnnulees($query)
    {
        return $query->where('etat', 'annulee');
    }

    /**
     * Transactions par type
     */
    public function scopeParType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Montant total avec frais
     */
    public function getMontantTotalAttribute()
    {
        return $this->montant + ($this->frais ?? 0);
    }
}