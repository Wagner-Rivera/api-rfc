<?php

namespace App\Domain\Rfc\DTOs;

readonly class RfcDocumentFilterDTO
{
    public function __construct(
        public ?string $search = null,
        public ?string $status = null,
        public ?string $priority = null,
        public ?bool $is_scheduled = null,
        public ?string $start_date = null,
        public ?string $end_date = null,
        public int $per_page = 15,
        public string $sort_by = 'id',
        public string $sort_direction = 'desc'
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            search: $data['search'] ?? null,
            status: $data['status'] ?? null,
            priority: $data['priority'] ?? null,
            is_scheduled: isset($data['is_scheduled']) ? filter_var($data['is_scheduled'], FILTER_VALIDATE_BOOLEAN) : null,
            start_date: $data['start_date'] ?? null,
            end_date: $data['end_date'] ?? null,
            per_page: isset($data['per_page']) ? (int) $data['per_page'] : 15,
            sort_by: $data['sort_by'] ?? 'id',
            sort_direction: strtolower($data['sort_direction'] ?? 'desc') === 'asc' ? 'asc' : 'desc'
        );
    }
}
