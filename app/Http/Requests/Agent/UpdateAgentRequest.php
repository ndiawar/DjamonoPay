<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Changez cela selon vos besoins d'autorisation
    }

    public function rules(): array
    {
        $agentId = $this->route('agent'); // Récupérer l'ID de l'agent à partir de la route
        $method = $this->method();

        if ($method === 'PUT') {
            return [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => "required|email|unique:users,email,{$agentId}",
                'password' => 'nullable|string|min:8|confirmed',
                'role' => 'required|in:agent,client,distributeur',
                'telephone' => "required|string|unique:users,telephone,{$agentId}",
                'adresse' => 'nullable|string',
                'date_naissance' => 'nullable|date',
                'numero_identite' => "required|string|unique:users,numero_identite,{$agentId}",
                'photo' => 'nullable|image|max:2048', // 2MB max
            ];
        } else { // PATCH
            return [
                'nom' => 'sometimes|required|string|max:255',
                'prenom' => 'sometimes|required|string|max:255',
                'email' => "sometimes|required|email|unique:users,email,{$agentId}",
                'password' => 'sometimes|nullable|string|min:8|confirmed',
                'role' => 'sometimes|required|in:agent,client,distributeur',
                'telephone' => "sometimes|required|string|unique:users,telephone,{$agentId}",
                'adresse' => 'sometimes|nullable|string',
                'date_naissance' => 'sometimes|nullable|date',
                'numero_identite' => "sometimes|required|string|unique:users,numero_identite,{$agentId}",
                'photo' => 'sometimes|nullable|image|max:2048', // 2MB max
            ];
        }
    }
}
