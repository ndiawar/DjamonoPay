<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Distributeur extends User
{
    use HasFactory;

    protected $fillable = [
        // Ajoutez ici les attributs spécifiques au distributeur, si nécessaire
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
