<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemLogger extends Model
{
    use HasFactory;

    /**
     * Désactive la gestion automatique des timestamps
     */
    public $timestamps = false;

    /**
     * Les attributs assignables en masse
     */
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ancien_etat',
        'nouvel_etat',
        'created_at'
    ];

    /**
     * Les attributs à convertir
     */
    protected $casts = [
        'created_at' => 'datetime',
        'ancien_etat' => 'array',
        'nouvel_etat' => 'array'
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Enregistrer un log
     */
    public static function enregistrer(
        $userId,
        $action,
        $description,
        $ancienEtat = null,
        $nouvelEtat = null
    ): self {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ancien_etat' => $ancienEtat,
            'nouvel_etat' => $nouvelEtat,
            'created_at' => now()
        ]);
    }

    /**
     * Obtenir les logs par utilisateur
     */
    public static function parUtilisateur($userId)
    {
        return self::where('user_id', $userId)
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    /**
     * Obtenir les logs par action
     */
    public static function parAction($action)
    {
        return self::where('action', $action)
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    /**
     * Obtenir les logs par date
     */
    public static function parDate($date)
    {
        return self::whereDate('created_at', $date)
                   ->orderBy('created_at', 'desc')
                   ->get();
    }
}