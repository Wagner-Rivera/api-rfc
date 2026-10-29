<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRfcStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:borrador,pendiente,aprobado,rechazado,en_progreso,ejecutado,cerrado'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
