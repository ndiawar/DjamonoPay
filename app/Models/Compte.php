<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compte extends Model
{
    use HasFactory;

    protected $fillable = [
        'users2_id',
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
    public function users2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users2_id');
    }

    /**
     * Générer un numéro de compte unique basé sur le nom et prénom
     */
    public static function generateAccountNumber(string $nom, string $prenom): string
    {
        // Prendre la première lettre du nom et du prénom en majuscules
        $initiales = strtoupper(substr($nom, 0, 1) . substr($prenom, 0, 1));
        
        do {
            // Générer un nombre aléatoire entre 0 et 999
            $number = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
            
            // Combiner les initiales et le nombre
            $numeroCompte = $initiales . $number;
            
        } while (self::where('numero', $numeroCompte)->exists());

        return $numeroCompte;
    }

    /**
     * Créer un nouveau compte avec un numéro unique
     */
    public static function createWithNumber(array $data, User $user): self
    {
        return self::create([
            'users2_id' => $user->id,
            'numero' => self::generateAccountNumber($user->nom, $user->prenom),
            'est_bloque' => false,
            'solde' => 0,
            'qr_code' => null,
            'qr_code_creation' => null
        ]);
    }
}