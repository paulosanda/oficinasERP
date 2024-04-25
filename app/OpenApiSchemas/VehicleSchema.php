<?php

namespace App\OpenApiSchemas;

/**
 *@OA\Schema(
 *     schema="vehicle",
 *     title="Vehicle",
 *     required={"customer_id", "plate"},
 *     description="dados do veículo",
 *     @OA\Property(property="customer_id", type="integer", description="id do customer"),
 *     @OA\Property(property="brand", type="string", nullable=true, description="marca do veículo"),
 *     @OA\Property(property="model", type="string", nullable=true, description="modelo do veículo"),
 *     @OA\Property(property="color", type="string", nullable=true, description="cor do veículo"),
 *     @OA\Property(property="year", type="string", nullable=true, description="ano do veículo"),
 *     @OA\Property(property="plate", type="string", description="placa do veículo"),
 *     @OA\Property(property="identification_number", type="string", nullable=true, description="numero do chassi do veículo"),
 *     @OA\Property(property="renavam", type="string", nullable=true, description="renavam do veículo"),
 *     @OA\Property(property="monthly_mileage", type="string", nullable=true, description="média de km rodados por mês pelo veículo"),
 *     @OA\Property(property="observation", type="string", nullable=true, description="observações para o cadastro do veículo"),
 *)
 */
class VehicleSchema
{
}
