<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Autoriser la création
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:client,distributeur,agent',
            'telephone' => 'required|string|unique:users,telephone',
            'adresse' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'numero_identite' => 'required|string|unique:users,numero_identite',
            'photo' => 'nullable|image|max:2048', // 2MB max
        ];
    }
}
