<?php

namespace App\OpenApiSchemas;


/**
 * @OA\Schema(
 *     schema="ScheduleService",
 *     title="ScheduleService",
 *     description="dados do serviço agendado",
 *     @OA\Property(property="id", type="integer", description="id", example="1"),
 *     @OA\Property(property="vehicle_id", type="integer", description="vehicle_id", example="1"),
 *     @OA\Property(property="company_id", type="integer", description="company_id", example="1"),
 *     @OA\Property(property="customer_id", type="integer", description="customer_id", example="1"),
 *     @OA\Property(property="schedulable_service_id", type="integer", description="schedulable_service_id", example="1"),
 *     @OA\Property(property="scheduled_date", type="string", description="data do agendamento", example="2024-05-01"),
 *     @OA\Property(property="completion_date", type="string", description="data realização", nullable=true, example="2024-05-05"),
 *     @OA\Property(property="reminder_active", type="boolean", description="lembrete ativo", example="true"),
 *     @OA\Property(property="observation", type="string", description="observações", nullable=true, example="true"),
 *     @OA\Property(property="customer_answer", type="string", description="resposta do customer", nullable=true),
 *     @OA\Property(property="company", ref="#/components/schemas/Company")),
 *     @OA\Property(property="customer", ref="#/components/schemas/Customer")),
 *     @OA\Property(property="schedulable_service", ref="#/components/schemas/SchedulableService"))
 * )
 */
class ScheduleServiceSchema
{}

/**
 * @OA\Schema(
 *     schema="BodyRequestScheduleService",
 *     title="BodyRequestScheduleService",
 *     required={"customer_id","schedulable_service_id","vehicle_id","scheduled_date","reminder_active"},
 *     description="serviços agendados",
 *     @OA\Property(property="vehicle_id", type="integer", description="vehicle_id", example="1"),
 *     @OA\Property(property="customer_id", type="integer", description="id do consumidor" ,example="1"),
 *     @OA\Property(property="schedulable_service_id", type="integer", description="serviço", example="1"),
 *     @OA\Property(property="scheduled_date", type="string",description="data de agendamento", example="2024-10-15"),
 *     @OA\Property(property="completion_date", type="string", nullable=true,description="data de realização do serviço" , description="apenas quando for realizado"),
 *     @OA\Property(property="reminder_active", type="boolean", description="alerta ativo" ,example=true),
 *     @OA\Property(property="observation", type="string", nullable=true, description="observações"),
 *     @OA\Property(property="customer_answer", type="string", nullable=true, description="resposta do cliente"),
 * )
 */
class BodyRequestScheduleServiceSchema
{}
