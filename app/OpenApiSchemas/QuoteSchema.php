<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="Quote",
 *     title="Quote",
 *     description="Quote object",
 *
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="company_id", type="integer"),
 *     @OA\Property(property="company_numbering", type="integer"),
 *     @OA\Property(property="customer_id", type="integer"),
 *     @OA\Property(property="vehicle_id", type="integer"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="entry_date", type="string"),
 *     @OA\Property(property="exit_date", type="string"),
 *     @OA\Property(property="problem_description", type="string"),
 *     @OA\Property(property="report", type="string"),
 *     @OA\Property(property="observation", type="string"),
 *     @OA\Property(property="subtotal_service", type="string"),
 *     @OA\Property(property="subtotal_part", type="string"),
 *     @OA\Property(property="gross_total", type="string"),
 *     @OA\Property(property="discount", type="string"),
 *     @OA\Property(property="net_total", type="string"),
 *     @OA\Property(property="total", type="string"),
 *     @OA\Property(property="created_at", type="string"),
 *     @OA\Property(property="updated_at", type="string"),
 *     @OA\Property(property="customer", ref="#/components/schemas/Customer"),
 *     @OA\Property(property="vehicle", ref="#/components/schemas/vehicleResponse")
 * )
 */
class QuoteSchema {}

/**
 * @OA\Schema(
 *     schema="QuoteCreate",
 *     title="QuoteCreate",
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
class QuoteCreateSchema {}

/**
 * @OA\Schema(
 *     schema="QuoteResponse",
 *     title="QuoteResponse",
 *     description="dados para orçamento",
 *     required={"customer_id", "vehicle_id", "entry_date", "problem_description", "subtotal_service","subtotal_part","gross_total","net_total", "total"},
 *
 *     @OA\Property(property="customer_id", type="integer",description="id do consumidor", example="1009"),
 *     @OA\Property(property="vehicle_id", type="integer", description="id do veículo", example="243"),
 *     @OA\Property(property="status", type="string", description="status do orçamento", enum={"pending", "accepted", "rejected"},example="pending"),
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
class QuoteResponse {}

/**
 * @OA\Schema(
 *     schema="QuoteList",
 *     title="Quote List",
 *     description="List of quotes",
 *
 *     @OA\Property(property="current_page", type="integer"),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Quote")),
 *     @OA\Property(property="first_page_url", type="string"),
 *     @OA\Property(property="from", type="integer"),
 *     @OA\Property(property="last_page", type="integer"),
 *     @OA\Property(property="last_page_url", type="string"),
 *     @OA\Property(property="links", type="array", @OA\Items(
 *         @OA\Property(property="url", type="string"),
 *         @OA\Property(property="label", type="string"),
 *         @OA\Property(property="active", type="boolean")
 *     )),
 *     @OA\Property(property="next_page_url", type="string"),
 *     @OA\Property(property="path", type="string"),
 *     @OA\Property(property="per_page", type="integer"),
 *     @OA\Property(property="prev_page_url", type="string"),
 *     @OA\Property(property="to", type="integer"),
 *     @OA\Property(property="total", type="integer")
 * )
 */
class QuoteList {}
