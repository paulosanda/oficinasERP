<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="Checkup",
 *     title="Checkup",
 *     required={"vehicle_id"},
 *     description="Checkup veicular",
 *
 *     @OA\Property(property="company_id", type="integer", example="1"),
 *     @OA\Property(property="customer_id", type="integer", example="2"),
 *     @OA\Property(property="vehicle_id", type="integer", example="1"),
 *     @OA\Property(property="front_damage", type="string", nullable=true, description="avarias frontais", example="farol quebrado"),
 *     @OA\Property(property="front_photo", type="string", format="string", nullable=true, example="este deverá ser o upload de uma imagem - ainda não deve ser implementado"),
 *     @OA\Property(property="back_damage", type="string" , nullable=true, description="avarias traseiras", example="parachoque amassado"),
 *     @OA\Property(property="back_photo", type="string",format="string" , nullable=true, description="foto traseira", example="este deverá ser o upload de uma imagem - ainda não deve ser implementado"),
 *     @OA\Property(property="right_side_damage", type="string", nullable=true, description="avarias do lado direito", example="arranhado na porta dianteira"),
 *     @OA\Property(property="right_side_photo", type="string", format="string", nullable=true, description="foto do lado direito", example="este deverá ser o upload de uma imagem - ainda não deve ser implementado"),
 *     @OA\Property(property="left_side_damage", type="string" , nullable=true, description="avaria do lado esquerdo", example="amassado na porta traseira"),
 *     @OA\Property(property="left_side_photo", type="string", format="string", nullable=true , description="foto do lado esquerdo", example="este deverá ser o upload de uma imagem - ainda não deve ser implementado"),
 *     @OA\Property(property="roof_damage", type="string" , nullable=true, description="avarias no teto", example="sem avarias"),
 *     @OA\Property(property="roof_photo", type="string",format="string", nullable=true, description="foto do teto" ,example="este deverá ser o upload de uma imagem - ainda não deve ser implementado"),
 *     @OA\Property(property="fuel_gauge", type="string" , nullable=true, description="medidor do combustível marcando", example="vazio ou 1/4 ou 1/2 ou 3/4 ou cheio"),
 *     @OA\Property(property="fuel_gauge_photo", type="string", format="string", nullable=true, description="foto do marcador de combustível" ,example="este deverá ser o upload de uma imagem - ainda não deve ser implementado"),
 *     @OA\Property(property="evaluation", type="string", description="campo enum deve ser - aprovado para uso ou manutenção recomendada"),
 *     @OA\Property(property="checkup_observation", type="array" , nullable=true, @OA\Items(ref="#/components/schemas/CheckupObservation")),
 * )
 */
class CheckupSchema {}

/**
 * @OA\Schema(
 *     schema="PaginatedCheckups",
 *     title="Paginated Checkups",
 *     description="Resposta paginada de checkups",
 *
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *
 *         @OA\Items(ref="#/components/schemas/Checkup")
 *     ),
 *
 *     @OA\Property(property="first_page_url", type="string", example="http://localhost/api/company/checkups?page=1"),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=1),
 *     @OA\Property(property="last_page_url", type="string", example="http://localhost/api/company/checkups?page=1"),
 *     @OA\Property(
 *         property="links",
 *         type="array",
 *
 *         @OA\Items(
 *             type="object",
 *
 *             @OA\Property(property="url", type="string", nullable=true, example="http://localhost/api/company/checkups?page=1"),
 *             @OA\Property(property="label", type="string", example="1"),
 *             @OA\Property(property="active", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Property(property="next_page_url", type="string", nullable=true, example=null),
 *     @OA\Property(property="path", type="string", example="http://localhost/api/company/checkups"),
 *     @OA\Property(property="per_page", type="integer", example=10),
 *     @OA\Property(property="prev_page_url", type="string", nullable=true, example=null),
 *     @OA\Property(property="to", type="integer", example=1),
 *     @OA\Property(property="total", type="integer", example=1),
 * )
 */
class PaginatedCheckups {}
