<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSessionIsValid
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Si l'utilisateur n'est pas authentifié, redirection vers la page de login
            return redirect()->route('login')->with('error', 'Veuillez vous reconnecter.');
        }
        return $next($request);
    }
}
