<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="Checkup",
 *     title="Checkup",
 *     required={"vehicle_id"},
 *     description="Checkup veicular",
 *
 *     @OA\Property(property="vehicle_id", type="integer", example="1"),
 *     @OA\Property(property="front_damage", type="string", nullable=true, description="avarias frontais", example="farol quebrado"),
 *     @OA\Property(property="front_photo", type="string", format="binary", nullable=true, example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="back_damage", type="string" , nullable=true, description="avarias traseiras", example="parachoque amassado"),
 *     @OA\Property(property="back_photo", type="string",format="binary" , nullable=true, description="foto traseira", example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="right_side_damage", type="string", nullable=true, description="avarias do lado direito", example="arranhado na porta dianteira"),
 *     @OA\Property(property="right_side_photo", type="string", format="binary", nullable=true, description="foto do lado direito", example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="left_side_damage", type="string" , nullable=true, description="avaria do lado esquerdo", example="amassado na porta traseira"),
 *     @OA\Property(property="left_side_photo", type="string", format="binary", nullable=true , description="foto do lado esquerdo", example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="roof_damage", type="string" , nullable=true, description="avarias no teto", example="sem avarias"),
 *     @OA\Property(property="roof_photo", type="string",format="binary", nullable=true, description="foto do teto" ,example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="fuel_gauge", type="string" , nullable=true, description="medidor do combustível marcando", example="vazio,1/4, 1/2, 3/4 ou cheio"),
 *     @OA\Property(property="fuel_gauge_photo", type="string", format="binary", nullable=true, description="foto do marcador de combustível" ,example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="evaluation", type="string", description="avaliação"),
 *     @OA\Property(property="checkup_observation", type="array" , nullable=true, @OA\Items(ref="#/components/schemas/CheckupObservation")),
 * )
 */
class CheckupSchema {}
