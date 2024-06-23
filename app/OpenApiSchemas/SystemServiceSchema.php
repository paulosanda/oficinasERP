<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="SystemService",
 *     title="SystemService",
 *     description="dados dos serviços do sistema",
 *     required={"id","service_name","service_price"},
 *
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="service_name", type="string", description="nome do serviço", example="whatsapp"),
 *     @OA\Property(property="service_price", type="string", description="preço do serviço", example="50"),
 * )
 */
class SystemServiceSchema {}

/**
 * @OA\Schema(
 *      schema="BodyRequestSystemService",
 *      title="BodyRequestSystemService",
 *      description="cadastro de serviço do sistema",
 *      required={"service_name","service_price"},
 *
 *      @OA\Property(property="service_name", type="string", description="nome do serviço", example="whatsapp"),
 *      @OA\Property(property="service_price", type="string", description="preço do serviço", example="50"),
 * )
 */
class BodyRequestSystemService {}
