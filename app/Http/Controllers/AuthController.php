<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens;
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Credenciais invalidas.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $credentials = $request->only("email", "password");

        Auth::attempt($credentials);

        $user = Auth::user();

        $roles = $user->toArray();

        $abilities = array_column($roles['roles'], 'role');

        $token = $user->createToken('erp', $abilities)->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
}
