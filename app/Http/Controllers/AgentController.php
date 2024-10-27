<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agent\StoreAgentRequest;
use App\Http\Requests\Agent\UpdateAgentRequest;
use App\Http\Resources\AgentResource;
use App\Http\Resources\AgentCollection;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Compte;
use App\Models\Distributeur;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AgentController extends Controller
{
    /**
     * Affiche tous les agents.
     */
    public function index(Request $request)
    {
        $agents = Agent::paginate(10);
        return new AgentCollection($agents);
    }

    /**
     * Affiche un agent spécifique.
     */
    public function show(Agent $agent)
    {
        return new AgentResource($agent->load('transactions'));
    }

    /**
     * Enregistre un nouvel agent.
     */
    public function store(StoreAgentRequest $request)
    {
        $validated = $request->validated();
        $agent = Agent::create($validated);
        return new AgentResource($agent);
    }

    /**
     * Met à jour un agent existant.
     */
    public function update(UpdateAgentRequest $request, Agent $agent)
    {
        $validated = $request->validated();
        $agent->update($validated);
        return new AgentResource($agent);
    }

    /**
     * Supprime un agent.
     */
    public function destroy(Agent $agent)
    {
        $agent->delete();
        return response()->json(['message' => 'Agent supprimé avec succès'], 200);
    }

    /**
     * Crée un compte client.
     */
    public function creerCompteClient(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'required|string|unique:users,telephone',
            'adresse' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'numero_identite' => 'required|string|unique:users,numero_identite',
        ]);
        
        DB::beginTransaction();

        try {
            $client = Client::create($request->all());
            DB::commit();
            return response()->json(['message' => 'Compte client créé avec succès', 'client' => new AgentResource($client)]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors de la création du compte client'], 500);
        }
    }

    /**
     * Modifie un compte client.
     */
    public function modifierCompte(Request $request, $clientId)
    {
        $request->validate([
            // Ajoutez les validations nécessaires
        ]);

        DB::beginTransaction();

        try {
            $client = Client::findOrFail($clientId);
            $client->update($request->all());
            DB::commit();
            return response()->json(['message' => 'Compte client modifié avec succès', 'client' => new AgentResource($client)]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Client non trouvé'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erreur lors de la modification du compte client'], 500);
        }
    }

    /**
     * Crediter Distributeur
     */

    public function crediterCompteDistributeur(Request $request)
    {
        $request->validate([
            'numero_compte' => 'required|string',
            'montant' => 'required|numeric|min:0.01'
        ]);
        //dd($request->all());
        
        DB::beginTransaction();

        try {
            // Rechercher le compte par numéro de compte
            $compte = Compte::where('numero_compte', $request->numero_compte)->firstOrFail();
           

            // Logique pour créditer le compte
            // Ajouter le montant au solde existant
            $compte->solde += $request->montant;
            $compte->save();

            DB::commit();
            // Redirection vers la page dashboard-approvisionner avec un message de succès
            return redirect()->route('dashboard-approvisionner')->with('message', 'Créditation effectué avec succès');
            return response()->json(['message' => 'Crédit effectué avec succès']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('dashboard-approvisionner')->with('error', 'Compte non trouvé');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard-approvisionner')->with('error', 'Erreur lors du crédit');
        }
    }

   /**
 * Bloque un compte utilisateur.
 */
public function bloquerOuDebloquerCompte(Request $request, $userId)
{
    DB::beginTransaction();

    try {
        // Récupérer l'utilisateur par son ID
        $user = User::findOrFail($userId);

        // Basculer l'état du compte
        if ($user->etat_compte === 'actif') {
            $user->etat_compte = 'inactif'; // Bloquer le compte
        } else {
            $user->etat_compte = 'actif'; // Débloquer le compte
        }

        // Sauvegarder les modifications
        $user->save();

        DB::commit();
        
        return redirect()->route('dashboard-utilisateurs')->with('success', 'L\'utilisateur a été mis à jour avec succès.');
    } catch (ModelNotFoundException $e) {
        DB::rollBack();
        return response()->json(['message' => 'Utilisateur non trouvé'], 404);
    } catch (\Exception $e) {
        DB::rollBack();
        // Enregistrer l'exception dans les logs pour le débogage
        // Log::error('Erreur lors de la mise à jour de l\'état du compte utilisateur: ' . $e->getMessage());

        return response()->json(['message' => 'Erreur lors de la mise à jour de l\'état du compte utilisateur'], 500);
    }
}



    /**
     * Annule une transaction.
     */
    public function annulerTransaction(Request $request, Transaction $transaction)
    {
        try {
            $transaction->etat = 'annulé';
            $transaction->save();
            return response()->json(['message' => 'Transaction annulée avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de l\'annulation de la transaction'], 500);
        }
    }
    public function showForm($agentId, $distributeurId)
{
    // Trouver l'agent par son ID
    $agent = Agent::findOrFail($agentId);

    // Trouver le distributeur par son ID
    $distributeur = Distributeur::findOrFail($distributeurId);
    
    // Passer les données à la vue
    return view('dashboard.index', compact('agent', 'distributeur'));
}

public function crediterRapideDistributeur(Request $request)
    {
        $request->validate([
            'numero_compte' => 'required|string',
            'montant' => 'required|numeric|min:0.01'
        ]);
        //dd($request->all());
        
        DB::beginTransaction();

        try {
            // Rechercher le compte par numéro de compte
            $compte = Compte::where('numero_compte', $request->numero_compte)->firstOrFail();
           

            // Logique pour créditer le compte
            // Ajouter le montant au solde existant
            $compte->solde += $request->montant;
            $compte->save();

            DB::commit();
            return redirect()->back()->with('message', 'Depôt effectué avec succès'); // Redirection vers la même page
            } catch (ModelNotFoundException $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Compte non trouvé'); // Redirection vers la même page avec message d'erreur
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Erreur lors du crédit'); // Redirection vers la même page avec message d'erreur
            }
    }
    //CalculUser pour les nombres d'agent, de distributeurs et de Client qu'il y a 
    // public function CalculUser()
    // {
    //     $nombreClients = Client::count(); // Compte le nombre de clients
    //     $nombreDistributeurs = Distributeur::count(); // Compte le nombre de distributeurs
    //     $nombreAgents = Agent::count(); // Compte le nombre de distributeurs
    
    //     return view('dashboard.index', compact('nombreClients', 'nombreDistributeurs','nombreAgents'));
    // }
    


}
  