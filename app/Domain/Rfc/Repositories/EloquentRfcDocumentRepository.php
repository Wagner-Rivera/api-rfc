<?php

namespace App\Domain\Rfc\Repositories;

use App\Domain\Rfc\Contracts\RfcDocumentRepositoryInterface;
use App\Domain\Rfc\DTOs\RfcDocumentFilterDTO;
use App\Models\RfcDocument;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EloquentRfcDocumentRepository implements RfcDocumentRepositoryInterface
{
    public function getPaginated(RfcDocumentFilterDTO $filter): LengthAwarePaginator
    {
        $query = RfcDocument::query();

        if ($filter->search) {
            $query->search($filter->search);
        }

        if ($filter->status) {
            $query->byStatus($filter->status);
        }

        if ($filter->priority) {
            $query->byPriority($filter->priority);
        }

        if ($filter->is_scheduled !== null) {
            $query->where('is_scheduled', $filter->is_scheduled);
        }

        if ($filter->start_date) {
            $query->whereDate('request_date', '>=', $filter->start_date);
        }

        if ($filter->end_date) {
            $query->whereDate('request_date', '<=', $filter->end_date);
        }

        $query->orderBy($filter->sort_by, $filter->sort_direction);

        return $query->paginate($filter->per_page);
    }

    public function getAll(RfcDocumentFilterDTO $filter): Collection
    {
        $query = RfcDocument::query();

        if ($filter->search) {
            $query->search($filter->search);
        }

        if ($filter->status) {
            $query->byStatus($filter->status);
        }

        if ($filter->priority) {
            $query->byPriority($filter->priority);
        }

        return $query->orderBy($filter->sort_by, $filter->sort_direction)->get();
    }

    public function findById(int $id): RfcDocument
    {
        return RfcDocument::findOrFail($id);
    }

    public function findByCode(string $code): ?RfcDocument
    {
        return RfcDocument::where('code', $code)->first();
    }

    public function create(array $data): RfcDocument
    {
        return RfcDocument::create($data);
    }

    public function update(int $id, array $data): RfcDocument
    {
        $document = $this->findById($id);
        $document->update($data);
        return $document->fresh();
    }

    public function delete(int $id): bool
    {
        $document = $this->findById($id);
        return (bool) $document->delete();
    }

    public function getNextCorrelativeNumber(int $year): int
    {
        // Contar RFCs del año actual para correlativo
        $prefix = "RFC-{$year}-%";
        $count = RfcDocument::where('code', 'like', $prefix)->count();
        return $count + 1;
    }

    public function getStatistics(): array
    {
        $total = RfcDocument::count();
        $draft = RfcDocument::where('status', 'borrador')->count();
        $pending = RfcDocument::where('status', 'pendiente')->count();
        $approved = RfcDocument::where('status', 'aprobado')->count();
        $inProgress = RfcDocument::where('status', 'en_progreso')->count();
        $executed = RfcDocument::where('status', 'ejecutado')->count();
        $rejected = RfcDocument::where('status', 'rechazado')->count();
        $closed = RfcDocument::where('status', 'cerrado')->count();

        $highPriority = RfcDocument::where('priority', 'ALTA')->count();
        $scheduled = RfcDocument::where('is_scheduled', true)->count();
        $unscheduled = RfcDocument::where('is_scheduled', false)->count();

        return [
            'total' => $total,
            'draft' => $draft,
            'pending' => $pending,
            'approved' => $approved,
            'in_progress' => $inProgress,
            'executed' => $executed,
            'rejected' => $rejected,
            'closed' => $closed,
            'high_priority' => $highPriority,
            'scheduled' => $scheduled,
            'unscheduled' => $unscheduled,
        ];
    }
}
