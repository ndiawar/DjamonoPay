<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Valider et créer un nouvel utilisateur enregistré.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Validation des données
        Validator::make($input, [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['required', 'string', 'max:15'],
            'adresse' => ['required', 'string', 'max:255'], // Validation pour l'adresse
            'date_naissance' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8'], // Validation pour le mot de passe
            'numero_identite' => ['required', 'string', 'max:50'],
            'photo' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
        ])->validate();

        // Création de l'utilisateur avec le rôle par défaut 'client'
        $user = User::create([
            'nom' => $input['nom'],
            'prenom' => $input['prenom'],
            'email' => $input['email'],
            'telephone' => $input['telephone'],
            'adresse' => $input['adresse'], // Ajout de l'adresse lors de la création de l'utilisateur
            'date_naissance' => $input['date_naissance'],
            'password' => Hash::make($input['password']),
            'numero_identite' => $input['numero_identite'],
            'role' => 'client', // Définition du rôle par défaut
            'photo' => $this->storePhoto($input['photo']), // Stockage de la photo
        ]);

        return $user;
    }

    /**
     * Stocker la photo de l'utilisateur et retourner le chemin.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return string
     */
    protected function storePhoto($photo)
    {
        return $photo->store('photos', 'public');
    }
}