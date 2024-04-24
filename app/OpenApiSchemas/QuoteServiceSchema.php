<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="QuoteService",
 *     title="QuoteService",
 *     description="serviços do orçamento",
 *     required={"codigo_do_servico","descricao","quantidade","valor","sub_total"},
 *     @OA\Property(property="codigo_do_servico", type="string", example="0123"),
 *     @OA\Property(property="descricao", type="string", example="Troca de óleo"),
 *     @OA\Property(property="quandidade", type="string", example="1"),
 *     @OA\Property(property="valor", type="string", example="60"),
 *     @OA\Property(property="desconto", type="string", example="0"),
 *     @OA\Property(property="sub_total", type="string", example="60")
 * )
 */
class QuoteServiceSchema
{}
