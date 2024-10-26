<?php

namespace App\Http\Requests\Distributeur;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDistributeurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Changez cela selon vos besoins d'autorisation
    }

    public function rules(): array
    {
        $distributeurId = $this->route('distributeur'); // Récupérer l'ID du distributeur à partir de la route
        $method = $this->method();

        if ($method === 'PUT') {
            return [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => "required|email|unique:users,email,{$distributeurId}",
                'password' => 'nullable|string|min:8|confirmed',
                'role' => 'required|in:distributeur,client,agent',
                'telephone' => "required|string|unique:users,telephone,{$distributeurId}",
                'adresse' => 'nullable|string',
                'date_naissance' => 'nullable|date',
                'numero_identite' => "required|string|unique:users,numero_identite,{$distributeurId}",
                'photo' => 'nullable|image|max:2048', // 2MB max
            ];
        } else { // PATCH
            return [
                'nom' => 'sometimes|required|string|max:255',
                'prenom' => 'sometimes|required|string|max:255',
                'email' => "sometimes|required|email|unique:users,email,{$distributeurId}",
                'password' => 'sometimes|nullable|string|min:8|confirmed',
                'role' => 'sometimes|required|in:distributeur,client,agent',
                'telephone' => "sometimes|required|string|unique:users,telephone,{$distributeurId}",
                'adresse' => 'sometimes|nullable|string',
                'date_naissance' => 'sometimes|nullable|date',
                'numero_identite' => "sometimes|required|string|unique:users,numero_identite,{$distributeurId}",
                'photo' => 'sometimes|nullable|image|max:2048', // 2MB max
            ];
        }
    }
}
