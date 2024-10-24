<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    protected $createNewUser;

    public function __construct(CreateNewUser $createNewUser)
    {
        $this->createNewUser = $createNewUser;
    }

    public function register(Request $request)
    {
        // Validez les données
        $validatedData = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['required', 'string', 'max:15'], // Ajustez selon vos besoins
            'adresse' => ['required', 'string', 'max:255'], // Ajout du champ adresse juste après téléphone
            'date_naissance' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8'], // Suppression de 'confirmed'
            'numero_identite' => ['required', 'string', 'max:255'],
            'photo' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'], // Limite de taille de fichier à 2 Mo
        ]);

        // Ajoutez le rôle par défaut
        $validatedData['role'] = 'client'; // Définir le rôle par défaut

        // Créez l'utilisateur
        $user = $this->createNewUser->create($validatedData);

        // Authentifiez l'utilisateur (facultatif)
        auth()->login($user);

        return redirect()->route('login')->with('success', 'Inscription réussie !');
    }
}
