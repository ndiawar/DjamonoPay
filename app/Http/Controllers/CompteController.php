<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class CompteController extends Controller
{
    // Constante pour la durée de validité du QR Code (3 minutes)
    private const QR_CODE_VALIDITY = 3;

    /**
     * Créditer un compte via un distributeur
     */
    public function crediter(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'client_id' => 'required|exists:users,id',
                'montant' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            $client = User::findOrFail($request->client_id);
            $distributeur = auth()->user();

            // Vérifier si le compte client est bloqué
            if ($client->compte->est_bloque) {
                throw new \Exception('Ce compte est bloqué et ne peut pas être crédité');
            }

            // Créer la transaction
            $commission = $request->montant * 0.01; // 1% de commission
            $transaction = Transaction::creerDepot(
                $client->id,
                $distributeur->id,
                $request->montant,
                $commission
            );

            // Mettre à jour les soldes
            $client->compte->solde += $request->montant;
            $client->compte->save();

            $distributeur->compte->solde += $commission;
            $distributeur->compte->save();

            // Terminer la transaction
            $transaction->terminer();

            DB::commit();

            return response()->json([
                'message' => 'Compte crédité avec succès',
                'transaction' => $transaction,
                'nouveau_solde_client' => $client->compte->solde
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors du crédit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Débiter un compte via un distributeur
     */
    public function debiter(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'client_id' => 'required|exists:users,id',
                'montant' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            $client = User::findOrFail($request->client_id);
            $distributeur = auth()->user();

            // Vérifier si le compte est bloqué
            if ($client->compte->est_bloque) {
                throw new \Exception('Ce compte est bloqué et ne peut pas être débité');
            }

            // Vérifier si le solde est suffisant
            if ($client->compte->solde < $request->montant) {
                throw new \Exception('Solde insuffisant');
            }

            // Créer la transaction
            $commission = $request->montant * 0.01; // 1% de commission
            $transaction = Transaction::creerRetrait(
                $client->id,
                $distributeur->id,
                $request->montant,
                $commission
            );

            // Mettre à jour les soldes
            $client->compte->solde -= $request->montant;
            $client->compte->save();

            $distributeur->compte->solde += $commission;
            $distributeur->compte->save();

            // Terminer la transaction
            $transaction->terminer();

            DB::commit();

            return response()->json([
                'message' => 'Retrait effectué avec succès',
                'transaction' => $transaction,
                'nouveau_solde_client' => $client->compte->solde
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors du retrait',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Effectuer un transfert entre clients
     */
    public function transfert(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'destinataire_id' => 'required|exists:users,id',
                'montant' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            $expediteur = auth()->user();
            $destinataire = User::findOrFail($request->destinataire_id);

            // Vérifier les comptes bloqués
            if ($expediteur->compte->est_bloque || $destinataire->compte->est_bloque) {
                throw new \Exception('Un des comptes est bloqué');
            }

            // Calculer les frais (2%)
            $frais = $request->montant * 0.02;
            $montant_total = $request->montant + $frais;

            // Vérifier le solde
            if ($expediteur->compte->solde < $montant_total) {
                throw new \Exception('Solde insuffisant');
            }

            // Créer la transaction
            $transaction = Transaction::creerTransfert(
                $expediteur->id,
                $request->montant,
                $frais
            );

            // Mettre à jour les soldes
            $expediteur->compte->solde -= $montant_total;
            $expediteur->compte->save();

            $destinataire->compte->solde += $request->montant;
            $destinataire->compte->save();

            // Terminer la transaction
            $transaction->terminer();

            DB::commit();

            return response()->json([
                'message' => 'Transfert effectué avec succès',
                'transaction' => $transaction,
                'nouveau_solde' => $expediteur->compte->solde
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors du transfert',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bloquer un compte
     */
    public function bloquer(Compte $compte): JsonResponse
    {
        try {
            if ($compte->est_bloque) {
                return response()->json([
                    'message' => 'Ce compte est déjà bloqué'
                ]);
            }

            $compte->est_bloque = true;
            $compte->save();

            return response()->json([
                'message' => 'Compte bloqué avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors du blocage du compte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Débloquer un compte
     */
    public function debloquer(Compte $compte): JsonResponse
    {
        try {
            if (!$compte->est_bloque) {
                return response()->json([
                    'message' => 'Ce compte est déjà débloqué'
                ]);
            }

            $compte->est_bloque = false;
            $compte->save();

            return response()->json([
                'message' => 'Compte débloqué avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors du déblocage du compte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Générer un QR Code pour le compte
     */
public function generateQrCode(Compte $compte): JsonResponse
{
    try {
        // Vérifier si le compte est bloqué
        if ($compte->est_bloque) {
            return response()->json([
                'message' => 'Ce compte est bloqué'
            ], 400);
        }

        // Générer un token unique pour cette session
        $token = bin2hex(random_bytes(16)); // Alternative à Str::random

        // Créer les données à encoder dans le QR Code
        $qrCodeData = [
            'numero_compte' => $compte->numero,
            'utilisateur' => [
                'id' => $compte->user->id,
                'nom' => $compte->user->nom,
                'prenom' => $compte->user->prenom,
                'numero_identite' => $compte->user->numero_identite
            ],
            'token' => $token,
            'timestamp' => now()->timestamp,
            'expiration' => now()->addMinutes(self::QR_CODE_VALIDITY)->timestamp
        ];

        // Encoder les données en JSON
        $qrCodeString = json_encode($qrCodeData);
        
        // Créer le QR Code avec Endroid
        $qrCode = QrCode::create($qrCodeString)
            ->setSize(300)
            ->setMargin(10);
        
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        
        // Obtenir l'image en base64
        $qrCodeImage = base64_encode($result->getString());

        // Sauvegarder les informations du QR Code
        $compte->qr_code = $qrCodeString;
        $compte->qr_code_creation = now();
        $compte->save();

        return response()->json([
            'message' => 'QR Code généré avec succès',
            'qr_code_data' => $qrCodeData,
            'qr_code_image' => 'data:image/png;base64,' . $qrCodeImage,
            'validite' => self::QR_CODE_VALIDITY . ' minutes',
            'expiration' => now()->addMinutes(self::QR_CODE_VALIDITY)->format('Y-m-d H:i:s')
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erreur lors de la génération du QR Code',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Vérifier un QR Code
     */
    public function verifierQrCode(Request $request, Compte $compte): JsonResponse
    {
        try {
            $request->validate([
                'qr_code' => 'required|string'
            ]);

            // Vérifier si le compte est bloqué
            if ($compte->est_bloque) {
                return response()->json([
                    'message' => 'Ce compte est bloqué'
                ], 400);
            }

            // Décoder les données du QR Code
            $qrCodeData = json_decode($request->qr_code, true);

            // Vérifier si les données sont valides
            if (!$qrCodeData || 
                !isset($qrCodeData['numero_compte']) || 
                !isset($qrCodeData['utilisateur']) ||
                !isset($qrCodeData['expiration'])) {
                return response()->json([
                    'message' => 'QR Code invalide ou mal formaté'
                ], 400);
            }

            // Vérifier si le QR Code n'a pas expiré (3 minutes)
            if (now()->timestamp > $qrCodeData['expiration']) {
                return response()->json([
                    'message' => 'QR Code expiré',
                    'expired_since' => Carbon::createFromTimestamp($qrCodeData['expiration'])->diffForHumans()
                ], 400);
            }

            // Vérifier si le QR Code correspond au compte
            if ($qrCodeData['numero_compte'] !== $compte->numero) {
                return response()->json([
                    'message' => 'Ce QR Code ne correspond pas à ce compte'
                ], 400);
            }

            // Vérifier si l'utilisateur correspond
            if ($qrCodeData['utilisateur']['id'] !== $compte->user->id) {
                return response()->json([
                    'message' => 'Ce QR Code ne correspond pas à cet utilisateur'
                ], 400);
            }

            // Vérifier si c'est le dernier QR Code généré pour ce compte
            if ($compte->qr_code !== $request->qr_code) {
                return response()->json([
                    'message' => 'Ce QR Code n\'est plus valide, un nouveau code a été généré'
                ], 400);
            }

            return response()->json([
                'message' => 'QR Code valide',
                'compte' => [
                    'numero' => $compte->numero,
                    'solde' => $compte->solde,
                    'utilisateur' => [
                        'nom' => $compte->user->nom,
                        'prenom' => $compte->user->prenom,
                        'numero_identite' => $compte->user->numero_identite
                    ]
                ],
                'validite_restante' => Carbon::createFromTimestamp($qrCodeData['expiration'])->diffInSeconds(now()) . ' secondes'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la vérification du QR Code',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}