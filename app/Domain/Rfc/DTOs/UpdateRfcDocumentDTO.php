<?php

namespace App\Domain\Rfc\DTOs;

readonly class UpdateRfcDocumentDTO
{
    public function __construct(
        public ?string $change_name = null,
        public ?string $code = null,
        public ?string $request_date = null,
        public ?string $required_date = null,
        public ?string $requester_name = null,
        public ?string $requester_unit = null,
        public ?string $requester_role = null,
        public ?string $requester_phone = null,
        public ?string $requester_email = null,
        public ?string $manager_name = null,
        public ?string $manager_unit = null,
        public ?string $manager_role = null,
        public ?string $manager_phone = null,
        public ?string $manager_email = null,
        public ?bool $is_scheduled = null,
        public ?string $priority = null,
        public ?string $status = null,
        public ?string $summary_description = null,
        public ?array $risk_assessments = null,
        public ?array $characteristics = null,
        public ?array $work_plan_roles = null,
        public ?array $work_schedule = null,
        public ?string $work_schedule_total_time = null,
        public ?string $work_schedule_observations = null,
        public ?array $acceptance_tests = null,
        public ?string $rollback_plan_description = null,
        public ?string $rollback_criteria = null,
        public ?string $rollback_responsible = null,
        public ?array $rollback_schedule = null,
        public ?string $rollback_total_time = null,
        public ?string $general_observations = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            change_name: $data['change_name'] ?? null,
            code: $data['code'] ?? null,
            request_date: $data['request_date'] ?? null,
            required_date: $data['required_date'] ?? null,
            requester_name: $data['requester_name'] ?? null,
            requester_unit: $data['requester_unit'] ?? null,
            requester_role: $data['requester_role'] ?? null,
            requester_phone: $data['requester_phone'] ?? null,
            requester_email: $data['requester_email'] ?? null,
            manager_name: $data['manager_name'] ?? null,
            manager_unit: $data['manager_unit'] ?? null,
            manager_role: $data['manager_role'] ?? null,
            manager_phone: $data['manager_phone'] ?? null,
            manager_email: $data['manager_email'] ?? null,
            is_scheduled: isset($data['is_scheduled']) ? filter_var($data['is_scheduled'], FILTER_VALIDATE_BOOLEAN) : null,
            priority: isset($data['priority']) ? strtoupper($data['priority']) : null,
            status: $data['status'] ?? null,
            summary_description: $data['summary_description'] ?? null,
            risk_assessments: isset($data['risk_assessments']) && is_array($data['risk_assessments']) ? $data['risk_assessments'] : null,
            characteristics: isset($data['characteristics']) && is_array($data['characteristics']) ? $data['characteristics'] : null,
            work_plan_roles: isset($data['work_plan_roles']) && is_array($data['work_plan_roles']) ? $data['work_plan_roles'] : null,
            work_schedule: isset($data['work_schedule']) && is_array($data['work_schedule']) ? $data['work_schedule'] : null,
            work_schedule_total_time: $data['work_schedule_total_time'] ?? null,
            work_schedule_observations: $data['work_schedule_observations'] ?? null,
            acceptance_tests: isset($data['acceptance_tests']) && is_array($data['acceptance_tests']) ? $data['acceptance_tests'] : null,
            rollback_plan_description: $data['rollback_plan_description'] ?? null,
            rollback_criteria: $data['rollback_criteria'] ?? null,
            rollback_responsible: $data['rollback_responsible'] ?? null,
            rollback_schedule: isset($data['rollback_schedule']) && is_array($data['rollback_schedule']) ? $data['rollback_schedule'] : null,
            rollback_total_time: $data['rollback_total_time'] ?? null,
            general_observations: $data['general_observations'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'change_name' => $this->change_name,
            'code' => $this->code,
            'request_date' => $this->request_date,
            'required_date' => $this->required_date,
            'requester_name' => $this->requester_name,
            'requester_unit' => $this->requester_unit,
            'requester_role' => $this->requester_role,
            'requester_phone' => $this->requester_phone,
            'requester_email' => $this->requester_email,
            'manager_name' => $this->manager_name,
            'manager_unit' => $this->manager_unit,
            'manager_role' => $this->manager_role,
            'manager_phone' => $this->manager_phone,
            'manager_email' => $this->manager_email,
            'is_scheduled' => $this->is_scheduled,
            'priority' => $this->priority,
            'status' => $this->status,
            'summary_description' => $this->summary_description,
            'risk_assessments' => $this->risk_assessments,
            'characteristics' => $this->characteristics,
            'work_plan_roles' => $this->work_plan_roles,
            'work_schedule' => $this->work_schedule,
            'work_schedule_total_time' => $this->work_schedule_total_time,
            'work_schedule_observations' => $this->work_schedule_observations,
            'acceptance_tests' => $this->acceptance_tests,
            'rollback_plan_description' => $this->rollback_plan_description,
            'rollback_criteria' => $this->rollback_criteria,
            'rollback_responsible' => $this->rollback_responsible,
            'rollback_schedule' => $this->rollback_schedule,
            'rollback_total_time' => $this->rollback_total_time,
            'general_observations' => $this->general_observations,
        ], fn ($val) => $val !== null);
    }
}
