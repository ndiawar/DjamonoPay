<?php

namespace App\Http\Requests\Distributeur;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDistributeurRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // À adapter selon votre logique d'authentification
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
            'email' => ['sometimes', 'string', 'email', Rule::unique('users2', 'email')->ignore($this->distributeur->users2->id)],
            'photo' => ['nullable', 'string'],
            'mot_de_passe' => ['sometimes', 'string', 'min:8'],
            'telephone' => ['sometimes', 'string'],
            'adresse' => ['sometimes', 'string'],
            'date_naissance' => ['sometimes', 'date'],
            'numero_identite' => ['sometimes', 'string', Rule::unique('users2', 'numero_identite')->ignore($this->distributeur->users2->id)],
            'solde' => ['sometimes', 'numeric', 'min:0'],
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
            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères',
            'date_naissance.date' => 'La date de naissance doit être une date valide',
            'numero_identite.unique' => 'Ce numéro d\'identité est déjà utilisé',
            'solde.numeric' => 'Le solde doit être un nombre',
            'solde.min' => 'Le solde ne peut pas être négatif'
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