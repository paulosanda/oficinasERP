<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="QuoteService",
 *     title="QuoteService",
 *     description="serviços do orçamento",
 *     required={"service_code","description","quantity","value","sub_total"},
 *
 *     @OA\Property(property="service_code", type="string",description="código do serviço" ,example="0123"),
 *     @OA\Property(property="description", type="string", description="descrição do serviço" ,example="Troca de óleo"),
 *     @OA\Property(property="quantity", type="string", description="quantidade", example="1"),
 *     @OA\Property(property="value", type="string",description="valor" , example="60"),
 *     @OA\Property(property="discount", type="string", description="desconto" , example="0"),
 *     @OA\Property(property="subtotal", type="string", example="60")
 * )
 */
class QuoteServiceSchema {}
