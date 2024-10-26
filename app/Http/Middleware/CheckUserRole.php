<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Vérifier si l'utilisateur est authentifié
        if (Auth::check()) {
            $userRole = Auth::user()->role;

            // Si le rôle de l'utilisateur est dans la liste autorisée, on continue
            if (in_array($userRole, $roles)) {
                return $next($request);
            }
        }

        // Si non autorisé, on redirige vers une page 403 ou autre
        return redirect()->route('error-403');
    }
}
