<?php

namespace App\Http\Requests\SystemLogger;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSystemLoggerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Changez cela selon vos besoins d'autorisation
    }

    public function rules(): array
    {
        $loggerId = $this->route('system_logger'); // Récupérer l'ID du logger à partir de la route
        $method = $this->method();

        if ($method === 'PUT') {
            return [
                'action' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ];
        } else { // PATCH
            return [
                'action' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string|max:255',
            ];
        }
    }
}
