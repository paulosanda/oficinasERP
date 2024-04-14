<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UserCreateAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    /**
     *@OA\Post(
     *     path="/api/admin/user/{company_id}",
     *     operationId="storeUser",
     *     tags={"Admin"},
     *     summary="cria novo usuário para company",
     *     description="cria novo usuário para um company, e registra a(s) role(s)",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *           name="Authorization",
     *           in="header",
     *           required=true,
     *           description="Token de acesso do usuário",
     *           @OA\Schema(
     *               type="string",
     *               format="Bearer {token}"
     *           ),
     *       ),
     *     @OA\Parameter(
     *          name="company_id",
     *          description="Id do company",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *     @OA\RequestBody(
     *      required=true,
     *      description="dados para criação de usuário",
     *      @OA\JsonContent(
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
     *              @OA\Items(type="integer"),
     *              example="{1, 2, 3}",
     *              description="chaves indices das roles"
     *          )
     *      )
     *  ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="usuario criado")
     *          )
     *
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Não autorizado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Invalid ability provided.")
     *           )
     *       ),
     *)
     */
    public function store($companyId, Request $request)
    {
        return app(UserCreateAction::class)->execute($companyId, $request);
    }
}
