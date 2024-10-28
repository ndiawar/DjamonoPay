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
    /**
     * Affiche le formulaire de connexion.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login'); // Affiche le formulaire de connexion
    }

    /**
     * Authentifie l'utilisateur et gère la redirection en fonction du rôle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function store(Request $request)
    // {
    //     // Validation des entrées
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|min:6',
    //     ]);

    //     // Récupération de l'utilisateur par email
    //     $user = User::where('email', $request->email)->first();

    //     // Vérification de l'utilisateur et du mot de passe
    //     if ($user && Hash::check($request->password, $user->password)) {
    //         // Vérification de l'état du compte
    //         if ($user->etat_compte) {
    //             Auth::login($user); // Connexion de l'utilisateur

    //             // Régénération du token CSRF pour sécuriser la session
    //             $request->session()->regenerate();

    //             // Redirection en fonction du rôle avec l'enum UserRole
    //             return match ($user->role) {
    //                 UserRole::AGENT => redirect()->route('index'),
    //                 UserRole::DISTRIBUTEUR => redirect()->route('dashboard-distributeur'),
    //                 UserRole::CLIENT => redirect()->route('dashboard-client'),
    //                 default => redirect()->route('home'),
    //             };
    //         } else {
    //             return back()->withErrors(['email' => 'Votre compte est désactivé.']);
    //         }
    //     }

    //     return back()->withErrors(['email' => 'Les informations d\'identification sont incorrectes.']);
    // }
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
                // Authentification
                Auth::login($user);
                
                // Régénération du token CSRF pour sécuriser la session
                $request->session()->regenerate();
    
                // Stockage des informations de l'utilisateur dans la session
                session([
                    'user_name' => $user->nom,
                    'user_prenom' => $user->prenom,
                    'user_role' => $user->role,
                    'user_photo' => $user->photo,
                ]);
    
                // Redirection en fonction du rôle avec l'enum UserRole
                return match ($user->role) {
                    UserRole::AGENT => redirect()->route('index'),
                    UserRole::DISTRIBUTEUR => redirect()->route('dashboard-distributeur'),
                    UserRole::CLIENT => redirect()->route('dashboard-client'),
                    default => redirect()->route('home'),
                };
            } else {
                return back()->withErrors(['email' => 'Votre compte est désactivé.']);
            }
        }
    
        // Authentification échouée
        return back()->withErrors(['email' => 'Les informations d\'identification sont incorrectes.']);
    }
    
// Déconnexion


    /**
     * Déconnecte l'utilisateur et redirige vers la page de connexion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout(); // Déconnexion de l'utilisateur
        $request->session()->invalidate(); // Invalidation de la session
        $request->session()->regenerateToken(); // Régénération du token CSRF

        return redirect()->route('login')->with('status', 'Vous êtes déconnecté.'); // Redirection après déconnexion
    }
}