<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Vérifier si l'utilisateur est autorisé à faire cette requête
     * À personnaliser selon vos besoins de sécurité
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Définir les règles de validation pour la mise à jour d'un utilisateur
     * 'sometimes' signifie que le champ est optionnel mais sera validé s'il est présent
     */
    public function rules(): array
    {
        return [
            // Règles pour les informations de base
            'nom' => ['sometimes', 'string', 'max:255'],
            'prenom' => ['sometimes', 'string', 'max:255'],
            
            // Validation de l'email avec vérification d'unicité
            'email' => [
                'sometimes', 
                'string', 
                'email', 
                Rule::unique('users', 'email')->ignore($this->user)
            ],
            
            // Gestion de la photo de profil
            'photo' => ['nullable', 'string'],
            
            // Validation du mot de passe
            'password' => ['sometimes', 'string', 'min:8'],
            
            // Validation du rôle avec restriction de modification
            'role' => [
                'sometimes', 
                'string', 
                Rule::enum(UserRole::class),
                // Fonction personnalisée pour empêcher le changement de rôle
                function($attribute, $value, $fail) {
                    if ($this->user->role !== $value) {
                        $fail("Le rôle de l'utilisateur ne peut pas être modifié.");
                    }
                }
            ],
            
            // Validation des informations complémentaires
            'telephone' => ['sometimes', 'string', 'max:20'],
            'adresse' => ['sometimes', 'string', 'max:255'],
            'date_naissance' => ['sometimes', 'date', 'before:today'],
            
            // Validation du numéro d'identité
            'numero_identite' => [
                'sometimes', 
                'string', 
                'max:50',
                Rule::unique('users', 'numero_identite')->ignore($this->user)
            ],
            
            // Validation de l'état du compte
            'etat_compte' => ['sometimes', 'string', Rule::in([User::ETAT_ACTIF, User::ETAT_BLOQUE])],
        ];
    }

    /**
     * Messages d'erreur personnalisés pour chaque règle de validation
     */
    public function messages(): array
    {
        return [
            // Messages pour les informations de base
            'nom.string' => 'Le nom doit être une chaîne de caractères',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères',
            
            // Messages pour l'email
            'email.email' => 'L\'email doit être une adresse email valide',
            'email.unique' => 'Cet email est déjà utilisé',
            
            // Messages pour le mot de passe
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            
            // Messages pour le rôle
            'role.enum' => 'Le rôle sélectionné n\'est pas valide',
            'role.in' => 'Le rôle fourni n\'est pas valide',
            
            // Messages pour les informations complémentaires
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères',
            'adresse.max' => 'L\'adresse ne peut pas dépasser 255 caractères',
            'date_naissance.date' => 'La date de naissance doit être une date valide',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui',
            
            // Messages pour le numéro d'identité
            'numero_identite.unique' => 'Ce numéro d\'identité est déjà utilisé',
            'numero_identite.max' => 'Le numéro d\'identité ne peut pas dépasser 50 caractères',
            
            // Message pour l'état du compte
            'etat_compte.in' => 'L\'état du compte doit être soit actif soit bloqué'
        ];
    }

    /**
     * Préparer les données avant la validation
     * Cette méthode nettoie et formate les données reçues
     */
    protected function prepareForValidation(): void
    {
        $input = $this->all();

        // Convertir les chaînes vides en null
        foreach ($input as $key => $value) {
            if ($value === '') {
                $input[$key] = null;
            }
        }

        // Supprimer le mot de passe s'il est null
        if (isset($input['password']) && is_null($input['password'])) {
            unset($input['password']);
        }

        $this->replace($input);
    }
}

