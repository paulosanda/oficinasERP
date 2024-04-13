<?php

namespace App\OpenApiSchemas;

/**
 *@OA\Schema(
 *     schema="vehicle",
 *     title="Vehicle",
 *     required={"customer_id", "placa"},
 *     description="dados do veículo",
 *     @OA\Property(property="customer_id", type="integer", description="id do customer"),
 *     @OA\Property(property="marca", type="string", nullable=true, description="marca do veículo"),
 *     @OA\Property(property="modelo", type="string", nullable=true, description="modelo do veículo"),
 *     @OA\Property(property="cor", type="string", nullable=true, description="cor do veículo"),
 *     @OA\Property(property="ano", type="string", nullable=true, description="ano do veículo"),
 *     @OA\Property(property="placa", type="string", description="placa do veículo"),
 *     @OA\Property(property="numero_chassi", type="string", nullable=true, description="numero do chassi do veículo"),
 *     @OA\Property(property="renavam", type="string", nullable=true, description="renavam do veículo"),
 *     @OA\Property(property="media_mensal_km_rodado", type="string", nullable=true, description="média de km rodados por mês pelo veículo"),
 *     @OA\Property(property="observacoes", type="string", nullable=true, description="observações para o cadastro do veículo"),
 *)
 */
class VehicleSchema
{
}
