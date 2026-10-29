<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Rfc\Contracts\RfcDocumentServiceInterface;
use App\Domain\Rfc\DTOs\CreateRfcDocumentDTO;
use App\Domain\Rfc\DTOs\RfcDocumentFilterDTO;
use App\Domain\Rfc\DTOs\UpdateRfcDocumentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreRfcDocumentRequest;
use App\Http\Requests\Api\V1\UpdateRfcDocumentRequest;
use App\Http\Requests\Api\V1\UpdateRfcStatusRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RfcDocumentController extends Controller
{
    public function __construct(
        protected RfcDocumentServiceInterface $service
    ) {}

    /**
     * Listado paginado y con filtros de documentos RFC.
     */
    public function index(Request $request): JsonResponse
    {
        $filter = RfcDocumentFilterDTO::fromArray($request->all());
        $paginated = $this->service->listDocuments($filter);

        return response()->json([
            'status' => 'success',
            'data' => $paginated->items(),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
                'last_page' => $paginated->lastPage(),
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Estadísticas del dashboard de RFCs.
     */
    public function stats(): JsonResponse
    {
        $metrics = $this->service->getDashboardMetrics();

        return response()->json([
            'status' => 'success',
            'data' => $metrics,
        ], Response::HTTP_OK);
    }

    /**
     * Muestra un documento RFC específico.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $document = $this->service->getDocumentById($id);

            return response()->json([
                'status' => 'success',
                'data' => $document,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Documento RFC no encontrado.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Registra un nuevo documento RFC.
     */
    public function store(StoreRfcDocumentRequest $request): JsonResponse
    {
        try {
            $user = $request->user();
            $dto = CreateRfcDocumentDTO::fromArray($request->validated(), $user?->id);
            $document = $this->service->createDocument($dto);

            return response()->json([
                'status' => 'success',
                'message' => "Documento RFC '{$document->code}' creado exitosamente.",
                'data' => $document,
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al crear el documento RFC: ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Actualiza un documento RFC existente.
     */
    public function update(UpdateRfcDocumentRequest $request, int $id): JsonResponse
    {
        try {
            $dto = UpdateRfcDocumentDTO::fromArray($request->validated());
            $document = $this->service->updateDocument($id, $dto);

            return response()->json([
                'status' => 'success',
                'message' => "Documento RFC '{$document->code}' actualizado exitosamente.",
                'data' => $document,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar el documento RFC: ' . $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Elimina lógicamente un documento RFC.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->deleteDocument($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Documento RFC eliminado correctamente.',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al eliminar el documento RFC: ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Cambia el estado del flujo de aprobación del RFC.
     */
    public function changeStatus(UpdateRfcStatusRequest $request, int $id): JsonResponse
    {
        try {
            $user = $request->user();
            $document = $this->service->changeStatus(
                $id,
                $request->input('status'),
                $request->input('notes'),
                $user?->id
            );

            return response()->json([
                'status' => 'success',
                'message' => "Estado de RFC actualizado a '{$document->status}'.",
                'data' => $document,
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar estado del RFC: ' . $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
