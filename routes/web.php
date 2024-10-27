<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DistributeurController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemLoggerController;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;

/**
 * Route pour la page d'accueil, redirige vers le tableau de bord.
 */
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('/');

/**
 * Groupe de routes pour le tableau de bord.
 */
Route::prefix('dashboard')->group(function () {
    Route::view('index', 'dashboard.index')->name('index');
    Route::view('dashboard-transactions', 'dashboard.dashboard-transactions')->name('dashboard-transactions');
    Route::view('dashboard-distributeur', 'dashboard.dashboard-distributeur')->name('dashboard-distributeur');
    Route::get('dashboard-distributeur', [DistributeurController::class, 'index'])->name('dashboard-distributeur');
    Route::view('dashboard-client', 'dashboard.dashboard-client')->name('dashboard-client');
    Route::view('dashboard-activites', 'dashboard.dashboard-activites')->name('dashboard-activites');
    Route::view('dashboard-utilisateurs', 'dashboard.dashboard-utilisateurs')->name('dashboard-utilisateurs');
    Route::view('dashboard-approvisionner', 'dashboard.dashboard-approvisionner')->name('dashboard-approvisionner');
    route::get('dashboard-approvisionner', [DistributeurController::class, 'afficherDistributeurs'])->name('dashboard-approvisionner');
    route::get('dashboard-utilisateurs', [UserController::class, 'afficherUsers'])->name('dashboard-utilisateurs');
   
});

/**
 * Routes pour les comptes, incluant les opérations CRUD.
 */
Route::resource('comptes', CompteController::class); // Index, create, store, show, edit, update, destroy

// Routes spécifiques pour les opérations sur les comptes
Route::post('comptes/{compte}/debiter', [CompteController::class, 'debiter'])->name('comptes.debiter');
Route::post('comptes/{compte}/crediter', [CompteController::class, 'crediter'])->name('comptes.crediter');
Route::post('comptes/{compte}/bloquer', [CompteController::class, 'bloquer'])->name('comptes.bloquer');
Route::post('comptes/{compte}/debloquer', [CompteController::class, 'debloquer'])->name('comptes.debloquer');
Route::post('comptes/{compte}/generate-qr-code', [CompteController::class, 'generateQrCode'])->name('comptes.generateQrCode');
Route::post('comptes/verifier-qr-code', [CompteController::class, 'verifierQrCode'])->name('comptes.verifierQrCode');

/**
 * Routes pour la gestion des utilisateurs.
 */
Route::prefix('utilisateurs')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('utilisateurs.index'); // Affiche tous les utilisateurs
    Route::get('/{user}', [UserController::class, 'show'])->name('utilisateurs.show'); // Affiche un utilisateur
    Route::post('/', [UserController::class, 'creerUtilisateur'])->name('utilisateurs.creer'); // Crée un nouvel utilisateur
    Route::put('/{user}', [UserController::class, 'modifierUtilisateur'])->name('utilisateurs.modifier'); // Modifie un utilisateur
    Route::post('/{user}/bloquer', [UserController::class, 'bloquerCompte'])->name('utilisateurs.bloquer'); // Bloque un compte
    Route::delete('/{user}', [UserController::class, 'supprimerUtilisateur'])->name('utilisateurs.supprimer'); // Supprime un utilisateur
});

/**
 * Routes pour la gestion des distributeurs.
 */
Route::prefix('distributeurs')->group(function () {
    Route::get('/', [DistributeurController::class, 'index'])->name('distributeurs.index');
    Route::get('/{distributeur}', [DistributeurController::class, 'show'])->name('distributeurs.show');
    Route::post('/', [DistributeurController::class, 'store'])->name('distributeurs.store');
    Route::put('/{distributeur}', [DistributeurController::class, 'update'])->name('distributeurs.update');
    Route::delete('/{distributeur}', [DistributeurController::class, 'destroy'])->name('distributeurs.destroy');

    // Actions spécifiques pour les distributeurs
    Route::post('/{distributeur}/consulter-solde', [DistributeurController::class, 'consulterSolde'])->name('distributeurs.consulter_solde');
    Route::post('/{distributeur}/crediter-compte-client', [DistributeurController::class, 'crediterCompteClient'])->name('distributeurs.crediter_compte_client');
    Route::post('/{distributeur}/effectuer-retrait', [DistributeurController::class, 'effectuerRetrait'])->name('distributeurs.effectuer_retrait');
    Route::post('/{distributeur}/voir-solde', [DistributeurController::class, 'voirSolde'])->name('distributeurs.voir_solde');
    Route::get('/{distributeur}/transactions', [DistributeurController::class, 'voirTransactions'])->name('distributeurs.voir_transactions');
    Route::post('/{distributeur}/annuler-transaction/{transaction}', [DistributeurController::class, 'annulerTransaction'])->name('distributeurs.annuler_transaction');
    Route::post('/{distributeur}/scanner-qrcode', [DistributeurController::class, 'scannerQRCode'])->name('distributeurs.scanner_qrcode');
});

