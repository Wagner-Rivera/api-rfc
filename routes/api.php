<?php

use App\Http\Controllers\Api\V1\RfcDocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - api-rfc
|--------------------------------------------------------------------------
|
| Microservicio encargado del Control de Documentos y Solicitudes de Cambio (RFC)
| según la normativa corporativa de Dorel Industries.
|
*/

// Health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'api-rfc',
        'version' => '1.0.0',
        'timestamp' => now()->toIso8601String(),
    ]);
});

// Rutas API v1
Route::prefix('v1')->middleware(['auth.api'])->group(function () {
    // Métricas y estadísticas de RFCs
    Route::get('/rfcs/stats', [RfcDocumentController::class, 'stats']);

    // Flujo de estados de RFC
    Route::patch('/rfcs/{id}/status', [RfcDocumentController::class, 'changeStatus']);

    // CRUD de documentos RFC
    Route::apiResource('rfcs', RfcDocumentController::class);
});
