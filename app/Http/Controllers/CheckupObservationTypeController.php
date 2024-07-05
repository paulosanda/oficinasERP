<?php

namespace App\Http\Controllers;

use App\Models\CheckupObservationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckupObservationTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/checkup-observation-types",
     *     operationId="checkupObservationTypes",
     *     tags={"Admin,Company"},
     *     summary="lista de observações",
     *     description="lista de observações para checkup veicular",
     *     security={{ "bearerAuth" : {} }},
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

    /**
     * @OA\Post(
     *     path="/api/admin/checkout-observation",
     *     operationId="checkupObservationTypeCreate",
     *     tags={"Admin"},
     *     summary="newCheckupObservationType",
     *     description="cria tipo de observação para checkup veicular",
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\RequestBody(
     *         request="newcheckupObservationType",
     *         description="novo tipo de observação para checkup veicular",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="type", type="string", example="troca filtro do ar condicionado")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="success",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Checkup Observation Type Created")
     *         )
     *     ),
     *
     *          @OA\Response(
     *        response=403,
     *        description="Não autorizado",
     *
     *        @OA\JsonContent(
     *
     *            @OA\Property(property="error", type="string", example="Invalid ability provided.")
     *         )
     *       ),
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'type' => 'string|required',
        ]);

        try {
            CheckupObservationType::create($data);

            return response()->json(['message' => 'Checkup Observation Type Created'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);

        }
    }
    // todo fazer alteração de tipos e observações para checkup pacth
}
