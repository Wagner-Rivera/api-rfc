<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rfc_documents', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g. RFC-2026-0001
            $table->string('change_name'); // Nombre del cambio
            $table->dateTime('request_date')->nullable(); // Fecha/hora solicitud
            $table->dateTime('required_date')->nullable(); // Fecha/hora requerida

            // Solicitante (1.1)
            $table->string('requester_name');
            $table->string('requester_unit')->default('TI');
            $table->string('requester_role')->nullable();
            $table->string('requester_phone')->nullable();
            $table->string('requester_email')->nullable();

            // Responsable del cambio (1.1)
            $table->string('manager_name');
            $table->string('manager_unit')->default('TI');
            $table->string('manager_role')->nullable();
            $table->string('manager_phone')->nullable();
            $table->string('manager_email')->nullable();

            // Tipo de Cambio y Prioridad (1.2)
            $table->boolean('is_scheduled')->default(true); // 1 = Programado, 0 = No programado
            $table->enum('priority', ['ALTA', 'MEDIA', 'BAJA'])->default('ALTA');
            $table->string('status', 30)->default('borrador'); // borrador, pendiente, aprobado, rechazado, en_progreso, ejecutado, cerrado

            // Descripción resumida del cambio y justificación (1.3)
            $table->text('summary_description')->nullable();

            // Análisis de Riesgos/Impacto/Mitigación (1.4)
            $table->json('risk_assessments')->nullable();

            // Características del cambio (1.5)
            $table->json('characteristics')->nullable();

            // Plan de Trabajo - Roles y Escalamiento (2.1)
            $table->json('work_plan_roles')->nullable();

            // Cronograma de Actividades (2.2)
            $table->json('work_schedule')->nullable();
            $table->string('work_schedule_total_time')->nullable();
            $table->text('work_schedule_observations')->nullable();

            // Pruebas de aceptación del cambio (2.3)
            $table->json('acceptance_tests')->nullable();

            // Plan de Retorno / Rollback (2.4)
            $table->text('rollback_plan_description')->nullable();
            $table->text('rollback_criteria')->nullable();
            $table->string('rollback_responsible')->nullable();

            // Cronograma de Actividades del Plan de Retorno (2.5)
            $table->json('rollback_schedule')->nullable();
            $table->string('rollback_total_time')->nullable();

            // Observaciones Generales de Implementación (2.6)
            $table->text('general_observations')->nullable();

            // Auditoría y Aprobaciones
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfc_documents');
    }
};
