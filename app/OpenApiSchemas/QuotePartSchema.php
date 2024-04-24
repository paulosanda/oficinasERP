<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="QuotePart",
 *     title="QuotePart",
 *     description="peças do orçamento",
 *     required={"codigo_do_produto","descricao","quantidade","valor","sub_total"},
 *     @OA\Property(property="codigo_do_produto", type="string", example="549"),
 *     @OA\Property(property="descricao", type="string", example="Rolamento do cambio"),
 *     @OA\Property(property="quantidade", type="integer", example="1"),
 *     @OA\Property(property="valor", type="string", example="230"),
 *     @OA\Property(property="desconto", type="string", example="0"),
 *     @OA\Property(property="sub_total", type="string", example="230")
 * )
 */
class QuotePartSchema
{}
