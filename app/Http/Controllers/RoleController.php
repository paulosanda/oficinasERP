<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     *@OA\Get(
     *     path="/admin/company/roles",
     *     operationId="companyRoles",
     *     tags={"Admin"},
     *     summary="lista roles de company",
     *     description="lista roles de company",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Token de acesso do usuário administrativo ou root",
     *         @OA\Schema(
     *             type="string",
     *             format="Bearer {token}"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="roles",
     *                  type="array",
     *                  @OA\Items(
     *                   type="object",
     *                   @OA\Property(property="id", type="integer", description="id da role", example="3"),
     *                   @OA\Property(property="role", type="string", description="nome da role", example="master"),
     *                   @OA\Property(property="type", type="string", description="tipo de role", example="company"),
     *                   @OA\Property(property="role_description", type="string", description="descrição da role", example="master do cliente"),
     *                  )
     *              )
     *         )
     *     ),
     *       @OA\Response(
     *        response=403,
     *        description="Não autorizado",
     *        @OA\JsonContent(
     *            @OA\Property(property="error", type="string", example="Invalid ability provided.")
     *         )
     *      ),
     *)
     */
    public function companyIndex(): JsonResponse
    {
        $companyRules = Role::where('type', 'company')->get();

        return response()->json(['roles' => $companyRules->toArray()], 200);
    }
}
