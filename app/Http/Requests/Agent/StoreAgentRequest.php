<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgentRequest extends FormRequest
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
            'role' => 'required|in:agent,client,distributeur',
            'telephone' => 'required|string|unique:users,telephone',
            'adresse' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'numero_identite' => 'required|string|unique:users,numero_identite',
            'photo' => 'nullable|image|max:2048', // 2MB max
        ];
    }
}