/**
 * Routes pour la gestion des agents.
 */
Route::prefix('agents')->group(function () {
    Route::get('/', [AgentController::class, 'index'])->name('agents.index');
    Route::get('/{agent}', [AgentController::class, 'show'])->name('agents.show');
    Route::post('/', [AgentController::class, 'store'])->name('agents.store');
    Route::put('/{agent}', [AgentController::class, 'update'])->name('agents.update');
    Route::delete('/{agent}', [AgentController::class, 'destroy'])->name('agents.destroy');
    // Route avec contrôleur pour passer les variables dynamiques
    Route::get('/{agent}/form/{distributeurId}', [AgentController::class, 'showForm'])->name('form.show');

});
    // Actions spécifiques pour les agents
    Route::post('/{agent}/creer-compte-client', [AgentController::class, 'creerCompteClient'])->name('agents.creer_compte_client');
    Route::put('/{agent}/modifier-compte/{clientId}', [AgentController::class, 'modifierCompte'])->name('agents.modifier_compte');
    // Route::post('/{agent}/crediter-compte-distributeur/{distributeurId}', [AgentController::class, 'crediterCompteDistributeur'])->name('agents.crediter_compte_distributeur');
    // Route::post('/{agent}/bloquer-compte/{clientId}', [AgentController::class, 'bloquerCompte'])->name('agents.bloquer_compte');
    Route::post('/{agent}/annuler-transaction/{transaction}', [AgentController::class, 'annulerTransaction'])->name('agents.annuler_transaction');
    Route::post('/crediter-compte-distributeur/', [AgentController::class, 'crediterCompteDistributeur'])->name('agents.crediter_compte_distributeur');
    Route::post('/crediter-rapide-distributeur/', [AgentController::class, 'crediterRapideDistributeur'])->name('agents.crediter_rapide_distributeur');
    Route::post('/bloquer-utilisateur/{userId}', [AgentController::class, 'bloquerOuDebloquerCompte'])->name('agents.bloquer_utilisateur');
/**
 * Routes pour la gestion des transactions.
 */
Route::prefix('transactions')->name('transactions.')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::post('/', [TransactionController::class, 'store'])->name('store');
    Route::get('{transaction}', [TransactionController::class, 'show'])->name('show');
    Route::post('{transaction}/annuler', [TransactionController::class, 'annuler'])->name('annuler');
    Route::get('historique', [TransactionController::class, 'historique'])->name('historique');
    Route::get('statistiques', [TransactionController::class, 'statistiques'])->name('statistiques');
});
/**
 * Routes pour le système de log.
 */
Route::prefix('logs')->group(function () {
    Route::post('/', [SystemLoggerController::class, 'enregistrerLog'])->name('logs.enregistrer'); // Enregistrer un log
    Route::get('/', [SystemLoggerController::class, 'recupererLogs'])->name('logs.recuperer'); // Récupérer des logs
    Route::post('/rapport', [SystemLoggerController::class, 'genererRapport'])->name('logs.rapport'); // Générer un rapport
});
/**
 * Routes pour l'authentification.
 */
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/**
 * Routes pour l'inscription des utilisateurs.
 */
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'register']);

/**
 * Route pour afficher le formulaire d'inscription d'un distributeur/agent.
 */
Route::get('/distributeur-agent', function () {
    return view('auth.distributeur_agent'); // Assurez-vous que le chemin vers la vue est correct
})->name('distributeur-agent');

/**
 * Routes pour gérer les erreurs spécifiques.
 */
Route::prefix('errors')->group(function () {
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
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
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

