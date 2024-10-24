<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => ['sometimes', 'string', 'email', Rule::unique('users2', 'email')->ignore($this->users->id)],
            'photo' => ['nullable', 'string'],
            'mot_de_passe' => ['sometimes', 'string', 'min:8'],
            'role' => ['sometimes', 'string', Rule::enum(UserRole::class)],
            'telephone' => ['sometimes', 'string'], // Corrigé numero_telephone en telephone
            'adresse' => ['sometimes', 'string'],
            'date_naissance' => ['sometimes', 'date'],
            'numero_identite' => ['sometimes', 'string', Rule::unique('users2', 'numero_identite')->ignore($this->users->id)], // Corrigé le nom du champ
            'etat_compte' => ['sometimes', 'boolean'],
        ];

    }
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nom.string' => 'Le nom doit être une chaîne de caractères',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères',
            'email.email' => 'L\'email doit être une adresse email valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'role.enum' => 'Le rôle sélectionné n\'est pas valide',
            'date_naissance.date' => 'La date de naissance doit être une date valide',
            'numero_identite.unique' => 'Ce numéro d\'identité est déjà utilisé'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Retirer le mot de passe s'il est vide
        if ($this->has('mot_de_passe') && empty($this->mot_de_passe)) {
            $this->request->remove('mot_de_passe');
        }
    }
}
