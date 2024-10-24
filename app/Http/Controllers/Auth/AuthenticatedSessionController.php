<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRole;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login'); // Affiche le formulaire de connexion
    }

    public function store(Request $request)
    {
        // Validation des entrées
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Récupération de l'utilisateur par email
        $user = User::where('email', $request->email)->first();

        // Vérification de l'utilisateur et du mot de passe
        if ($user && Hash::check($request->password, $user->password)) {
            // Vérification de l'état du compte
            if ($user->etat_compte) {
                Auth::login($user); // Connexion de l'utilisateur

                // Redirection en fonction du rôle
                if ($user->role === UserRole::AGENT) {
                    return redirect()->route('index'); // Redirige vers le tableau de bord pour les agents
                } elseif ($user->role === UserRole::DISTRIBUTEUR) {
                    return redirect()->route('dashboard-distributeur'); // Redirige vers le tableau de bord distributeur
                } elseif ($user->role === UserRole::CLIENT) {
                    return redirect()->route('dashboard-client'); // Redirige vers le tableau de bord client
                }

                // Gérer d'autres rôles si nécessaire
                return redirect()->route('home'); // Par défaut, redirection vers la page d'accueil
            } else {
                return back()->withErrors(['email' => 'Votre compte est désactivé.']);
            }
        }

        return back()->withErrors(['email' => 'Les informations d\'identification sont incorrectes.']);
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route('login'); // Redirection après déconnexion
    }
}
