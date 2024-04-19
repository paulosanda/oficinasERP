<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="ScheduleService",
 *     title="ScheduleService",
 *     required={"customer_id","servico","data_prevista","lembrete_ativo"},
 *     description="serviços agendados",
 *     @OA\Property(property="customer_id", type="integer", example="1"),
 *     @OA\Property(property="servico", type="string", example="Troca de óleto"),
 *     @OA\Property(property="data_prevista", type="string", example="2024-10-15"),
 *     @OA\Property(property="data_realizado", type="string", nullable=true, description="apenas quando for realizado"),
 *     @OA\Property(property="lembrete_ativo", type="boolean", example=true),
 *     @OA\Property(property="observacao", type="string", nullable=true),
 *     @OA\Property(property="resposta", type="string", nullable=true),
 * )
 */
class ScheduleServiceSchema
{}
