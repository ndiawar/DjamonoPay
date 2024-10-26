<?php

namespace App\Http\Requests\Compte;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Changez cela selon vos besoins d'autorisation
    }

    public function rules(): array
    {
        $compteId = $this->route('compte'); // Récupérer l'ID du compte à partir de la route
        $method = $this->method();

        if ($method === 'PUT') {
            return [
                'user_id' => 'required|exists:users,id',
                'numero' => "required|string|unique:comptes,numero,{$compteId}",
                'solde' => 'required|numeric|min:0',
                'qr_code' => 'nullable|string',
                'est_bloque' => 'boolean',
                'qr_code_creation' => 'nullable|date',
            ];
        } else { // PATCH
            return [
                'user_id' => 'sometimes|required|exists:users,id',
                'numero' => "sometimes|required|string|unique:comptes,numero,{$compteId}",
                'solde' => 'sometimes|required|numeric|min:0',
                'qr_code' => 'sometimes|nullable|string',
                'est_bloque' => 'sometimes|boolean',
                'qr_code_creation' => 'sometimes|nullable|date',
            ];
        }
    }
}
