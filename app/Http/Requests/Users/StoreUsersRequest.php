<?php

namespace App\Http\Requests\Users;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {   
        return [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'photo' => ['nullable', 'string'],
            'mot_de_passe' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', Rule::enum(UserRole::class)],
            'telephone' => ['required', 'string'],
            'adresse' => ['required', 'string'],
            'date_naissance' => ['required', 'date'],
            'numero_identite' => ['required', 'string', 'unique:users,numero_carte_identite'],
            'etat_compte' => ['boolean'],
        ];
    }
}
