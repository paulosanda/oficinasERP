<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="Checkup",
 *     title="Checkup",
 *     required={"vehicle_id"},
 *     description="Checkup veicular",
 *     @OA\Property(property="vehicle_id", type="integer", example="1"),
 *     @OA\Property(property="avarias_frente", type="string", nullable=true),
 *     @OA\Property(property="av_frente_foto", type="string", format="binary", nullable=true, example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="avarias_traseiro", type="string" , nullable=true),
 *     @OA\Property(property="av_traseira_foto", type="string",format="binary" , nullable=true, example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="avarias_direito", type="string" , nullable=true),
 *     @OA\Property(property="av_direito_foto", type="string", format="binary" , nullable=true, example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="avarias_esquerdo", type="string" , nullable=true),
 *     @OA\Property(property="av_esquerdo_foto", type="string", format="binary", nullable=true , example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="avarias_teto", type="string" , nullable=true),
 *     @OA\Property(property="av_teto_foto", type="string",format="binary", nullable=true, example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="combustivel", type="string" , nullable=true),
 *     @OA\Property(property="combustivel_foto", type="string", format="binary", nullable=true, example="este deverá ser o upload de uma imagem"),
 *     @OA\Property(property="avaliacao", type="string"),
 *     @OA\Property(property="checkup_observation", type="array" , nullable=true, @OA\Items(ref="#/components/schemas/CheckupObservation")),
 * )
 */
class CheckupSchema
{}
