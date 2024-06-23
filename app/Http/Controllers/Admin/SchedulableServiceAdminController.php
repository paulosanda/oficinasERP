<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchedulableService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchedulableServiceAdminController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/schedulable-services",
     *     operationId="ScheduleableServicesList",
     *     tags={"Admin"},
     *     summary="lista serviços agendáveis",
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *
     *         @OA\Schema(type="string", format="Bearer {token}")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="service", type="string", example="Troca de óleo"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="error", type="string", example="Unauthorizes")
     *          )
     *    ),
     * )
     */
    public function index(): JsonResponse
    {
        $schedulableServices = SchedulableService::all();

        return response()->json($schedulableServices->toArray(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/schedulable-services",
     *     operationId="createSchedulableService",
     *     tags={"Admin"},
     *     summary="criar novos serviços agendáveis",
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *
     *         @OA\Schema(type="string", format="Bearer {token)"),
     *         description="tokem de acesso de usuário admin"
     *     ),
     *
     *     @OA\RequestBody(
     *         request="createSchedulableService",
     *         description="token de acesso do usuário",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="service", type="string", example="Filtro de ar"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="success",
     *
     *          @OA\JsonContent(
     *
     *            @OA\Property(property="message", type="string", example="success")
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="error", type="string", example="Unauthorizes")
     *          )
     *      ),
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $rules = ['service' => 'string|required'];

        $data = $request->validate($rules);

        $newService = SchedulableService::create($data);

        return response()->json(['message' => 'success']);
    }

    /**
     * @OA\Patch(
     *     path="/api/admin/schedulable-services",
     *     operationId="updateSchedulableServices",
     *     tags={"Admin"},
     *     summary="altera tipo de serviços agendáveis",
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *
     *         @OA\Schema(type="string", format="Bearer {token}"),
     *         description="token de acesso"
     *     ),
     *
     *     @OA\RequestBody(
     *         request="SchedulableServiceUpdate",
     *         description="Request body to update",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(type="service", type="string", example="Pastilha de freio"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="success")
     *        )
     *     ),
     *
     *     @OA\Response(
     *           response=403,
     *           description="Unauthorized",
     *
     *           @OA\JsonContent(
     *
     *               @OA\Property(property="error", type="string", example="Unauthorizes")
     *           )
     *       ),
     * )
     */
    public function update($schedulableServiceId, Request $request): JsonResponse
    {
        $rules = ['service' => 'required|string'];

        $data = $request->validate($rules);

        $updateService = SchedulableService::findOrFail($schedulableServiceId);
        $updateService->update(['service' => $data['service']]);

        return response()->json(['message' => 'success']);
    }
}
