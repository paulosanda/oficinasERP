<?php

namespace App\Http\Controllers;

use App\Actions\CheckupCreateAction;
use Illuminate\Http\Request;

class CheckupController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/company/customer/checkup",
     *     operationId="createCheckupVeicular",
     *     tags={"Company"},
     *     summary="cria checkup veicular",
     *     security={{ "bearerAuth" : {} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="token de usuário company",
     *         @OA\Schema(type="string", format="Bearer {token}")
     *     ),
     *     @OA\RequestBody(
     *         request="dadosDoCheckup",
     *         description="dados para registro de checkup veicular",
     *         @OA\JsonContent(ref="#/components/schemas/Checkup")
     *     ),
     *     @OA\Response(
     *           response=200,
     *           description="success",
     *           @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="success")
     *           )
     *       ),
     *       @OA\Response(
     *           response=403,
     *           description="Unauthorized",
     *           @OA\JsonContent(
     *               @OA\Property(property="error", type="string", example="Unauthorizes")
     *           )
     *       ),
     * )
     */
    public function store(Request $request)
    {
        return app(CheckupCreateAction::class)->execute($request);
    }
}
