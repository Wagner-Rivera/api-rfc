<?php

namespace App\Domain\Rfc\Services;

use App\Domain\Rfc\Contracts\RfcDocumentRepositoryInterface;
use App\Domain\Rfc\Contracts\RfcDocumentServiceInterface;
use App\Domain\Rfc\DTOs\CreateRfcDocumentDTO;
use App\Domain\Rfc\DTOs\RfcDocumentFilterDTO;
use App\Domain\Rfc\DTOs\UpdateRfcDocumentDTO;
use App\Models\RfcDocument;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

class RfcDocumentService implements RfcDocumentServiceInterface
{
    public function __construct(
        protected RfcDocumentRepositoryInterface $repository
    ) {}

    public function listDocuments(RfcDocumentFilterDTO $filter): LengthAwarePaginator
    {
        return $this->repository->getPaginated($filter);
    }

    public function getDocumentById(int $id): RfcDocument
    {
        return $this->repository->findById($id);
    }

    public function createDocument(CreateRfcDocumentDTO $dto): RfcDocument
    {
        $data = $dto->toArray();

        // Generar código oficial si no fue suministrado
        if (empty($data['code'])) {
            $year = Carbon::now()->year;
            $nextNumber = $this->repository->getNextCorrelativeNumber($year);
            $data['code'] = sprintf('RFC-%d-%04d', $year, $nextNumber);
        }

        // Si no tiene fecha de solicitud, colocar ahora
        if (empty($data['request_date'])) {
            $data['request_date'] = Carbon::now();
        }

        // Si se crea en estado 'aprobado', registrar timestamp
        if ($data['status'] === 'aprobado') {
            $data['approved_at'] = Carbon::now();
        }

        return $this->repository->create($data);
    }

    public function updateDocument(int $id, UpdateRfcDocumentDTO $dto): RfcDocument
    {
        $existing = $this->repository->findById($id);

        if ($existing->status === 'cerrado') {
            throw new InvalidArgumentException("No se puede editar un documento RFC cerrado.");
        }

        $data = $dto->toArray();

        if (isset($data['status']) && $data['status'] === 'aprobado' && !$existing->approved_at) {
            $data['approved_at'] = Carbon::now();
        }

        return $this->repository->update($id, $data);
    }

    public function deleteDocument(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function changeStatus(int $id, string $status, ?string $notes = null, ?int $userId = null): RfcDocument
    {
        $allowedStatuses = ['borrador', 'pendiente', 'aprobado', 'rechazado', 'en_progreso', 'ejecutado', 'cerrado'];

        if (!in_array($status, $allowedStatuses, true)) {
            throw new InvalidArgumentException("Estado '{$status}' no es válido para el flujo de RFC.");
        }

        $updateData = ['status' => $status];

        if ($status === 'aprobado') {
            $updateData['approved_at'] = Carbon::now();
            if ($userId) {
                $updateData['approved_by'] = $userId;
            }
        }

        if ($notes) {
            $existing = $this->repository->findById($id);
            $currentObs = $existing->general_observations ? $existing->general_observations . "\n\n" : '';
            $dateStr = Carbon::now()->format('Y-m-d H:i:s');
            $updateData['general_observations'] = $currentObs . "[{$dateStr}] Cambio a estado '{$status}': {$notes}";
        }

        return $this->repository->update($id, $updateData);
    }

    public function getDashboardMetrics(): array
    {
        return $this->repository->getStatistics();
    }
}
