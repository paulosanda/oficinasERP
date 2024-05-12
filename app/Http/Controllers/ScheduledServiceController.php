<?php

namespace App\Http\Controllers;

use App\Actions\ScheduleServiceCreateAction;
use App\Models\SchedulableService;
use App\Models\ScheduledService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduledServiceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/company/services",
     *     operationId="schedulableServiceList",
     *     tags={"Company"},
     *     summary="lista de serviços agendaveis",
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *              type="string",
     *              format="Bearer {token}"
     *          )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="lista de serviços agendáveis",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(
     *              type="object",
     *              @OA\Property(property="id", type="integer", example="1"),
     *              @OA\Property(property="service", type="string", example="Troca de óleo")
     *         ),
     *     )
     *  ),
     * @OA\Response(
     *     response=403,
     *     description="Unauthorized",
     *     @OA\JsonContent(
     *         @OA\Property(property="error", type="string", example="Unauthorizes")
     *     )
     *   ),
     * )
     */
    public function listService(): JsonResponse
    {
        $services = SchedulableService::all()->toArray();

        return response()->json($services, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/company/customer/schedule-service",
     *     operationId="scheduledServicesIndex",
     *     tags={"Company"},
     *     summary="lista serviços agendados",
     *     security={{ "bearerAuth" : {} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *          in="header",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="Bearer {token}"
     *          ),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="succes",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/ScheduleService")
     *          )
     *      ),
     *      @OA\Response(
     *           response=403,
     *           description="Unauthorized",
     *           @OA\JsonContent(
     *               @OA\Property(property="error", type="string", example="Unauthorizes")
     *           )
     *       ),
     *
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $scheduledServices = ScheduledService::where('company_id', $request->company_id)->get();

        return response()->json($scheduledServices, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/company/schedule-service",
     *     operationId="scheduleServiceCreate",
     *     tags={"Company"},
     *     summary="cria agendamento de serviço",
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string", format="Bearer {token}")
     *     ),
     *     @OA\RequestBody(
     *         request="dadosScheduleService",
     *         description="dados para agendar serviço",
     *         @OA\JsonContent(ref="#/components/schemas/BodyRequestScheduleService")
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
        return app(ScheduleServiceCreateAction::class)->execute($request);
    }

}
