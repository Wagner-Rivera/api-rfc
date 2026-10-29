<?php

namespace Database\Seeders;

use App\Models\RfcDocument;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RfcDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rfcData = [
            'code' => 'RFC-2026-0001',
            'change_name' => 'Mejora Stock (Middleware Shopify)',
            'request_date' => Carbon::createFromFormat('d-m-Y', '06-01-2026')->setTime(9, 0, 0),
            'required_date' => Carbon::createFromFormat('d-m-Y', '07-01-2026')->setTime(18, 0, 0),

            // 1.1 Solicitante
            'requester_name' => 'Wagner Rivera',
            'requester_unit' => 'TI',
            'requester_role' => 'Analista de Desarrollo e Integraciones',
            'requester_phone' => '+56 9 1234 5678',
            'requester_email' => 'wagner.rivera@dorel.cl',

            // 1.1 Responsable
            'manager_name' => 'Jennifer Victoria Perez Aedo',
            'manager_unit' => 'TI',
            'manager_role' => 'Gerente TI LATAM',
            'manager_phone' => '+56 9 8765 4321',
            'manager_email' => 'jennifer.perez@dorel.cl',

            // 1.2 Tipo y Prioridad
            'is_scheduled' => true,
            'priority' => 'ALTA',
            'status' => 'aprobado',

            // 1.3 Descripción resumida
            'summary_description' => "• Respaldo de servidores 10.21.0.85 y 10.21.0.121\n• Respaldo de Base de datos\n• Instalar Docker Compose v2\n• Configuración de los contenedores Ordenes, Stock, Precio, Fulfillment, Ordenes no Inyectadas y Transacciones de Vera\n• Apagar el servicio de Nginx\n• Levantar los contenedores\n• Desinstalar Nginx dentro del servidor",

            // 1.4 Análisis de Riesgos/Impacto/Mitigación
            'risk_assessments' => [
                [
                    'factor' => 'Funcional',
                    'initial_risk' => 'Bajo',
                    'probability' => 'Bajo',
                    'impact' => 'Alto',
                    'mitigation' => 'Respaldos integrales de bases de datos y validación de endpoints de inyección',
                    'final_risk' => 'Alto',
                ],
                [
                    'factor' => 'Operacional',
                    'initial_risk' => 'Bajo',
                    'probability' => 'Bajo',
                    'impact' => 'Alto',
                    'mitigation' => 'Ventana nocturna de mantenimiento y plan de rollback inmediato documentado',
                    'final_risk' => 'Alto',
                ],
            ],

            // 1.5 Características del cambio
            'characteristics' => [
                'requires_other_areas_approval' => [
                    'answer' => true,
                    'observation' => 'Afecta equipos y servicios comunes de sincronización e inyección.',
                ],
                'involves_service_cutoff' => [
                    'answer' => false,
                    'observation' => 'No contempla corte de servicios a usuarios finales.',
                ],
                'risk_service_interruption' => [
                    'answer' => false,
                    'observation' => 'Contenedores se alternan en caliente minimizando latencia.',
                ],
                'affects_user_services_notice' => [
                    'answer' => false,
                    'observation' => 'No requiere comunicación masiva por ejecutarse fuera de horario pico.',
                ],
                'urgent_less_24h' => [
                    'answer' => false,
                    'observation' => 'Planificación formal acorde a estándar corporativo.',
                ],
                'normal_office_hours_risk' => [
                    'answer' => false,
                    'observation' => 'Sin impacto durante la jornada laboral.',
                ],
            ],

            // 2.1 Roles, Responsabilidades y Escalamientos
            'work_plan_roles' => [
                [
                    'company' => 'DOREL',
                    'name' => 'WAGNER RIVERA',
                    'contact' => 'Wagner.rivera@dorel.cl',
                    'role' => 'Analista Desarrollo',
                    'responsibility' => 'Ejecutor',
                    'escalation' => 'Jennifer Victoria Perez Aedo',
                ],
                [
                    'company' => 'DOREL',
                    'name' => 'Jennifer Victoria Perez Aedo',
                    'contact' => 'jennifer.perez@dorel.cl',
                    'role' => 'GERENTE DE TI',
                    'responsibility' => 'Autorizador',
                    'escalation' => 'GUSTAVO COIMBRA',
                ],
            ],

            // 2.2 Cronograma de Actividades
            'work_schedule' => [
                [
                    'sequence' => 1,
                    'detail' => 'Realizar respaldo de los servidores involucrados',
                    'responsible' => 'Manuel',
                    'date' => '05-05-2026',
                    'estimated_time' => '30m',
                    'start_time' => '22:00',
                    'end_time' => '22:30',
                ],
                [
                    'sequence' => 2,
                    'detail' => 'Agregar nuevo dominio al proxy de Trans',
                    'responsible' => 'Manuel',
                    'date' => '05-05-2026',
                    'estimated_time' => '20m',
                    'start_time' => '22:30',
                    'end_time' => '22:50',
                ],
                [
                    'sequence' => 3,
                    'detail' => 'Desactivar el cron actualmente corriendo',
                    'responsible' => 'Wagner',
                    'date' => '05-05-2026',
                    'estimated_time' => '10m',
                    'start_time' => '22:50',
                    'end_time' => '23:00',
                ],
                [
                    'sequence' => 4,
                    'detail' => 'Se debe realizar un git clone de los aplicativos',
                    'responsible' => 'Wagner',
                    'date' => '05-05-2026',
                    'estimated_time' => '20m',
                    'start_time' => '23:00',
                    'end_time' => '23:20',
                ],
                [
                    'sequence' => 5,
                    'detail' => 'Configuración de nueva estructura de los contenedores Docker dentro del servidor',
                    'responsible' => 'Wagner',
                    'date' => '05-05-2026',
                    'estimated_time' => '1h',
                    'start_time' => '23:20',
                    'end_time' => '00:20',
                ],
                [
                    'sequence' => 6,
                    'detail' => 'Activar nuevamente el cron (Pendiente Transacciones de Veras)',
                    'responsible' => 'Wagner',
                    'date' => '05-05-2026',
                    'estimated_time' => '15m',
                    'start_time' => '00:20',
                    'end_time' => '00:35',
                ],
                [
                    'sequence' => 7,
                    'detail' => 'Cambios de la interfaz para el nuevo portal de Stock a nivel Front como la nueva lógica de carga file de img de sku',
                    'responsible' => 'Wagner',
                    'date' => '05-05-2026',
                    'estimated_time' => '1h',
                    'start_time' => '00:35',
                    'end_time' => '01:35',
                ],
                [
                    'sequence' => 8,
                    'detail' => 'Apagar los otros servidores de Stock y Fulfillment',
                    'responsible' => 'Wagner',
                    'date' => '05-05-2026',
                    'estimated_time' => '15m',
                    'start_time' => '01:35',
                    'end_time' => '01:50',
                ],
                [
                    'sequence' => 9,
                    'detail' => 'Apagar los servicios de http correspondiente de Ordenes, Stock y Fulfillment',
                    'responsible' => 'Manuel',
                    'date' => '05-05-2026',
                    'estimated_time' => '10m',
                    'start_time' => '01:50',
                    'end_time' => '02:00',
                ],
            ],
            'work_schedule_total_time' => '4 horas',
            'work_schedule_observations' => 'Todas las actividades se realizarán en ventana controlada de 22:00 a 02:00 hrs.',

            // 2.3 Pruebas de aceptación
            'acceptance_tests' => [
                [
                    'test' => 'Verificación de respaldos y conectividad de base de datos',
                    'responsible' => 'Manuel',
                    'accepted' => 'si',
                    'comments' => 'Respaldos íntegros comprobados',
                ],
                [
                    'test' => 'Levantamiento y validación de contenedores Docker Compose v2',
                    'responsible' => 'Wagner',
                    'accepted' => 'si',
                    'comments' => 'Contenedores en estado Running y saludables',
                ],
                [
                    'test' => 'Prueba de sincronización de Stock y Carga de Catálogo en Front',
                    'responsible' => 'Wagner',
                    'accepted' => 'si',
                    'comments' => 'Validación de endpoints exitosa',
                ],
            ],

            // 2.4 y 2.5 Plan de Retorno
            'rollback_plan_description' => 'Restaura los servidores a como estaban previamente, levantando Nginx y revirtiendo la configuración de proxy.',
            'rollback_criteria' => 'Falla de conectividad prolongada o indisponibilidad en los servicios de pedidos e inventario superior a 30 minutos.',
            'rollback_responsible' => 'Wagner Rivera / Manuel',
            'rollback_schedule' => [
                [
                    'sequence' => 1,
                    'detail' => 'Restaura los servidores a como estaba',
                    'responsible' => 'Manuel / Wagner',
                    'date' => '05-05-2026',
                    'estimated_time' => '5min',
                    'start_time' => '',
                    'end_time' => '',
                ],
            ],
            'rollback_total_time' => '5min',

            // 2.6 Observaciones Generales
            'general_observations' => 'Solo involucra cambio de configuración en perfiles de seguridad. No existen riesgos asociados.',
            'approved_at' => Carbon::createFromFormat('d-m-Y', '06-01-2026')->setTime(15, 30, 0),
        ];

        RfcDocument::updateOrCreate(
            ['code' => $rfcData['code']],
            $rfcData
        );
    }
}
