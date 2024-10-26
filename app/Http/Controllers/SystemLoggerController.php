<?php

namespace App\Http\Controllers;

use App\Models\SystemLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SystemLoggerController extends Controller
{
    /**
     * Enregistrer un log.
     */
    public function enregistrerLog(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'action' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);

            $log = SystemLogger::create($validatedData);

            return response()->json(['message' => 'Log enregistré avec succès', 'log' => $log], 201);
        } catch (ValidationException $e) {
            Log::error('Erreur de validation lors de l\'enregistrement du log: ' . $e->getMessage());
            return response()->json(['error' => 'Données invalides'], 422);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement du log: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de l\'enregistrement'], 500);
        }
    }

    /**
     * Récupérer les logs en fonction des critères.
     */
    public function recupererLogs(Request $request)
    {
        try {
            $query = SystemLogger::query();

            // Ajoutez des critères de filtrage ici
            if ($request->has('user_id')) {
                $query->where('user_id', $request->input('user_id'));
            }

            if ($request->has('action')) {
                $query->where('action', 'LIKE', '%' . $request->input('action') . '%');
            }

            $logs = $query->get();

            return response()->json(['logs' => $logs], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des logs: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la récupération des logs'], 500);
        }
    }

    /**
     * Générer un rapport des logs entre deux dates.
     */
    public function genererRapport(Request $request)
    {
        $request->validate([
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
        ]);

        try {
            $logs = SystemLogger::whereBetween('timestamp', [$request->dateDebut, $request->dateFin])->get();

            // Génération du rapport ici (ex: export CSV, PDF, etc.)
            // Pour l'instant, on retourne simplement les logs

            return response()->json(['rapport' => $logs], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération du rapport: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la génération du rapport'], 500);
        }
    }
}
