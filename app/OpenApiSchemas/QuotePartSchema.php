<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="QuotePart",
 *     title="QuotePart",
 *     description="peças do orçamento",
 *     required={"part_code","description","quantity","value","subtotal"},
 *
 *     @OA\Property(property="part_code", type="string", description="código da peça ou do produto" ,example="549"),
 *     @OA\Property(property="description", type="string", description="descrição" ,example="Rolamento do cambio"),
 *     @OA\Property(property="quantity", type="integer", description="quantidade", example="1"),
 *     @OA\Property(property="value", type="string", description="valor" ,example="230"),
 *     @OA\Property(property="desconto", type="string", description="desconto" ,example="0"),
 *     @OA\Property(property="subtotal", type="string", description="sub total" , example="230")
 * )
 */
class QuotePartSchema {}
