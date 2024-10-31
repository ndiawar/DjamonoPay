<?php

use App\Http\Controllers\SystemLoggerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DistributeurController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Resources\ClientCollection;
use Illuminate\Support\Facades\Auth;

/**
 * Route pour la page d'accueil, redirige vers le tableau de bord.
 */
Route::get('/', function () {
    return redirect()->route('login');
})->name('/');


/**
 * Route pour afficher le formulaire d'inscription d'un distributeur/agent.
 */
Route::get('/distributeur-agent', function () {
    return view('auth.distributeur_agent'); // Assurez-vous que le chemin vers la vue est correct
})->name('distributeur-agent')->middleware('auth');


/**
 * Groupe de routes pour le tableau de bord.
 */
Route::middleware('auth')->prefix('dashboard')->group(function () {
    // Route::view('index', 'dashboard.index')->name('index');
    Route::view('dashboard-transactions', 'dashboard.dashboard-transactions')->name('dashboard-transactions');
    Route::view('dashboard-distributeur', 'dashboard.dashboard-distributeur')->name('dashboard-distributeur');
    Route::get('dashboard-distributeur', [DistributeurController::class, 'index'])->name('dashboard-distributeur');
    Route::view('dashboard-client', 'dashboard.dashboard-client')->name('dashboard-client');
    Route::view('dashboard-activites', 'dashboard.dashboard-activites')->name('dashboard-activites');
    Route::view('dashboard-utilisateurs', 'dashboard.dashboard-utilisateurs')->name('dashboard-utilisateurs');
    Route::view('dashboard-approvisionner', 'dashboard.dashboard-approvisionner')->name('dashboard-approvisionner');
    route::get('dashboard-approvisionner', [DistributeurController::class, 'afficherDistributeurs'])->name('dashboard-approvisionner');
    route::get('dashboard-utilisateurs', [UserController::class, 'afficherUsers'])->name('dashboard-utilisateurs');
    Route::view('profile', 'dashboard.profile')->name('profile');
    Route::get('/dashboard-distributeur', [DistributeurController::class, 'afficherHistorique'])->name('distributeurs.afficher_Historique');
    Route::get('/dashboard-client', [ClientController::class, 'afficherHistoriqueClients'])->name('clients.afficher_Historiques_clients');
    Route::get('/bilan-global', [TransactionController::class, 'bilanGlobal'])->name('bilan.global');
    Route::get('index',  [TransactionController::class, 'index'])->name('index');
    // Route pour afficher l'historique des transactions
Route::get('/dashboard-transactions', [TransactionController::class, 'afficherHistorique'])->name('dashboard-transactions');

   
});

/**
 * Routes pour les comptes, incluant les opérations CRUD.
 */
Route::middleware('auth')->prefix('comptes')->group( function () {
    Route::resource('comptes', CompteController::class); // Index, create, store, show, edit, update, destroy

// Routes spécifiques pour les opérations sur les comptes
Route::post('comptes/{compte}/debiter', [CompteController::class, 'debiter'])->name('comptes.debiter');
Route::post('comptes/{compte}/crediter', [CompteController::class, 'crediter'])->name('comptes.crediter');
Route::post('comptes/{compte}/bloquer', [CompteController::class, 'bloquer'])->name('comptes.bloquer');
Route::post('comptes/{compte}/debloquer', [CompteController::class, 'debloquer'])->name('comptes.debloquer');
Route::post('comptes/{compte}/generate-qr-code', [CompteController::class, 'generateQrCode'])->name('comptes.generateQrCode');
Route::post('comptes/verifier-qr-code', [CompteController::class, 'verifierQrCode'])->name('comptes.verifierQrCode');

});

/**
 * Routes pour les utilisateurs, incluant les opérations CRUD.
 */
Route::middleware('auth')->prefix('utilisateurs')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('utilisateurs.index'); // Affiche tous les utilisateurs
    Route::get('/{user}', [UserController::class, 'show'])->name('utilisateurs.show'); // Affiche un utilisateur
    Route::post('/', [UserController::class, 'creerUtilisateur'])->name('utilisateurs.creer'); // Crée un nouvel utilisateur
    Route::put('/{user}', [UserController::class, 'modifierUtilisateur'])->name('utilisateurs.modifier'); // Modifie un utilisateur
    Route::post('/{user}/bloquer', [UserController::class, 'bloquerCompte'])->name('utilisateurs.bloquer'); // Bloque un compte
    Route::delete('/{user}', [UserController::class, 'supprimerUtilisateur'])->name('utilisateurs.supprimer'); // Supprime un utilisateur
});

/**
 * Routes pour les clients, incluant les opérations CRUD.
 */
Route::middleware('auth')->prefix('clients')->group(function () {
    Route::post('/transfert-clients', [ClientController::class, 'transfertEntreClients'])->name('clients.transfert_clients');
});

/**
 * Routes pour les agent, incluant les opérations CRUD.
 */
Route::middleware('auth')->prefix('agent')->group(function () {
    // Actions spécifiques pour les agents
    Route::post('/{agent}/creer-compte-client', [AgentController::class, 'creerCompteClient'])->name('agents.creer_compte_client');
    Route::put('/{agent}/modifier-compte/{clientId}', [AgentController::class, 'modifierCompte'])->name('agents.modifier_compte');
    // Route::post('/{agent}/crediter-compte-distributeur/{distributeurId}', [AgentController::class, 'crediterCompteDistributeur'])->name('agents.crediter_compte_distributeur');
    // Route::post('/{agent}/bloquer-compte/{clientId}', [AgentController::class, 'bloquerCompte'])->name('agents.bloquer_compte');
    Route::post('/{agent}/annuler-transaction/{transaction}', [AgentController::class, 'annulerTransaction'])->name('agents.annuler_transaction');
    Route::post('/crediter-compte-distributeur/', [AgentController::class, 'crediterCompteDistributeur'])->name('agents.crediter_compte_distributeur');
    Route::post('/crediter-rapide-distributeur/', [AgentController::class, 'crediterRapideDistributeur'])->name('agents.crediter_rapide_distributeur');
    Route::post('/bloquer-utilisateur/{userId}', [AgentController::class, 'bloquerOuDebloquerCompte'])->name('agents.bloquer_utilisateur');
    Route::get('dashboard-transactions', [UserController::class, 'afficherTransactions'])->name('transactions.afficher');
});

