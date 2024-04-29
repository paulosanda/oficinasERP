<?php

namespace App\Actions;

use App\Models\User;
use App\Models\UserRole;
use App\Trait\RemoveNullElementsFromArray;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery\Exception;

class UserUpdateAction
{
    use RemoveNullElementsFromArray;

    public function rules(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'email' => 'string',
            'password' => 'string|nullable',
            'enable' => 'boolean',
            'roles' => 'array',
            'roles.*.id' => 'integer'
        ];
    }
    public function execute($userId, Request $request): JsonResponse
    {
        try {
            $data = $request->validate($this->rules());

            $dataNullRemoved = $this->removeNull($data);

            $user = User::findOrFail($userId);

            $user->update($dataNullRemoved);

            if(isset($data['roles'])) {
                $this->updateRoles($userId, $data);

            }
            return  response()->json(['message' => 'success']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


    }

    public function updateRoles($userId, $data): void
    {
        $roles = UserRole::where('user_id', $userId)->delete();

        foreach($data['roles'] as $role) {

            UserRole::create([
               'user_id' => $userId,
               'role_id' => $role['id']
            ]);
        }

    }

}
