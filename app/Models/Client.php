<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'users2_id',
        'solde'
    ];

    protected $casts = [
        'solde' => 'decimal:2'
    ];

    /**
     * Obtenir l'utilisateur associé au client
     */
    public function users2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users2_id');
    }

    /**
     * Créer un nouveau client avec un utilisateur associé
     */
    public static function createWithUser(array $userData): self
    {
        $user = User::create(array_merge(
            $userData,
            ['role' => UserRole::CLIENT]
        ));

        return self::create([
            'users2_id' => $user->id,
            'solde' => 0 // Solde initial à 0
        ]);
    }
}