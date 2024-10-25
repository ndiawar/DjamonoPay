<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Compte;
use App\Enums\UserRole; // Assurez-vous d'importer votre énumération
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    // Affiche le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('auth.register'); // Assurez-vous que cette vue existe
    }

    // Gère l'inscription des utilisateurs
    public function register(Request $request)
    {
        // Vérifiez quel type d'utilisateur s'inscrit
        $typeUser = $request->input('type_user'); // Assurez-vous que ce champ est inclus dans le formulaire

        // Validation des données
        $validatedData = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['required', 'string', 'max:15'],
            'adresse' => ['required', 'string', 'max:255'],
            'date_naissance' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8'],
            'numero_identite' => ['required', 'string', 'max:255'],
            'photo' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'], // Limite à 2 Mo
        ]);

        // Si l'utilisateur est un distributeur ou un agent, vérifier le rôle
        if ($typeUser === 'distributeur' || $typeUser === 'agent') {
            $validatedData['role'] = $request->validate([
                'role' => ['required', 'in:' . implode(',', UserRole::getValues())], // Validation du rôle
            ])['role'];
        } else {
            // Assignation du rôle par défaut pour les clients
            $validatedData['role'] = UserRole::CLIENT;
        }

        // Créer l'utilisateur
        $user = User::create([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'email' => $validatedData['email'],
            'telephone' => $validatedData['telephone'],
            'adresse' => $validatedData['adresse'],
            'date_naissance' => $validatedData['date_naissance'],
            'password' => Hash::make($validatedData['password']),
            'numero_identite' => $validatedData['numero_identite'],
            'photo' => $validatedData['photo']->store('photos', 'public'), // Assurez-vous de gérer le stockage de la photo
            'role' => $validatedData['role'],
        ]);

        // Définir le solde initial en fonction du rôle
        $soldeInitial = ($validatedData['role'] === UserRole::DISTRIBUTEUR) ? 2000000 : 500000;

        // Générer un numéro de compte unique
        $numeroCompte = strtoupper(substr($validatedData['nom'], 0, 1)) . 
                        strtoupper(substr($validatedData['prenom'], 0, 1)) . 
                        str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

        // Créer un compte associé à l'utilisateur
        Compte::create([
            'user_id' => $user->id,
            'numero' => $numeroCompte,
            'solde' => $soldeInitial,
            'qr_code' => Str::random(10),
            'est_bloque' => false,
            'qr_code_creation' => now(),
        ]);

        // Authentifier l'utilisateur
        auth()->login($user);

        // Rediriger vers la page de connexion avec un message de succès
        return redirect()->route('login')->with('success', 'Inscription réussie !');
    }
}
