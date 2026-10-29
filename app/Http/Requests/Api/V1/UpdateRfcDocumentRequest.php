<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRfcDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id') ?? $this->route('rfc');

        return [
            'change_name' => ['sometimes', 'required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:rfc_documents,code,' . $id],
            'request_date' => ['nullable', 'date'],
            'required_date' => ['nullable', 'date'],
            'requester_name' => ['sometimes', 'required', 'string', 'max:150'],
            'requester_unit' => ['sometimes', 'required', 'string', 'max:100'],
            'requester_role' => ['nullable', 'string', 'max:150'],
            'requester_phone' => ['nullable', 'string', 'max:50'],
            'requester_email' => ['nullable', 'email', 'max:150'],
            'manager_name' => ['sometimes', 'required', 'string', 'max:150'],
            'manager_unit' => ['sometimes', 'required', 'string', 'max:100'],
            'manager_role' => ['nullable', 'string', 'max:150'],
            'manager_phone' => ['nullable', 'string', 'max:50'],
            'manager_email' => ['nullable', 'email', 'max:150'],
            'is_scheduled' => ['nullable', 'boolean'],
            'priority' => ['nullable', 'in:ALTA,MEDIA,BAJA'],
            'status' => ['nullable', 'in:borrador,pendiente,aprobado,rechazado,en_progreso,ejecutado,cerrado'],
            'summary_description' => ['nullable', 'string'],
            'risk_assessments' => ['nullable', 'array'],
            'characteristics' => ['nullable', 'array'],
            'work_plan_roles' => ['nullable', 'array'],
            'work_schedule' => ['nullable', 'array'],
            'work_schedule_total_time' => ['nullable', 'string', 'max:100'],
            'work_schedule_observations' => ['nullable', 'string'],
            'acceptance_tests' => ['nullable', 'array'],
            'rollback_plan_description' => ['nullable', 'string'],
            'rollback_criteria' => ['nullable', 'string'],
            'rollback_responsible' => ['nullable', 'string', 'max:150'],
            'rollback_schedule' => ['nullable', 'array'],
            'rollback_total_time' => ['nullable', 'string', 'max:100'],
            'general_observations' => ['nullable', 'string'],
        ];
    }
}
