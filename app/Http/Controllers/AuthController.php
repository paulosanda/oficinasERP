<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens;

    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="loginUser",
     *     tags={"Auth"},
     *     summary="Login de usuário",
     *     description="Autentica usuário e retorna token",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados de login do usuário",
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="usuario@gmm.com.br"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário autenticado com sucesso",
     *         @OA\JsonContent(
     *              @OA\Property(property="token", type="string", description="Token de acesso")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Mensagem de erro", example="Credenciais invalidas")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="UserDisable",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="seu acesso está bloqueado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Mensagem de error", example="Credenciais invalidas")
     *         )
     *     ),
     *     @OA\Response(
     *            response=500,
     *            description="Erro",
     *            @OA\JsonContent(
     *                @OA\Property(property="error", type="string", example="Internal server error")
     *            )
     *        )
     *
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Credenciais invalidas.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $credentials = $request->only("email", "password");

        if(Auth::attempt($credentials)) {
            $user = Auth::user();

            if(!$user->enable) {
                return response()->json(['error' => 'seu acesso está bloqueado'], 403);
            }

            $roles = $user->toArray();

            $abilities = array_column($roles['roles'], 'role');

            $token = $user->createToken('erp', $abilities)->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'credenciais inválidas'], 422);
        }


    }

    /**
     * @OA\Delete(
     *     path="/api/logout",
     *     operationId="logoutUser",
     *     tags={"Auth"},
     *     summary="Logout de usuário",
     *     description="Revoga o token de acesso do usuário e realiza o logout.",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="Bearer {token}"
     *          ),
     *          description="Token de acesso do usuário"
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Logout realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout realizado com sucesso.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao fazer logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ocorreu um erro ao fazer logout.")
     *         )
     *     )
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->header('Authorization');
        $user = Auth::user();
        $user->tokens()->delete();

        if ($user->tokens()->count() === 0) {
            return response()->json(['message' => 'Logout realizado com sucesso.'], 200);
        } else {
            return response()->json(['message' => 'Ocorreu um erro ao fazer logout.'], 500);
        }
    }
}
