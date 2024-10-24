<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Http\Requests\Agent\StoreAgentRequest;
use App\Http\Requests\Agent\UpdateAgentRequest;
use App\Http\Resources\AgentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $agents = Agent::with('user')
            ->when(request('search'), function($query, $search) {
                $query->where('numero_identite', 'like', "%{$search}%")
                    ->orWhereHas('user', function($q) use ($search) {
                        $q->where('nom', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                    });
            })
            ->orderBy(request('sort_by', 'created_at'), request('sort_direction', 'desc'))
            ->paginate(request('per_page', 10));
        
        return AgentResource::collection($agents);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Créer un nouvel agent
     */
    public function store(StoreAgentRequest $request): JsonResponse
{
    try {
        DB::beginTransaction();

        // Pas besoin d'exclure numero_identite car il fait partie des données utilisateur
        $userData = $request->validated();
        $userData['role'] = UserRole::AGENT;
        $userData['mot_de_passe'] = Hash::make($userData['mot_de_passe']);

        $agent = Agent::createWithUser($userData);

        DB::commit();

        return response()->json([
            'message' => 'Agent créé avec succès',
            'data' => new AgentResource($agent)
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Erreur lors de la création de l\'agent',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Afficher un agent spécifique
     */
    public function show(Agent $agent): JsonResource
    {
        return new AgentResource($agent->load('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Agent $agent)
    // {
    //     //
    // }

    /**
     * Mettre à jour un agent
     */
    public function update(UpdateAgentRequest $request, Agent $agent): JsonResponse
{
    try {
        DB::beginTransaction();

        $userData = $request->validated();
        if (isset($userData['mot_de_passe'])) {
            $userData['mot_de_passe'] = Hash::make($userData['mot_de_passe']);
        }

        // Mise à jour des données de l'utilisateur
        if (!empty($userData)) {
            $agent->user->update($userData);
        }

        DB::commit();

        return response()->json([
            'message' => 'Agent mis à jour avec succès',
            'data' => new AgentResource($agent->load('user'))
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Erreur lors de la mise à jour de l\'agent',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Supprimer un agent
     */
    public function destroy(Agent $agent): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Supprimer l'utilisateur (cascade supprimera aussi l'agent)
            $agent->user->delete();

            DB::commit();

            return response()->json([
                'message' => 'Agent supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la suppression de l\'agent',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}