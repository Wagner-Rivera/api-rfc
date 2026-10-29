<?php

namespace App\Domain\Rfc\Contracts;

use App\Domain\Rfc\DTOs\CreateRfcDocumentDTO;
use App\Domain\Rfc\DTOs\RfcDocumentFilterDTO;
use App\Domain\Rfc\DTOs\UpdateRfcDocumentDTO;
use App\Models\RfcDocument;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RfcDocumentServiceInterface
{
    /**
     * Lista los documentos RFC aplicando filtros y paginación.
     */
    public function listDocuments(RfcDocumentFilterDTO $filter): LengthAwarePaginator;

    /**
     * Obtiene el detalle completo de un documento RFC por ID.
     */
    public function getDocumentById(int $id): RfcDocument;

    /**
     * Registra un nuevo documento RFC generando automáticamente su correlativo oficial.
     */
    public function createDocument(CreateRfcDocumentDTO $dto): RfcDocument;

    /**
     * Modifica un documento RFC existente validando las reglas de negocio.
     */
    public function updateDocument(int $id, UpdateRfcDocumentDTO $dto): RfcDocument;

    /**
     * Elimina un documento RFC.
     */
    public function deleteDocument(int $id): bool;

    /**
     * Cambia el estado de un documento RFC en el flujo de aprobación / ejecución.
     */
    public function changeStatus(int $id, string $status, ?string $notes = null, ?int $userId = null): RfcDocument;

    /**
     * Obtiene estadísticas y métricas ejecutivas de documentos RFC.
     */
    public function getDashboardMetrics(): array;
}
