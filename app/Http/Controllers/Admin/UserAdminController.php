<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UserCreateAction;
use App\Actions\UserUpdateAction;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user",
     *     operationId="UserIndex",
     *     tags={"Admin,Company"},
     *     summary="lista usuários",
     *     description="lista todos os usários de user for admin do sistema, se for company apenas os da company",
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="users",
     *                 type="array",
     *
     *                 @OA\Items(ref="#/components/schemas/User")
     *             )
     *         )
     *
     *     ),
     * )
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->company_id == Company::SYSTEM_ADMIN) {
            return response()->json(User::all()->toArray(), 200);
        } else {
            return response()->json(User::where('company_id', $request->company_id)->get()->toArray(), 200);
        }
    }

    /**
     *@OA\Post(
     *     path="/api/admin/user/{company_id}",
     *     operationId="storeUser",
     *     tags={"Admin"},
     *     summary="cria novo usuário para company",
     *     description="cria novo usuário para um company, e registra a(s) role(s)",
     *     security={{ "bearerAuth": {} }},

     *
     *     @OA\Parameter(
     *          name="company_id",
     *          description="Id do company",
     *          required=true,
     *          in="path",
     *
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *     @OA\RequestBody(
     *      required=true,
     *      description="dados para criação de usuário",
     *
     *      @OA\JsonContent(
     *
     *          @OA\Property(
     *              property="user",
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Marcelo Dantas"),
     *              @OA\Property(property="email", type="string", example="teste@rteste.ko"),
     *              @OA\Property(property="password", type="string", example="testesenha")
     *          ),
     *          @OA\Property(
     *              property="roles",
     *              type="array",
     *
     *              @OA\Items(type="integer"),
     *              example="{1, 2, 3}",
     *              description="chaves indices das roles"
     *          )
     *      )
     *  ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="usuario criado")
     *          )
     *
     *     ),
     *
     *     @OA\Response(
     *          response=403,
     *          description="Não autorizado",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="error", type="string", example="Invalid ability provided.")
     *           )
     *       ),
     *)
     */
    public function store($companyId, Request $request)
    {
        return app(UserCreateAction::class)->execute($companyId, $request);
    }

    /**
     * @OA\Put(
     *     path="/api/user/{user_id}",
     *     operationId="UserUpdate",
     *     tags={"Admin,Company"},
     *     summary="alteração de dados de usuário",
     *     description="alteração de dados e ou bloqueio de usuário",
     *
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="id do usuário a ser atualizado",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     security={{ "bearerAuth": {} }},

     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="dados que serão alterados, os demais devem ser null",
     *
     *         @OA\JsonContent(ref="#/components/schemas/UserUpdate")
     *     ),
     *
     *      @OA\Response(
     *              response=200,
     *              description="success",
     *
     *              @OA\JsonContent(
     *
     *                @OA\Property(property="message", type="string", example="success")
     *                )
     *      ),
     *
     *      @OA\Response(
     *                response=403,
     *                description="Unauthorized",
     *
     *                @OA\JsonContent(
     *
     *                    @OA\Property(property="error", type="string", example="Unauthorizes")
     *                )
     *      ),
     *
     * )
     */
    public function update($userId, Request $request)
    {
        return app(UserUpdateAction::class)->execute($userId, $request);
    }
}
