<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Enums\UserRole; // Importation de l'énumération
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Exception;

class UserController extends Controller
{
    /**
     * Crée un nouvel utilisateur.
     */
    public function creerUtilisateur(StoreUserRequest $request)
    {
        try {
            $validated = $request->validated();

            // Hachage du mot de passe
            $validated['password'] = Hash::make($validated['password']);

            // Gestion de l'image si elle est fournie
            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('photos', 'public');
            }

            $user = User::create($validated);

            return new UserResource($user);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Erreur lors de la création de l\'utilisateur : ' . $e->getMessage()], 400);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur inattendue : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Modifie un utilisateur existant.
     */
    public function modifierUtilisateur(UpdateUserRequest $request, User $user)
    {
        try {
            $validated = $request->validated();

            // Hachage du mot de passe si fourni
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']); // Ne pas mettre à jour le mot de passe
            }

            // Gestion de l'image si elle est fournie
            if ($request->hasFile('photo')) {
                // Supprime l'ancienne photo si nécessaire
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                $validated['photo'] = $request->file('photo')->store('photos', 'public');
            }

            $user->update($validated);

            return new UserResource($user);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Erreur lors de la modification de l\'utilisateur : ' . $e->getMessage()], 400);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur inattendue : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Bloque un compte utilisateur.
     */
    public function bloquerCompte(User $user)
    {
        try {
            $user->etat_compte = false; // Ou 'inactif' selon votre logique
            $user->save();

            return response()->json(['message' => 'Compte bloqué avec succès'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors du blocage du compte : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Supprime un utilisateur.
     */
    public function supprimerUtilisateur(User $user)
    {
        try {
            // Supprime l'image si elle existe
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->delete();

            return response()->json(['message' => 'Utilisateur supprimé avec succès'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Erreur lors de la suppression de l\'utilisateur : ' . $e->getMessage()], 400);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur inattendue : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Récupère tous les utilisateurs avec pagination.
     */
    public function index(Request $request)
    {
        try {
            $users = User::paginate(10); // 10 utilisateurs par page
            return new UserCollection($users);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération des utilisateurs : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Récupère un utilisateur par son ID.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Récupère le nombre d'utilisateurs par rôle.
     */
    public function CalculUser()
    {
        // Sélectionner tous les utilisateurs avec leurs rôles
        $users = User::with('role')->get();
    
        // Compte des utilisateurs par rôle
        $nombreClients = $users->filter(function ($user) {
            return $user->role && $user->role->id === UserRole::CLIENT; // Assurez-vous d'utiliser la bonne clé pour vérifier le rôle
        })->count();
    
        $nombreDistributeurs = $users->filter(function ($user) {
            return $user->role && $user->role->id === UserRole::DISTRIBUTEUR; // Idem pour le distributeur
        })->count();
    
        $nombreAgents = $users->filter(function ($user) {
            return $user->role && $user->role->id === UserRole::AGENT; // Idem pour l'agent
        })->count();
    
        // Retourne les comptes au format JSON
        return response()->json([
            'nombreClients' => $nombreClients,
            'nombreDistributeurs' => $nombreDistributeurs,
            'nombreAgents' => $nombreAgents,
        ]);
    }
    
    
    public function afficherUsers()
    {
        // Sélectionner tous les utilisateurs et leurs comptes
        $users = User::with('comptes')->get();

        return view('dashboard.dashboard-utilisateurs', compact('users'));
        
    }

    public function afficherTransactions()
{
    try {
        // Récupérer toutes les transactions
        $transactions = User::with('distributeur')->get(); // Assurez-vous que la relation distributeur est définie dans votre modèle Transaction

        return view('dashboard.dashboard-transactions', compact('transactions'));
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erreur lors de la récupération des transactions'], 500);
    }
}

    
 }
   
