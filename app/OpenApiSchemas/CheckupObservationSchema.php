<?php

namespace App\OpenApiSchemas;

/**
 * @OA\Schema(
 *     schema="CheckupObservation",
 *     title="CheckupObservation",
 *     required={"checkup_observation_type_id"},
 *     description="observações do checkup",
 *
 *     @OA\Property(property="checkup_observation_type_id", type="integer", example="1"),
 *     @OA\Property(property="observation", type="string", nullable=true, example="ooon noo noooobo")
 * )
 */
class CheckupObservationSchema {}
