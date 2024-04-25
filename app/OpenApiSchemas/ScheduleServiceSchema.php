<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="ScheduleService",
 *     title="ScheduleService",
 *     required={"customer_id","service","scheduled_date","reminder_active"},
 *     description="serviços agendados",
 *     @OA\Property(property="customer_id", type="integer", description="id do consumidor" ,example="1"),
 *     @OA\Property(property="service", type="string", description="serviço", example="Troca de óleto"),
 *     @OA\Property(property="scheduled_date", type="string",description="data de agendamento", example="2024-10-15"),
 *     @OA\Property(property="completion_date", type="string", nullable=true,description="data de realização do serviço" , description="apenas quando for realizado"),
 *     @OA\Property(property="reminder_active", type="boolean", description="alerta ativo" ,example=true),
 *     @OA\Property(property="observation", type="string", nullable=true, description="observações"),
 *     @OA\Property(property="consumer_answer", type="string", nullable=true, description="resposta do cliente"),
 * )
 */
class ScheduleServiceSchema
{}
