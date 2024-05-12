<?php

namespace App\Http\Controllers;

use App\Actions\UserCreateAction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     *@OA\Post(
     *     path="/api/company/user",
     *     operationId="companyStoreUser",
     *     tags={"Company"},
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
    public function store(Request $request)
    {
        $companyId = $request->company_id;

        return app(UserCreateAction::class)->execute($companyId, $request);
    }

    /**
     * @OA\Delete(
     *     path="/api/company/user/{userId}",
     *     operationId="deleteUser",
     *     tags={"Company"},
     *     summary="deleteUser",
     *     description="deleta usuários",
     *     @OA\Parameter(
     *         name="userId",
     *         description="id do user",
     *         required=true,
     *         in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *
     *     ),
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="Authorization",
     *            in="header",
     *            required=true,
     *            description="Token de acesso do usuário",
     *            @OA\Schema(
     *                type="string",
     *                format="Bearer {token}"
     *            ),
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="usuario criado")
     *          )
     *      ),
     *      @OA\Response(
     *           response=403,
     *           description="Não autorizado",
     *           @OA\JsonContent(
     *               @OA\Property(property="error", type="string", example="Invalid ability provided.")
     *            )
     *      ),
     *     @OA\Response(
     *         response = 500,
     *         description="invalid user",
     *        @OA\JsonContent(
     *            @OA\Property(property="error", type="string", example="invalid user")
     *        )
     *     )
     * )
     */
    public function delete($userId): JsonResponse
    {
        $user = User::findOrFail($userId);

        $companyId = Auth::user()->company_id;

        if($user->company_id != $companyId) {

            Log::info('erro na tentativa e deletar usuário realizada por: ', [Auth::user()->toArray()]);
            return response()->json(['error' => 'invalid user'], 500);
        } else {
            Log::info('Usuário deletado: ', [$userId]);
            $user->delete();

            return response()->json(['message' => 'success']);
        }
    }
}
