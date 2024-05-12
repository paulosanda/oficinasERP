<?php

namespace App\Http\Controllers\Admin;

use App\Actions\CompanyCreateAction;
use App\Actions\CompanyUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyAdminController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/company",
     *     operationId="IndexCompany",
     *     tags={"Admin"},
     *     summary="lista todos os company",
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
     *             @OA\Items(ref="#/components/schemas/Company")
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
    public function index(): JsonResponse
    {
        $response = Company::all()->toArray();

        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/company",
     *     operationId="createCompany",
     *     tags={"Admin"},
     *     summary="cria novo cadastro de company",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *           name="Authorization",
     *           in="header",
     *           required=true,
     *           @OA\Schema(type="string",format="Bearer {token}"),
     *           description="Token de acesso do usuário"
     *       ),
     *     @OA\RequestBody(
     *         request="CreateCompany",
     *         description="Request body to create company",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/BodyRequestCompany"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/Company")
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
    public function store(Request $request): JsonResponse
    {
        return app(CompanyCreateAction::class)->execute($request);
    }

    /**
     * @OA\Put(
     *     path="/api/admin/company",
     *     operationId="updateCompany",
     *     tags={"Admin"},
     *     summary="atualiza cadastro de company",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string", format="Bearer {token}"),
     *         description="token de acesso do usuário administrativo ou root"
     *     ),
     *     @OA\RequestBody(
     *         request="updateCompany",
     *         description="Request body to update a company",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref="#/components/schemas/Company")
     *       )
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
    public function update(Request $request): JsonResponse
    {
        return app(CompanyUpdateAction::class)->execute($request);
    }
}
