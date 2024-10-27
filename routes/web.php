<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DistributeurController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;
use App\Models\Client\ClientController;

/**
 * Route pour la page d'accueil.
 */
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('/');

/**
 * Groupe de routes sous le préfixe 'dashboard'.
 */
// Route::prefix('dashboard')->group(function () {
//     Route::view('index', 'dashboard.index')->name('index');
//     Route::view('dashboard-distributeur', 'dashboard.dashboard-distributeur')->name('dashboard-distributeur');
//     Route::view('dashboard-client', 'dashboard.dashboard-client')->name('dashboard-client');
// });

Route::prefix('dashboard')->group(function () {
    Route::view('index', 'dashboard.index')->name('index');
    Route::view('dashboard-transactions', 'dashboard.dashboard-transactions')->name('dashboard-transactions');
    Route::view('dashboard-distributeur', 'dashboard.dashboard-distributeur')->name('dashboard-distributeur');
    Route::get('dashboard-distributeur', [DistributeurController::class, 'index'])->name('dashboard-distributeur');
    Route::view('dashboard-client', 'dashboard.dashboard-client')->name('dashboard-client');
    Route::view('dashboard-activitées', 'dashboard.dashboard-activitées')->name('dashboard-activitées');
    Route::view('dashboard-utilisateurs', 'dashboard.dashboard-utilisateurs')->name('dashboard-utilisateurs');
    Route::view('dashboard-approvisionner', 'dashboard.dashboard-approvisionner')->name('dashboard-approvisionner');
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
 * Middleware pour les utilisateurs avec le rôle 'DISTRIBUTEUR'.
 */
Route::middleware(['auth', 'role:DISTRIBUTEUR'])->group(function () {
   
});

/**
 * Middleware pour les utilisateurs avec le rôle 'CLIENT'.
 */
Route::middleware(['auth', 'role:CLIENT'])->group(function () {
    
});

/**
 * Middleware pour les utilisateurs avec le rôle 'AGENT'.
 */
Route::middleware(['auth', 'role:AGENT'])->group(function () {
    
});

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

 // Routes pour les transactions
 Route::prefix('transactions')->name('transactions.')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::post('/', [TransactionController::class, 'store'])->name('store');
    Route::get('{transaction}', [TransactionController::class, 'show'])->name('show');
    Route::post('{transaction}/annuler', [TransactionController::class, 'annuler'])->name('annuler');
    Route::get('historique', [TransactionController::class, 'historique'])->name('historique');
    Route::get('statistiques', [TransactionController::class, 'statistiques'])->name('statistiques');
});

// Routes pour les comptes
Route::prefix('comptes')->name('comptes.')->group(function () {
    Route::post('{compte}/crediter', [CompteController::class, 'crediter'])->name('crediter');
    Route::post('{compte}/debiter', [CompteController::class, 'debiter'])->name('debiter');
    Route::post('{compte}/bloquer', [CompteController::class, 'bloquer'])->name('bloquer');
    Route::post('{compte}/debloquer', [CompteController::class, 'debloquer'])->name('debloquer');
    Route::post('{compte}/transfert', [CompteController::class, 'transfert'])->name('transfert');
    Route::post('{compte}/qr-code', [CompteController::class, 'generateQrCode'])->name('qr-code');
    Route::post('{compte}/verifier-qr-code', [CompteController::class, 'verifierQrCode'])->name('verifier-qr-code');
});









Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Routes pour les distributeurs
    Route::resource('distributeur', DistributeurController::class);
    
    // Route supplémentaire pour la mise à jour du solde
    // Route::patch('distributeur/{distributeur}/update-solde', [DistributeurController::class, 'updateSolde'])
    //     ->name('distributeur.update-solde');
    // Route::patch('distributeur/{distributeur}/update-solde', [DistributeurController::class, 'updateSolde'])
    // ->name('distributeur.update-solde');

    // Nouvelles routes pour les fonctionnalités du distributeur
    Route::prefix('distributeur')->name('distributeur.')->group(function () {
        // Opérations sur les clients
        Route::post('/crediter-client', [DistributeurController::class, 'crediterClient'])
            ->name('crediter-client');
        Route::post('/retrait-client', [DistributeurController::class, 'retraitClient'])
            ->name('retrait-client');
        Route::post('/verifier-client-qr', [DistributeurController::class, 'verifierClientQRCode'])
            ->name('verifier-client-qr');
        
        // Gestion des transactions
        Route::post('/annuler-transaction/{transaction}', [DistributeurController::class, 'annulerTransaction'])
            ->name('annuler-transaction');
            
        // Consultation
        Route::get('/consulter-solde', [DistributeurController::class, 'consulterSolde'])
            ->name('consulter-solde');
        Route::get('/historique-transactions', [DistributeurController::class, 'historiqueTrasactions'])
            ->name('historique-transactions');
    });

});