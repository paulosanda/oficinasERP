<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ClientCreateAction;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientAdminController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/client",
     *     operationId="IndexClient",
     *     tags={"Admin"},
     *     summary="lista todos os clientes",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="Bearer {token}"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="succes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Client")
     *         )
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Unauthorizes")
     *          )
     *      ),
     *
     * )
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $response = Client::all()->toArray();

        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/client",
     *     operationId="createClient",
     *     tags={"Admin"},
     *     summary="cria novo cadastro de cliente",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *           name="Authorization",
     *           in="header",
     *           required=true,
     *           @OA\Schema(type="string",format="Bearer {token}"),
     *           description="Token de acesso do usuário"
     *       ),
     *     @OA\RequestBody(
     *         request="CreateClient",
     *         description="Request body to create cliente",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Client"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/Client")
     *         )
     *     ),
     *     @OA\Response(
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
        return app(ClientCreateAction::class)->execute($request);
    }
}
