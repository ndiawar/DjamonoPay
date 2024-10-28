<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Compte;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    // Affiche le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('auth.register'); // Assurez-vous que cette vue existe
    }

    // Gestion de l'inscription
    public function register(Request $request)
    {
        // Validation des données d'inscription
        $validatedData = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'telephone' => ['required', 'string', 'max:15'],
            'adresse' => ['required', 'string', 'max:255'],
            'date_naissance' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8'],
            'numero_identite' => ['required', 'string', 'max:255'],
            'photo' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
            'role' => ['nullable', Rule::in(UserRole::getValues())],
        ]);

        // Définir une valeur par défaut pour le rôle
        $role = $validatedData['role'] ?? UserRole::CLIENT;

        // Gestion de l'upload de la photo
        try {
            $photoPath = $validatedData['photo']->store('photos', 'public');
        } catch (\Exception $e) {
            return back()->withErrors(['photo' => 'Erreur de téléchargement de la photo.'])->withInput();
        }

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'email' => $validatedData['email'],
            'telephone' => $validatedData['telephone'],
            'adresse' => $validatedData['adresse'],
            'date_naissance' => $validatedData['date_naissance'],
            'password' => Hash::make($validatedData['password']),
            'numero_identite' => $validatedData['numero_identite'],
            'photo' => $photoPath,
            'role' => $role,
        ]);

        // Initialisation du solde en fonction du rôle
        $soldeInitial = ($role === UserRole::DISTRIBUTEUR) ? 2000000 : 0;

        // Génération du numéro de compte unique
        $numeroCompte = strtoupper(substr($validatedData['nom'], 0, 1)) .
                        strtoupper(substr($validatedData['prenom'], 0, 1)) .
                        str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

        // Création du compte bancaire
        Compte::create([
            'user_id' => $user->id,
            'numero_compte' => $numeroCompte,
            'solde' => $soldeInitial,
            'qr_code' => Str::random(10),
            'est_bloque' => false,
            'qr_code_creation' => now(),
        ]);

       
        // Connexion automatique de l'utilisateur après inscription
        auth()->login($user);

        // Redirection en fonction du rôle
        if ($role === UserRole::CLIENT) {
            return redirect()->route('register')->with('success', 'Inscription réussie !');
        } else {
            return redirect()->route('index')->with('success', 'Inscription réussie !');
        }
    }
}