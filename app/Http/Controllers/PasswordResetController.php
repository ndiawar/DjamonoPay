<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordResetController extends Controller
{
    // Affiche le formulaire de réinitialisation de mot de passe
    public function showForm()
    {
        return view('auth.custom-reset');
    }

    // Vérifie l'email saisi par l'utilisateur
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Affiche le formulaire de mot de passe si l'email est correct
        return view('auth.custom-reset', ['email' => $request->email]);
    }

    // Met à jour le mot de passe dans la base de données
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
