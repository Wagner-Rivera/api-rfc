<?php

namespace App\Domain\Rfc\Contracts;

use App\Domain\Rfc\DTOs\RfcDocumentFilterDTO;
use App\Models\RfcDocument;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RfcDocumentRepositoryInterface
{
    /**
     * Obtiene lista paginada y filtrada de documentos RFC.
     */
    public function getPaginated(RfcDocumentFilterDTO $filter): LengthAwarePaginator;

    /**
     * Obtiene todos los documentos RFC sin paginación (para reportes/exportaciones).
     */
    public function getAll(RfcDocumentFilterDTO $filter): Collection;

    /**
     * Busca un documento RFC por su ID o lanza ModelNotFoundException.
     */
    public function findById(int $id): RfcDocument;

    /**
     * Busca un documento RFC por su código oficial.
     */
    public function findByCode(string $code): ?RfcDocument;

    /**
     * Persiste un nuevo documento RFC en la base de datos.
     */
    public function create(array $data): RfcDocument;

    /**
     * Actualiza los datos de un documento RFC existente.
     */
    public function update(int $id, array $data): RfcDocument;

    /**
     * Elimina lógicamente un documento RFC.
     */
    public function delete(int $id): bool;

    /**
     * Obtiene el total correlativo para generar el siguiente código RFC del año.
     */
    public function getNextCorrelativeNumber(int $year): int;

    /**
     * Obtiene las métricas generales de documentos RFC.
     */
    public function getStatistics(): array;
}
