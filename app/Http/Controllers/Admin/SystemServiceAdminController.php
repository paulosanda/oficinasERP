<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class SystemServiceAdminController extends Controller
{
    /**
     * @OA\Get(
     *     path="api/admin/system-service",
     *     operationId="SystemServices",
     *     tags={"Admin"},
     *     summary="serviços do sistema",
     *     description="serviços do sistema",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="Bearer {token}"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SystemService")
     *         )
     *     ),
     *     @OA\Response(
     *      response=403,
     *      description="Unauthorized",
     *      @OA\JsonContent(
     *          @OA\Property(property="error", type="string", example="Unauthorizes")
     *      )
     *    ),
     * )
     */
    public function index(): JsonResponse
    {
        $systemServices = SystemService::all()->toArray();

        return response()->json($systemServices);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/system-service",
     *     operationId="createSystemService",
     *     tags={"Admin"},
     *     summary="createSystemService",
     *     description="cria serviços do sistema",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="Bearer {token}"
     *         )
     *     ),
     *     @OA\RequestBody(
     *          request="CreateSystemService",
     *          description="request body to create system service",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/BodyRequestSystemService"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Company")
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Unauthorizes")
     *          )
     *      ),
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'service_name' => 'string|required',
            'service_price' => 'string|required'
        ];

        $data = $request->validate($rules);

        try {
            $newSystemService = SystemService::create($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


        return response()->json(['message' => 'success'], 200);
    }

//    todo fazer o update
}
