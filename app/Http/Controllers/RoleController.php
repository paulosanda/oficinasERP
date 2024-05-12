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
     *     tags={"Admin,Company"},
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
     *                   @OA\Property(property="role_description", type="string", description="descrição da role", example="master do company"),
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

    /**
     * @OA\Get(
     *     path="/api/admin/roles",
     *     operationId="adminRoles",
     *     tags={"Admin"},
     *     summary="roles administrativas do sistema",
     *     description="roles para usuários administrativos do sistema",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="token de usuário administrativo ou super usuário",
     *         @OA\Schema(
     *             type="string",
     *             format="Bearer {token}"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(
     *                property="roles",
     *                type="array",
     *                @OA\Items(
     *                 type="object",
     *                  @OA\Property(property="id", type="integer", description="id", example="3"),
     *                  @OA\Property(property="role", type="string", description="role", example="root"),
     *                  @OA\Property(property="type", type="string", description="tipo de role", example="admin"),
     *                  @OA\Property(property="role_description", type="string", description="descrição da role", example="super usuário do sistema")
     *                  )
     *            )
     *        )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Não autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid ability provided.")
     *          )
     *       ),
     * )
     */
    public function adminIndex(): JsonResponse
    {
        $adminRules = Role::where('type', 'admin')->get();

        return response()->json(['roles' => $adminRules->toArray()], 200);
    }
}
