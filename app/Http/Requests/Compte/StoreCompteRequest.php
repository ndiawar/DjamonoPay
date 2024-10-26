<?php

namespace App\Http\Requests\Compte;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Changez cela selon vos besoins d'autorisation
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id', // Assurez-vous que l'utilisateur existe
            'numero' => 'required|string|unique:comptes,numero',
            'solde' => 'required|numeric|min:0',
            'qr_code' => 'nullable|string',
            'est_bloque' => 'boolean',
            'qr_code_creation' => 'nullable|date',
        ];
    }
}
