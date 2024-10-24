<?php

namespace App\Http\Controllers;

use App\Models\Distributeur;
use App\Models\Users;
use App\Http\Requests\Distributeur\StoreDistributeurRequest;
use App\Http\Requests\Distributeur\UpdateDistributeurRequest;
use App\Http\Resources\DistributeurResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DistributeurController extends Controller
{
    // public function index(): JsonResource
    // {
    //     $distributeurs = Distributeur::with('users2')
    //         ->when(request('search'), function($query, $search) {
    //             $query->whereHas('users2', function($q) use ($search) {
    //                 $q->where('nom', 'like', "%{$search}%")
    //                   ->orWhere('email', 'like', "%{$search}%")
    //                   ->orWhere('numero_identite', 'like', "%{$search}%");
    //             });
    //         })
    //         ->orderBy(request('sort_by', 'created_at'), request('sort_direction', 'desc'))
    //         ->paginate(request('per_page', 10));
        
    //     return DistributeurResource::collection($distributeurs);
    // }
    public function index(Request $request)
    {
        $distributeurs = Distributeur::with('users2')
            ->when($request->input('search'), function($query, $search) {
                $query->whereHas('users2', function($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('numero_identite', 'like', "%{$search}%");
                });
            })
            ->orderBy($request->input('sort_by', 'created_at'), $request->input('sort_direction', 'desc'))
            ->paginate($request->input('per_page', 10));
        
        return view('dashboard.dashboard-distributeur', compact('distributeurs'));
    }
    


    public function store(StoreDistributeurRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userData = $request->validated();
            $userData['mot_de_passe'] = Hash::make($userData['mot_de_passe']);

            $distributeur = Distributeur::createWithUser($userData);

            DB::commit();

            return response()->json([
                'message' => 'Distributeur créé avec succès',
                'data' => new DistributeurResource($distributeur)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la création du distributeur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Distributeur $distributeur): JsonResource
    {
        return new DistributeurResource($distributeur->load('users2'));
    }

    public function update(UpdateDistributeurRequest $request, Distributeur $distributeur): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Mise à jour des données de l'utilisateur
            $userData = $request->safe()->except(['solde']);
            if (isset($userData['mot_de_passe'])) {
                $userData['mot_de_passe'] = Hash::make($userData['mot_de_passe']);
            }

            if (!empty($userData)) {
                $distributeur->users2->update($userData);
            }

            // Mise à jour du solde si fourni
            if ($request->has('solde')) {
                $distributeur->update(['solde' => $request->solde]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Distributeur mis à jour avec succès',
                'data' => new DistributeurResource($distributeur->load('users2'))
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la mise à jour du distributeur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Distributeur $distributeur): JsonResponse
    {
        try {
            DB::beginTransaction();

            $distributeur->users2->delete();

            DB::commit();

            return response()->json([
                'message' => 'Distributeur supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la suppression du distributeur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour le solde d'un distributeur
     */
    public function updateSolde(Request $request, Distributeur $distributeur): JsonResponse
    {
        try {
            $request->validate([
                'montant' => 'required|numeric|min:0'
            ]);

            $distributeur->update([
                'solde' => $request->montant
            ]);

            return response()->json([
                'message' => 'Solde mis à jour avec succès',
                'data' => new DistributeurResource($distributeur->load('users2'))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la mise à jour du solde',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}