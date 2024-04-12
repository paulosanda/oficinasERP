<?php

namespace App\Http\Controllers;

use App\Actions\CustomerCreateAction;
use App\Actions\CustomerUpdateAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/client/customer",
     *     operationId="createCustomer",
     *     tags={"Client"},
     *     summary="cria customer (consumidor)",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string", format="Bearer {token}")
     *     ),
     *     @OA\RequestBody(
     *         request="dadosDoCustomer",
     *         description="dados do customer",
     *         @OA\JsonContent(
     *              ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="success")
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
    public function store(Request $request)
    {
        return app(CustomerCreateAction::class)->execute($request);
    }

    public function update(Request $request)
    {
        return app(CustomerUpdateAction::class)->execute($request);
    }
}
