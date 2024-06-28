<?php

namespace App\Http\Controllers;

use App\Actions\CustomerCreateAction;
use App\Actions\CustomerUpdateAction;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/company/customer",
     *     operationId="createCustomer",
     *     tags={"Company"},
     *     summary="cria customer (consumidor)",
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\RequestBody(
     *         request="dadosDoCustomer",
     *         description="dados do customer",
     *
     *         @OA\JsonContent(
     *              ref="#/components/schemas/BodyRequestCustomer")
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
     *
     * )
     */
    public function store(Request $request)
    {
        return app(CustomerCreateAction::class)->execute($request);
    }

    /**
     * @OA\Put(
     *     path="/api/company/customer",
     *     operationId="updateCustomer",
     *     tags={"Company"},
     *     summary="altera customer",
     *     security={{ "bearerAuth" : {} }},

     *
     *     @OA\RequestBody(
     *         request="dadosdoCustomer",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *
     *          @OA\Response(
     *           response=200,
     *           description="success",
     *
     *           @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="success")
     *           )
     *       ),
     *
     *     @OA\Response(
     *           response=403,
     *           description="Unauthorized",
     *
     *           @OA\JsonContent(
     *
     *               @OA\Property(property="message", type="string", example="Invalid ability provided")
     *           )
     *       ),
     *)
     */
    public function update(Request $request)
    {
        return app(CustomerUpdateAction::class)->execute($request);
    }

    //    todo fazer get de customers
    public function index(Request $request): JsonResponse
    {
        //sem query parameter
        $customers = Customer::where('company_id', $request->company_id)->orderBy('name')->get();

        return response()->json($customers, 200);
    }
}
