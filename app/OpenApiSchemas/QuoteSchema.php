<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="Quote",
 *     title="Quote",
 *     description="dados para orçamento",
 *     required={"customer_id", "vehicle_id", "entry_date", "problem_description", "subtotal_service","subtotal_part","gross_total","net_total", "total"},
 *
 *     @OA\Property(property="customer_id", type="integer",description="id do consumidor", example="1009"),
 *     @OA\Property(property="vehicle_id", type="integer", description="id do veículo", example="243"),
 *     @OA\Property(property="entry_date", type="string", description="data de entrada do veículo", example="2024-03-15"),
 *     @OA\Property(property="exit_date", type="string", nullable=true, description="data de saída do veículo"),
 *     @OA\Property(property="problem_description", type="string", nullable=true, description="descrição do problema"),
 *     @OA\Property(property="report", type="string", nullable=true, description="laudo"),
 *     @OA\Property(property="observation", type="string", nullable=true, description="observação"),
 *     @OA\Property(property="subtotal_service", type="string", example="300", description="sub total de serviço"),
 *     @OA\Property(property="subtotal_part", type="string", example="899,80", description="sub total de peças e produtos"),
 *     @OA\Property(property="gross_total", type="string", example="1199,80", description="total bruto"),
 *     @OA\Property(property="discount", type="string", example="0", description="desconto"),
 *     @OA\Property(property="net_total", type="string", example="1199,80", description="total líquido"),
 *     @OA\Property(property="total", type="string", example="1199,80", description="total"),
 *     @OA\Property(
 *         property="quote_service",
 *         type="array",
 *
 *         @OA\Items(ref="#/components/schemas/QuoteService")
 *     ),
 *
 *     @OA\Property(
 *         property="quote_part",
 *         type="array",
 *
 *         @OA\Items(ref="#/components/schemas/QuotePart")
 *     )
 * )
 */
class QuoteSchema {}
