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
    
        // Vérifiez si la session 'status' existe
        if ($request->session()->has('status')) {
            // Vous pouvez effectuer une action ici si la session existe
            // Par exemple, rediriger vers une page différente ou afficher un message
            return redirect()->route('index')->with('info', 'Votre session est active.');
        }
    
        // Redirection en fonction du rôle
        if ($role === UserRole::CLIENT) {
            return redirect()->route('register')->with('success', 'Inscription réussie !');
        } else {
            return redirect()->route('index')->with('success', 'Inscription réussie !');
        }
    }
    

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Validation conditionnelle des données
        $validatedData = $request->validate([
            'nom' => ['sometimes', 'required', 'string', 'max:255'],
            'prenom' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'telephone' => ['sometimes', 'nullable', 'string', 'max:15'],
            'adresse' => ['sometimes', 'nullable', 'string', 'max:255'],
            'date_naissance' => ['sometimes', 'nullable', 'date'],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
            'old_password' => ['sometimes', 'nullable', 'string'],
            'photo' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg|max:2048'],
        ]);
    
        ($validatedData); // Voir les données validées
    
        // Gestion de l'upload de la photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $validatedData['photo'] = $photoPath;
        }
    
        // Vérification et mise à jour du mot de passe si nécessaire
        if ($request->filled('password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'L\'ancien mot de passe est incorrect.']);
            }
            $validatedData['password'] = Hash::make($request->password);
        }
    
        try {
            // Mise à jour des données de l'utilisateur seulement pour les champs valides
            $user->update(array_filter($validatedData)); // Utilise array_filter pour ignorer les valeurs nulles
            $user->refresh(); // Recharge les données
            ($user); // Affiche les données après mise à jour
        } catch (\Exception $e) {
            ($e->getMessage()); // Affiche le message d'erreur en cas d'exception
        }
    
        // Redirection en fonction du rôle de l'utilisateur
        if ($user->role === 'distributeur') {
            return redirect()->route('distributeurs.afficher_Historique')->with('success', 'Profil mis à jour avec succès.');
        } elseif ($user->role === 'client') {
            return redirect()->route('clients.afficher_Historiques_clients')->with('success', 'Profil mis à jour avec succès.');
        } elseif ($user->role === 'agent') {
            return redirect()->route('index')->with('success', 'Profil mis à jour avec succès.');
        }
    
        // Si le rôle n'est pas reconnu, rediriger vers une page par défaut
        return redirect()->route('profile')->with('success', 'Profil mis à jour avec succès.');
    }
    
}