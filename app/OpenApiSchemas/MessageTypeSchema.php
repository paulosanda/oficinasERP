<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *      schema="MessageType",
 *      title="MessageType",
 *      required={"model_name", "title"},
 *      description="tipo de mensagem",
 *
 *      @OA\Property(property="schedulable_service_id", type="integer", description="id do tipo de serviços agendável", example="1"),
 *      @OA\Property(property="model_name", type="string", description="modelo de mensagem usado em whatsapp", example="troca_de_oleo"),
 *      @OA\Property(property="title", type="string", description="titulo da mensagem", example="Troca de óleo"),
 *      @OA\Property(property="message", type="string", description="mensagem, não será usada se for whatsapp, pois a mensagem é configurada no whatsapp bussines api", example="Está na hora de fazer a troca de óleo do seu $vechile_model"),
 * )
 */
class MessageTypeSchema {}
