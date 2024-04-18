<?php

namespace App\Http\Controllers;

use App\Actions\VehicleCreateAction;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/customer/vehicle",
     *     operationId="createVehicle",
     *     tags={"Company"},
     *     summary="cria vehicle",
     *     security={{ "bearerAuth" : {} }},
     *     @OA\Parameter(
     *         name="Authoriztion",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string", format="Bearer {token}")
     *     ),
     *     @OA\RequestBody(
     *         request="dadosDoVehicle",
     *         description="dados de vehicle",
     *         @OA\JsonContent(ref="#/components/schemas/vehicle")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="success")
     *         )
     *      ),
     *      @OA\Response(
     *         response=403,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorizes")
     *         )
     *     ),
     * )
     */
    public function store(Request $request)
    {
        return app(VehicleCreateAction::class)->execute($request);
    }
}
