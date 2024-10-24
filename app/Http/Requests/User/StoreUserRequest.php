<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Changé à true pour autoriser la création
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
            'email' => ['required', 'string', 'email', 'unique:users2,email'], // Corrigé users en users2
            'photo' => ['nullable', 'string'],
            'mot_de_passe' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', Rule::enum(UserRole::class)],
            'telephone' => ['required', 'string'],
            'adresse' => ['required', 'string'],
            'date_naissance' => ['required', 'date'],
            'numero_identite' => ['required', 'string', 'unique:users2,numero_identite'], // Corrigé le nom de la table et du champ
            'etat_compte' => ['boolean', 'nullable'], // Ajout de nullable car c'est une valeur par défaut
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
            'nom.required' => 'Le nom est requis',
            'nom.string' => 'Le nom doit être une chaîne de caractères',
            'prenom.required' => 'Le prénom est requis',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères',
            'email.required' => 'L\'email est requis',
            'email.email' => 'L\'email doit être une adresse email valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'mot_de_passe.required' => 'Le mot de passe est requis',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'role.required' => 'Le rôle est requis',
            'role.enum' => 'Le rôle sélectionné n\'est pas valide',
            'telephone.required' => 'Le numéro de téléphone est requis',
            'adresse.required' => 'L\'adresse est requise',
            'date_naissance.required' => 'La date de naissance est requise',
            'date_naissance.date' => 'La date de naissance doit être une date valide',
            'numero_identite.required' => 'Le numéro d\'identité est requis',
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
        if (!$this->has('etat_compte')) {
            $this->merge([
                'etat_compte' => true
            ]);
        }
    }
}
