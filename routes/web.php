<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;

/**
 * Route pour la page d'accueil.
 */
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('/');

/**
 * Groupe de routes sous le préfixe 'dashboard'.
 */
Route::prefix('dashboard')->group(function () {
    Route::view('index', 'dashboard.index')->name('index'); // Dashboard Agent
    Route::view('dashboard-distributeur', 'dashboard.dashboard-distributeur')->name('dashboard-distributeur'); // Dashboard Distributeur
    Route::view('dashboard-client', 'dashboard.dashboard-client')->name('dashboard-client'); // Dashboard Client
});

/**
 * Routes pour l'authentification.
 */
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/**
 * Routes pour l'inscription.
 */
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [RegisterController::class, 'register']);

/**
 * Route pour afficher le formulaire d'inscription d'un distributeur/agent
 */
Route::get('/distributeur-agent', function () {
    return view('auth.distributeur_agent'); // Assurez-vous que le chemin vers la vue est correct
})->name('distributeur-agent');

/**
 * Routes pour gérer les erreurs spécifiques.
 */
Route::prefix('others')->group(function () {
    Route::view('400', 'errors.400')->name('error-400');
    Route::view('401', 'errors.401')->name('error-401');
    Route::view('403', 'errors.403')->name('error-403');
    Route::view('404', 'errors.404')->name('error-404');
    Route::view('500', 'errors.500')->name('error-500');
    Route::view('503', 'errors.503')->name('error-503');
});

/**
 * Route pour effacer le cache.
 */
Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');

/**
 * Groupe de routes protégées par le middleware 'auth'.
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // Vérification de l'authentification de l'utilisateur
        if ($user = Auth::user()) {
            $role = $user->role;

            // Redirection en fonction du rôle
            return match ($role) {
                UserRole::AGENT => redirect()->route('index'),
                UserRole::DISTRIBUTEUR => redirect()->route('dashboard-distributeur'),
                UserRole::CLIENT => redirect()->route('dashboard-client'),
                default => redirect()->route('login'),
            };
        }

        // Redirection vers la page de connexion si l'utilisateur n'est pas authentifié
        return redirect()->route('login')->with('error', 'Vous devez vous connecter pour accéder à cette page.');
    })->name('dashboard');
});
