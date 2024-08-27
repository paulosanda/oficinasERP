<?php

namespace App\Http\Controllers;

use App\Actions\CheckupCreateAction;
use App\Models\Checkup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckupController extends Controller
{
    private $paginate = 10;

    /**
     * @OA\Get(
     *     path="/api/company/checkups",
     *     operationId="CheckupVeicularIndex",
     *     tags={"Company"},
     *     summary="lista todas checkups da company",
     *     security={{ "bearerAuth" : {} }},
     *
     *     @OA\Parameter(
     *          name="paginate",
     *          in="query",
     *          description="Número de itens por página",
     *          required=false,
     *
     *          @OA\Schema(type="integer", example=10)
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *
     *         @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/PaginatedCheckups")
     *          )
     *     ),
     *
     *     @OA\Response(
     *            response=403,
     *            description="Unauthorized",
     *
     *            @OA\JsonContent(
     *
     *                @OA\Property(property="error", type="string", example="Unauthorized")
     *            )
     *        ),
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $paginate = $request->query('paginate') ?? $this->paginate;

        $checkups = Checkup::where('company_id', $request->company_id)->orderBy('id', 'desc')->paginate($paginate);

        return response()->json($checkups, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/company/customer/checkup",
     *     operationId="createCheckupVeicular",
     *     tags={"Company"},
     *     summary="cria checkup veicular pode ser acessado tanto por master como operator",
     *     security={{ "bearerAuth" : {} }},
     *
     *     @OA\RequestBody(
     *         request="dadosDoCheckup",
     *         description="dados para registro de checkup veicular",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Checkup")
     *     ),
     *
     *     @OA\Response(
     *           response=200,
     *           description="success",
     *
     *           @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="success")
     *           )
     *       ),
     *
     *       @OA\Response(
     *           response=403,
     *           description="Unauthorized",
     *
     *           @OA\JsonContent(
     *
     *               @OA\Property(property="error", type="string", example="Unauthorized")
     *           )
     *       ),
     * )
     */
    public function store(Request $request)
    {
        //        todo inserir do company_id na documentação swagger
        return app(CheckupCreateAction::class)->execute($request);

    }
}
