<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'users2_id',
    ];

    /**
     * Obtenir l'utilisateur associé à l'agent.
     */
    public function users2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users2_id');
    }

    /**
     * Créer un nouvel agent avec un utilisateur associé
     */
    public static function createWithUser(array $userData): self
    {
        // Créer l'utilisateur avec toutes les données, y compris le numero_identite
        $user = User::create(array_merge(
            $userData,
            ['role' => UserRole::AGENT]
        ));

        // Créer l'agent lié à l'utilisateur
        return self::create([
            'users2_id' => $user->id,
        ]);
    }
}