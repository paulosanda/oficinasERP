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
     * @OA\Get(
     *     path="/api/company/customer",
     *     summary="Listar clientes",
     *     description="Retorna uma lista de clientes, podendo filtrar por nome ou ID do cliente",
     *     operationId="indexCustomer",
     *     tags={"Company"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Parameter(
     *         name="customer_name",
     *         in="query",
     *         description="Nome do cliente para filtro",
     *         required=false,
     *
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
     *     @OA\Parameter(
     *         name="customer_id",
     *         in="query",
     *         description="ID do cliente para filtro",
     *         required=false,
     *
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clientes",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/Customer")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Erro no servidor",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Erro ao buscar clientes"
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            if ($request->query('customer_name')) {
                $customers = Customer::where('company_id', $request->company_id)
                    ->where('name', 'like', '%'.$request->query('customer_name').'%')
                    ->orderBy('name')
                    ->get();

                return response()->json($customers, 200);

            } elseif ($request->query('customer_id')) {
                $customer = Customer::where('company_id', $request->company_id)
                    ->where('id', $request->query('customer_id'))
                    ->first();

                return response()->json($customer, 200);

            } else {
                $customers = Customer::where('company_id', $request->company_id)->orderBy('name')->get();

                return response()->json($customers, 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

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
}
