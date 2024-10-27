<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifie si l'utilisateur est authentifié et a le bon rôle
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request); // Continue la requête
        }

        // Redirige vers la route appropriée ou vers une erreur 403
        return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
    }
}
