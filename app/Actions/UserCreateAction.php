<?php

namespace App\Actions;

use App\Models\ClientUser;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserCreateAction extends BaseAction
{
    protected function rules(): array
    {
        return [
                'user.name' => 'string|required',
                'user.email' => 'string|required',
                'user.password' => 'string|required',
                'roles' => 'required|array',
                'roles.*' => 'integer'
        ];
    }

    public function execute($clientId, Request $request): \Illuminate\Http\JsonResponse
    {
        $data = Validator::make($request->all(), $this->rules());

        if ($data->fails()) {
            return response()->json(['error' => $data->errors()], 422);
        }
        try {

            $userData = $data->getData()['user'];

            $user = User::create($userData);

            $roleData = $data->getData()['roles'];

            foreach ($roleData as $role) {
                UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => $role
                ]);
            }

            ClientUser::create([
                'client_id' => $clientId,
                'user_id' => $user->id
            ]);

            return response()->json(['message' => 'usuário criado com sucesso']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
