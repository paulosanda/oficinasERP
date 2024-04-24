<?php

namespace App\Http\Controllers;

use App\Actions\QuoteCreateAction;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/company/quote",
     *      operationId="createQuote",
     *      tags={"Company"},
     *      summary="cria orçamento",
     *      security={{ "bearerAuth" : {} }},
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          description="token de usuário company",
     *          @OA\Schema(type="string", format="Bearer {token}")
     *      ),
     *      @OA\RequestBody(
     *          request="dadosDoCheckup",
     *          description="dados para registro de orçamento",
     *          @OA\JsonContent(ref="#/components/schemas/Quote")
     *      ),
     *      @OA\Response(
     *            response=200,
     *            description="success",
     *            @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="success")
     *            )
     *        ),
     *      @OA\Response(
     *            response=403,
     *            description="Unauthorized",
     *            @OA\JsonContent(
     *                @OA\Property(property="error", type="string", example="Unauthorizes")
     *            )
     *        ),
     *
     * )
     */
    public function store(Request $request)
    {
        return app(QuoteCreateAction::class)->execute($request);
    }
}
