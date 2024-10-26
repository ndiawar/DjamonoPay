<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Changez cela selon vos besoins d'autorisation
    }

    public function rules(): array
    {
        $transactionId = $this->route('transaction'); // Récupérer l'ID de la transaction à partir de la route
        $method = $this->method();

        if ($method === 'PUT') {
            return [
                'user_id' => 'required|exists:users,id',
                'distributeur_id' => 'nullable|exists:users,id',
                'type' => 'required|in:depot,retrait,transfert,annulé',
                'montant' => 'required|numeric|min:0',
                'frais' => 'nullable|numeric|min:0',
                'commission' => 'nullable|numeric|min:0',
                'etat' => 'required|string',
                'motif' => 'nullable|string|max:255',
            ];
        } else { // PATCH
            return [
                'user_id' => 'sometimes|required|exists:users,id',
                'distributeur_id' => 'sometimes|nullable|exists:users,id',
                'type' => 'sometimes|required|in:depot,retrait,transfert,annulé',
                'montant' => 'sometimes|required|numeric|min:0',
                'frais' => 'sometimes|nullable|numeric|min:0',
                'commission' => 'sometimes|nullable|numeric|min:0',
                'etat' => 'sometimes|required|string',
                'motif' => 'sometimes|nullable|string|max:255',
            ];
        }
    }
}
