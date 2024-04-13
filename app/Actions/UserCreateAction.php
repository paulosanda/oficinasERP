<?php

namespace App\Actions;

use App\Models\ClientUser;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCreateAction
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

    public function execute($clientId, Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $user = User::create($data['user']);

            $this->createUserRoles($data['roles'], $user->id);

            $this->appendUserToClient($clientId, $user->id);

            return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function createUserRoles($data, $userId): void
    {
        foreach ($data as $role) {
            UserRole::create([
                'user_id' => $userId,
                'role_id' => $role
            ]);
        }
    }

    private function appendUserToClient($clientId, $userId): void
    {
        ClientUser::create([
            'client_id' => $clientId,
            'user_id' => $userId
        ]);
    }
}
