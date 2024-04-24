<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="Quote",
 *     title="Quote",
 *     description="dados para orçamento",
 *     required={"customer_id", "vehicle_id", "data_de_entrada", "descricao_do_problema", "sub_total_servico","sub_total_produto","total_bruto","total_liquido", "total"},
 *     @OA\Property(property="customer_id", type="integer", example="1009"),
 *     @OA\Property(property="vehicle_id", type="integer", example="243"),
 *     @OA\Property(property="data_de_entrada", type="string", example="2024-03-15"),
 *     @OA\Property(property="data_de_saida", type="string", nullable=true),
 *     @OA\Property(property="descricao_do_problema", type="string", nullable=true),
 *     @OA\Property(property="laudo", type="string", nullable=true),
 *     @OA\Property(property="observacao", type="string", nullable=true),
 *     @OA\Property(property="sub_total_servico", type="string", example="300"),
 *     @OA\Property(property="sub_total_produto", type="string", example="899,80"),
 *     @OA\Property(property="total_bruto", type="string", example="1199,80"),
 *     @OA\Property(property="desconto", type="string", example="0"),
 *     @OA\Property(property="total_liquido", type="string", example="1199,80"),
 *     @OA\Property(property="total", type="string", example="1199,80"),
 *     @OA\Property(
 *         property="quote_service",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/QuoteService")
 *     ),
 *     @OA\Property(
 *         property="quote_part",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/QuotePart")
 *     )
 * )
 */
class QuoteSchema
{}
