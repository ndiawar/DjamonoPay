<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Relations à charger automatiquement
     */
    private const RELATIONS = ['compte', 'distributeur', 'agent'];

    /**
     * Afficher la liste des utilisateurs
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when(
                $request->search,
                function (Builder $query, string $search) {
                    $query->where(function (Builder $query) use ($search) {
                        $query->where('nom', 'like', "%{$search}%")
                            ->orWhere('prenom', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('numero_identite', 'like', "%{$search}%");
                    });
                }
            )
            ->when(
                $request->role,
                fn (Builder $query, string $role) => $query->role($role)
            )
            ->when(
                $request->etat,
                fn (Builder $query, string $etat) => $etat === User::ETAT_ACTIF ? $query->actif() : $query->bloque()
            )
            ->orderBy($request->sort_by ?? 'created_at', $request->sort_direction ?? 'desc')
            ->with(self::RELATIONS)
            ->paginate($request->per_page ?? 10);

        // Si c'est une requête AJAX, retourner du JSON
        if ($request->ajax()) {
            return new UserCollection($users);
        }

        // Sinon retourner la vue
        return view('users.index', compact('users'));
    }

    /**
     * Afficher un utilisateur spécifique
     */
    public function show(User $user)
    {
        try {
            $user->load(self::RELATIONS);

            if (request()->ajax()) {
                return response()->json([
                    'data' => new UserResource($user)
                ]);
            }

            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            report($e);
            if (request()->ajax()) {
                return response()->json([
                    'message' => 'Erreur lors de la récupération de l\'utilisateur',
                    'error' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Erreur lors de la récupération de l\'utilisateur');
        }
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(User $user)
    {
        try {
            $user->load(self::RELATIONS);
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            report($e);
            return back()->with('error', 'Erreur lors du chargement du formulaire d\'édition');
        }
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $userData = $request->validated();
            
            // Gestion du mot de passe
            if (isset($userData['password']) && !empty($userData['password'])) {
                $userData['password'] = Hash::make($userData['password']);
            } else {
                unset($userData['password']);
            }

            // Gestion de la photo
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                // Stocker la nouvelle photo
                $userData['photo'] = $request->file('photo')->store('users/photos', 'public');
            }

            // Mise à jour de l'utilisateur
            $user->update($userData);

            // Gestion de l'état du compte
            if (isset($userData['etat_compte']) && $userData['etat_compte'] !== $user->getOriginal('etat_compte')) {
                $userData['etat_compte'] === User::ETAT_ACTIF
                    ? $user->debloquerCompte()
                    : $user->bloquerCompte();
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Utilisateur mis à jour avec succès',
                    'data' => new UserResource($user->load(self::RELATIONS))
                ]);
            }

            return redirect()
                ->route('users.index')
                ->with('success', 'Utilisateur mis à jour avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Erreur lors de la mise à jour de l\'utilisateur',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour de l\'utilisateur');
        }
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            // Supprimer la photo si elle existe
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'message' => 'Utilisateur supprimé avec succès'
                ]);
            }

            return back()->with('success', 'Utilisateur supprimé avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            
            if (request()->ajax()) {
                return response()->json([
                    'message' => 'Erreur lors de la suppression de l\'utilisateur',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la suppression de l\'utilisateur');
        }
    }

    /**
     * Activer/désactiver le compte d'un utilisateur
     */
    public function toggleStatus(User $user)
    {
        try {
            DB::beginTransaction();

            $user->etat_compte === User::ETAT_ACTIF
                ? $user->bloquerCompte()
                : $user->debloquerCompte();

            DB::commit();

            if (request()->ajax()) {
                return response()->json([
                    'message' => 'État du compte modifié avec succès',
                    'data' => new UserResource($user->load(self::RELATIONS))
                ]);
            }

            return back()->with('success', 'État du compte modifié avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            
            if (request()->ajax()) {
                return response()->json([
                    'message' => 'Erreur lors de la modification de l\'état du compte',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Erreur lors de la modification de l\'état du compte');
        }
    }
}