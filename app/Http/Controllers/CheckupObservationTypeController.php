<?php

namespace App\Http\Controllers;

use App\Models\CheckupObservationType;
use Illuminate\Http\JsonResponse;

class CheckupObservationTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/company/checkup-observation-types",
     *     operationId="checkupObservationTypes",
     *     tags={"Company"},
     *     summary="lista de observações",
     *     description="lista de observações para checkup veicular",
     *     security={{ "bearerAuth" : {} }},
     *
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="token de acesso do usuário company",
     *
     *         @OA\Schema(type="string", format="Bearer {token}")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(
     *                 type="object",
     *
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="type", type="string", example="amortecedores dianteiro")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *        response=403,
     *        description="Não autorizado",
     *
     *        @OA\JsonContent(
     *
     *            @OA\Property(property="error", type="string", example="Invalid ability provided.")
     *         )
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        $checkupObservationType = CheckupObservationType::all();

        return response()->json($checkupObservationType, 200);
    }
}
