<?php

namespace App\Http\Controllers;

use App\Actions\QuoteCreateAction;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuoteController extends Controller
{
    private int $paginate = 10;

    /**
     * @OA\Get(
     *     path="/api/company/quote",
     *     summary="get orçamentos",
     *     description="Retorna os orçamentos de acordo com o status solicitado em paginação conforme o paginate",
     *     tags={"Company"},
     *     security={{ "bearerAuth" : {} }},
     *
     *     @OA\Parameter(
     *         description="Number of items per page",
     *         in="query",
     *         name="paginate",
     *         required=false,
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Parameter(
     *         description="Quote status (pending, accepted, rejected)",
     *         in="query",
     *         name="status",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="List of quotes",
     *
     *         @OA\JsonContent(ref="#/components/schemas/QuoteList")
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $paginate = $request->query('paginate') ?? $this->paginate;
        $status = $request->query('status');
        $validStatuses = ['pending', 'accepted', 'rejected'];

        if (! in_array($status, $validStatuses)) {
            return response()->json(['error' => 'Invalid status'], 400);
        }

        try {
            $response = Quote::where('status', $status)
                ->where('company_id', $request->company_id)
                ->orderBy('id', 'desc')
                ->paginate($paginate);

            return response()->json($response, 200);

        } catch (\Exception $e) {
            Log::info('QuoteController::index Exception: '.$e->getMessage());

            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * @OA\Post(
     *      path="/api/company/quote",
     *      operationId="createQuote",
     *      tags={"Company"},
     *      summary="cria orçamento",
     *      security={{ "bearerAuth" : {} }},

     *
     *      @OA\RequestBody(
     *          request="dadosDoCheckup",
     *          description="dados para registro de orçamento",
     *
     *          @OA\JsonContent(ref="#/components/schemas/QuoteCreate")
     *      ),
     *
     *      @OA\Response(
     *            response=200,
     *            description="success",
     *
     *            @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="success")
     *            )
     *        ),
     *
     *      @OA\Response(
     *            response=403,
     *            description="Unauthorized",
     *
     *            @OA\JsonContent(
     *
     *                @OA\Property(property="error", type="string", example="Unauthorizes")
     *            )
     *        ),
     *
     * )
     */
    public function store(Request $request): JsonResponse
    {
        return app(QuoteCreateAction::class)->execute($request);
    }
}
