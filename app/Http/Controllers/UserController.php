<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest as UserStoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest as UserUpdateUserRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs avec recherche et tri
     */
    public function index(Request $request)
    {
        $users = User::when($request->search, function($query, $search) {
                $query->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('numero_identite', 'like', "%{$search}%");
            })
            ->when($request->role, function($query, $role) {
                $query->where('role', $role);
            })
            ->orderBy($request->sort_by ?? 'created_at', $request->sort_direction ?? 'desc')
            ->paginate($request->per_page ?? 10);

        return new UserCollection($users);
    }

    /**
     * Créer un nouvel utilisateur
     */
    public function store(UserStoreUserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userData = $request->validated();
            $userData['mot_de_passe'] = Hash::make($userData['mot_de_passe']);
            
            $user = User::create($userData);

            DB::commit();

            return response()->json([
                'message' => 'Utilisateur créé avec succès',
                'data' => new UserResource($user)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la création de l\'utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher un utilisateur spécifique
     */
    public function show(User $users): JsonResponse
    {
        try {
            return response()->json([
                'data' => new UserResource($users)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération de l\'utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(UserUpdateUserRequest $request, User $users): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userData = $request->validated();
            
            // Hash du mot de passe seulement s'il est fourni
            if (isset($userData['mot_de_passe'])) {
                $userData['mot_de_passe'] = Hash::make($userData['mot_de_passe']);
            }

            $users->update($userData);

            DB::commit();

            return response()->json([
                'message' => 'Utilisateur mis à jour avec succès',
                'data' => new UserResource($users)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de l\'utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy(User $users): JsonResponse
    {
        try {
            DB::beginTransaction();

            $users->delete();

            DB::commit();

            return response()->json([
                'message' => 'Utilisateur supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la suppression de l\'utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Activer/désactiver le compte d'un utilisateur
     */
    public function toggleStatus(User $users): JsonResponse
    {
        try {
            $users->update([
                'etat_compte' => !$users->etat_compte
            ]);

            return response()->json([
                'message' => 'État du compte modifié avec succès',
                'data' => new UserResource($users)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la modification de l\'état du compte',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}