/**
 * Routes pour les distributeurs, incluant les opérations CRUD.
 */
Route::middleware('auth')->prefix('distributeurs')->group(function () {
    Route::get('/', [DistributeurController::class, 'index'])->name('distributeurs.index');
    Route::get('/{distributeur}', [DistributeurController::class, 'show'])->name('distributeurs.show');
    Route::post('/', [DistributeurController::class, 'store'])->name('distributeurs.store');
    Route::put('/{distributeur}', [DistributeurController::class, 'update'])->name('distributeurs.update');
    Route::delete('/{distributeur}', [DistributeurController::class, 'destroy'])->name('distributeurs.destroy');

    // Actions spécifiques pour les distributeurs
    Route::post('/{distributeur}/consulter-solde', [DistributeurController::class, 'consulterSolde'])->name('distributeurs.consulter_solde');
    Route::post('/crediter-compte-client', [DistributeurController::class, 'crediterCompteClient'])->name('distributeurs.crediter_compte_client');
    Route::post('/effectuer-retrait', [DistributeurController::class, 'effectuerRetrait'])->name('distributeurs.effectuer_retrait');
    Route::post('/transferer-clients', [DistributeurController::class, 'transfererEntreClients'])->name('distributeurs.transfert_clients');
    //Route::get('/dashboard-distributeur', [DistributeurController::class, 'afficherHistorique'])->name('distributeurs.afficher_Historique');
    Route::post('/{distributeur}/voir-solde', [DistributeurController::class, 'voirSolde'])->name('distributeurs.voir_solde');
    Route::get('/{distributeur}/transactions', [DistributeurController::class, 'voirTransactions'])->name('distributeurs.voir_transactions');
    Route::post('/annuler-transaction/{transaction}', [DistributeurController::class, 'annulerTransaction'])->name('distributeurs.annuler_transaction');
    Route::post('/{distributeur}/scanner-qrcode', [DistributeurController::class, 'scannerQRCode'])->name('distributeurs.scanner_qrcode');
    // Route::get('dashboard-distributeur', [DistributeurController::class, 'afficherHistorique'])->name('dashboard-distributeur');
});

/**
 * Routes pour la page de connexion.
 */
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

/**
 * Routes pour le profil utilisateur.
 */

 Route::put('profile/update/{id}', [RegisterController::class, 'update'])->name('profile.update');


/**
 * Routes pour la gestion des distributeurs.
 */
Route::prefix('distributeurs')->middleware('auth')->group(function () {
    Route::get('/', [DistributeurController::class, 'index'])->name('distributeurs.index');
    Route::get('/{distributeur}', [DistributeurController::class, 'show'])->name('distributeurs.show');
    Route::post('/', [DistributeurController::class, 'store'])->name('distributeurs.store');
    Route::put('/{distributeur}', [DistributeurController::class, 'update'])->name('distributeurs.update');
    Route::delete('/{distributeur}', [DistributeurController::class, 'destroy'])->name('distributeurs.destroy');
});

/**
 * Routes pour la gestion des agents.
 */
Route::prefix('agents')->middleware('auth')->group(function () {
    Route::get('/', [AgentController::class, 'index'])->name('agents.index');
    Route::get('/{agent}', [AgentController::class, 'show'])->name('agents.show');
    Route::post('/', [AgentController::class, 'store'])->name('agents.store');
    Route::put('/{agent}', [AgentController::class, 'update'])->name('agents.update');
    Route::delete('/{agent}', [AgentController::class, 'destroy'])->name('agents.destroy');
});

/**
 * Routes pour la gestion des transactions.
 */
Route::prefix('transactions')->middleware('auth')->name('transactions.')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('index');
    Route::post('/', [TransactionController::class, 'store'])->name('store');
    Route::get('{transaction}', [TransactionController::class, 'show'])->name('show');
    Route::post('{transaction}/annuler', [TransactionController::class, 'annuler'])->name('annuler');
    // Route::post('/transactions/{transaction}/annuler', [TransactionController::class, 'annulerTransaction'])->name('transactions.annuler');
    Route::get('historique', [TransactionController::class, 'historique'])->name('historique');
    Route::get('statistiques', [TransactionController::class, 'statistiques'])->name('statistiques');
    
});

/**
 * Routes pour la gestion des CLients.
 */
Route::prefix('clients')->group(function () {
    Route::post('/transfert-clients', [ClientController::class, 'transfertEntreClients'])->name('clients.transfert_clients');
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
 * Routes pour la gestion des logs du système.
 */
Route::prefix('logs')->middleware('auth')->group(function () {
    Route::get('/', [SystemLoggerController::class, 'index'])->name('logs.index');
});

/**
 * Routes pour les clients.
 */
Route::prefix('clients')->middleware('auth')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/{client}', [ClientController::class, 'show'])->name('clients.show');
    Route::post('/', [ClientController::class, 'store'])->name('clients.store');
    Route::put('/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
});





