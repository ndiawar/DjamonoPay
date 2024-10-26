<?php

namespace App\Http\Controllers;

use App\Http\Requests\Compte\StoreCompteRequest;
use App\Http\Requests\Compte\UpdateCompteRequest;
use App\Http\Resources\CompteResource;
use App\Models\Compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Exception;

class CompteController extends Controller
{
    /**
     * Affiche tous les comptes.
     */
    public function index()
    {
        try {
            $comptes = Compte::with('user')->get();
            return view('comptes.index', compact('comptes'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la récupération des comptes : ' . $e->getMessage());
        }
    }

    /**
     * Affiche le formulaire de création d'un compte.
     */
    public function create()
    {
        return view('comptes.create');
    }

    /**
     * Enregistre un nouveau compte.
     */
    public function store(StoreCompteRequest $request)
    {
        try {
            $compte = Compte::create($request->validated());
            return redirect()->route('comptes.index')->with('success', 'Compte créé avec succès');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du compte : ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur inattendue : ' . $e->getMessage());
        }
    }

    /**
     * Affiche un compte spécifique.
     */
    public function show(Compte $compte)
    {
        return view('comptes.show', compact('compte'));
    }

    /**
     * Affiche le formulaire d'édition d'un compte.
     */
    public function edit(Compte $compte)
    {
        return view('comptes.edit', compact('compte'));
    }

    /**
     * Met à jour un compte existant.
     */
    public function update(UpdateCompteRequest $request, Compte $compte)
    {
        try {
            $compte->update($request->validated());
            return redirect()->route('comptes.index')->with('success', 'Compte mis à jour avec succès');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du compte : ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur inattendue : ' . $e->getMessage());
        }
    }

    /**
     * Supprime un compte.
     */
    public function destroy(Compte $compte)
    {
        try {
            $compte->delete();
            return redirect()->route('comptes.index')->with('success', 'Compte supprimé avec succès');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du compte : ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur inattendue : ' . $e->getMessage());
        }
    }

    /**
     * Débiter un montant du compte.
     */
    public function debiter(Request $request, Compte $compte)
    {
        try {
            $request->validate(['montant' => 'required|numeric|min:0.01']);
            $montant = $request->input('montant');

            if ($compte->solde < $montant) {
                return redirect()->back()->with('error', 'Solde insuffisant');
            }

            DB::transaction(function () use ($compte, $montant) {
                $compte->decrement('solde', $montant);
                // Enregistrer la transaction ici si nécessaire
            });

            return redirect()->route('comptes.show', $compte->id)->with('success', 'Débit effectué avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du débit du compte : ' . $e->getMessage());
        }
    }

    /**
     * Crédite un montant sur le compte.
     */
    public function crediter(Request $request, Compte $compte)
    {
        try {
            $request->validate(['montant' => 'required|numeric|min:0.01']);
            $montant = $request->input('montant');

            DB::transaction(function () use ($compte, $montant) {
                $compte->increment('solde', $montant);
                // Enregistrer la transaction ici si nécessaire
            });

            return redirect()->route('comptes.show', $compte->id)->with('success', 'Crédit effectué avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du crédit du compte : ' . $e->getMessage());
        }
    }

    /**
     * Bloque le compte.
     */
    public function bloquer(Request $request, Compte $compte)
    {
        try {
            $compte->update(['est_bloque' => true]);
            return redirect()->route('comptes.show', $compte->id)->with('success', 'Compte bloqué avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du blocage du compte : ' . $e->getMessage());
        }
    }

    /**
     * Débloque le compte.
     */
    public function debloquer(Request $request, Compte $compte)
    {
        try {
            $compte->update(['est_bloque' => false]);
            return redirect()->route('comptes.show', $compte->id)->with('success', 'Compte débloqué avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du déblocage du compte : ' . $e->getMessage());
        }
    }

    /**
     * Génère un QR Code pour le compte.
     */
    public function generateQrCode(Compte $compte)
    {
        try {
            // Créez une instance de QrCode avec le contenu
            $qrCode = new QrCode($compte->numero);

            // Créez une instance du Writer pour PNG
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            // Enregistrez le QR Code dans le système de fichiers
            $filePath = 'qrcodes/' . $compte->id . '.png';
            Storage::disk('public')->put($filePath, $result->getString());

            // Mettez à jour le compte avec le chemin du QR Code
            $compte->update([
                'qr_code' => $filePath,
                'qr_code_creation' => now()
            ]);

            return redirect()->route('comptes.show', $compte->id)->with('success', 'QR Code généré avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la génération du QR Code : ' . $e->getMessage());
        }
    }

    /**
     * Vérifie le QR Code.
     */
    public function verifierQrCode(Request $request)
    {
        // Logique pour vérifier le QR Code
        // Exemple de code pour vérifier le QR Code (vous devez implémenter cela selon votre logique)

        try {
            // Logique de vérification
            return redirect()->back()->with('success', 'QR Code vérifié avec succès');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la vérification du QR Code : ' . $e->getMessage());
        }
    }
}
