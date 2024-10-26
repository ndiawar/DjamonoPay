<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Changez cela selon vos besoins d'autorisation
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id', // Assurez-vous que l'utilisateur existe
            'distributeur_id' => 'nullable|exists:users,id',
            'type' => 'required|in:depot,retrait,transfert,annulé',
            'montant' => 'required|numeric|min:0',
            'frais' => 'nullable|numeric|min:0',
            'commission' => 'nullable|numeric|min:0',
            'etat' => 'required|string',
            'motif' => 'nullable|string|max:255',
        ];
    }
}
