<?php

namespace App\Http\Requests\SystemLogger;

use Illuminate\Foundation\Http\FormRequest;

class StoreSystemLoggerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Changez cela selon vos besoins d'autorisation
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id', // ID de l'utilisateur
            'action' => 'required|string|max:255', // Action effectuée
            'description' => 'required|string|max:255', // Description de l'action
        ];
    }
}
