<?php

namespace App\Http\Requests\Users;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsersRequest extends FormRequest
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
            'nom' => ['sometimes', 'string', 'max:255'],
            'prenom' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'unique:users,email,'.$this->user->id],
            'photo' => ['nullable', 'string'],
            'mot_de_passe' => ['sometimes', 'string', 'min:8'],
            'role' => ['sometimes', 'string', Rule::enum(UserRole::class)],
            'numero_telephone' => ['sometimes', 'string'],
            'adresse' => ['sometimes', 'string'],
            'date_naissance' => ['sometimes', 'date'],
            'numero_carte_identite' => ['sometimes', 'string', 'unique:users,numero_carte_identite,'.$this->user->id],
            'etat_compte' => ['sometimes', 'boolean'],
        ];
    }
}
