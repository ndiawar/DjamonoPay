<?php
// app/Http/Controllers/SystemLoggerController.php

namespace App\Http\Controllers;

use App\Models\SystemLogger;
use Illuminate\Http\Request;

class SystemLoggerController extends Controller
{
    public function index()
    {
        return $this->dashboard();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'action' => 'required|string',
            'description' => 'required|string',
        ]);

        $data['timestamp'] = $data['timestamp'] ?? now();
        $log = SystemLogger::create($data);

        return response()->json(['log' => $log], 201);
    }

    public function show($id)
    {
        $log = SystemLogger::findOrFail($id);
        return response()->json(['log' => $log], 200);
    }

    public function destroy($id)
    {
        $log = SystemLogger::findOrFail($id);
        $log->delete();
        return response()->json(['message' => 'Log deleted successfully'], 200);
    }

    // Méthode pour afficher la vue du tableau de bord
    public function dashboard()
    {
        // Récupère les logs avec les informations de l'utilisateur
        $logs = SystemLogger::with('user:id,nom,prenom') // Assure-toi que le modèle SystemLogger a une relation définie avec User
            ->select('id', 'user_id', 'action', 'timestamp', 'description')
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('dashboard.dashboard-activites', compact('logs'));
    }
    public function logAction($userId, $action, $description)
    {
        $data = [
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'timestamp' => now(),
        ];
        
        SystemLogger::create($data);
    }

    
}
