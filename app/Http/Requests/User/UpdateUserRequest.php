<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Changez cela selon vos besoins d'autorisation
    }

    public function rules(): array
    {
        $userId = $this->route('user'); // Récupérer l'ID de l'utilisateur à partir de la route
        $method = $this->method();

        if ($method === 'PUT') {
            return [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => "required|email|unique:users,email,{$userId}",
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:client,distributeur,agent',
                'telephone' => "required|string|unique:users,telephone,{$userId}",
                'adresse' => 'nullable|string',
                'date_naissance' => 'nullable|date',
                'numero_identite' => "required|string|unique:users,numero_identite,{$userId}",
                'photo' => 'nullable|image|max:2048', // 2MB max
            ];
        } else { // PATCH
            return [
                'nom' => 'sometimes|required|string|max:255',
                'prenom' => 'sometimes|required|string|max:255',
                'email' => "sometimes|required|email|unique:users,email,{$userId}",
                'password' => 'sometimes|nullable|string|min:8|confirmed',
                'role' => 'sometimes|required|in:client,distributeur,agent',
                'telephone' => "sometimes|required|string|unique:users,telephone,{$userId}",
                'adresse' => 'sometimes|nullable|string',
                'date_naissance' => 'sometimes|nullable|date',
                'numero_identite' => "sometimes|required|string|unique:users,numero_identite,{$userId}",
                'photo' => 'sometimes|nullable|image|max:2048', // 2MB max
            ];
        }
    }
}
