<?php

namespace App\Http\Requests\Distributeur;

use Illuminate\Foundation\Http\FormRequest;

class StoreDistributeurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Changez cela selon vos besoins d'autorisation
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:distributeur,client,agent',
            'telephone' => 'required|string|unique:users,telephone',
            'adresse' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'numero_identite' => 'required|string|unique:users,numero_identite',
            'photo' => 'nullable|image|max:2048', // 2MB max
        ];
    }
}
