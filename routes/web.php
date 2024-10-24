<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Enums\UserRole;

/**
 * Route pour la page d'accueil.
 * Cette route redirige automatiquement toute requête à la racine du site ('/') 
 * vers la route nommée 'index', qui est définie plus bas dans le groupe de routes 'dashboard'.
 */
Route::get('/', function () {
    return redirect()->route('index');
})->name('/');

/**
 * Groupe de routes sous le préfixe 'dashboard'.
 * Toutes les routes dans ce groupe auront le préfixe 'dashboard' dans leur URL.
 * Ici, une vue 'dashboard.index' est retournée lorsque l'utilisateur accède à '/dashboard/index'.
 * La route est nommée 'index', ce qui permet d'y accéder facilement via 'route('index')'.
 */
Route::prefix('dashboard')->group(function () {
    Route::view('index', 'dashboard.index')->name('index');
    Route::view('dashboard-distributeur', 'dashboard.dashboard-distributeur')->name('dashboard-distributeur');
    Route::view('dashboard-client', 'dashboard.dashboard-client')->name('dashboard-client');
});

/**
 * Routes pour l'authentification.
 */
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/**
 * Groupe de routes sous le préfixe 'others'.
 * Ces routes gèrent les erreurs spécifiques comme 400, 401, 403, 404, 500, et 503.
 * Chaque route renvoie une vue spécifique pour une erreur donnée.
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
 * Cette route exécute plusieurs commandes Artisan pour effacer différents types de caches.
 * La route est nommée 'clear.cache' et renvoie un message "Cache is cleared" lorsque ces actions sont complétées.
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
 * Route pour le tableau de bord, protégé par des middleware.
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Ajoutez d'autres routes protégées par l'authentification ici
});
