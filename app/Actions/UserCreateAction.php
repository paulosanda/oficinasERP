<?php

namespace App\Actions;

use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserCreateAction
{
    const USER_LIMIT = 3;

    protected function rules(): array
    {
        return [
            'user.name' => 'string|required',
            'user.email' => 'string|required',
            'user.password' => 'string|required',
            'roles.*' => 'integer',
        ];
    }

    public function execute($companyId, Request $request): JsonResponse
    {
        Log::info('creating company user by user: ', [Auth::user()->toArray()]);
        $data = $request->validate($this->rules());

        $data['user']['company_id'] = $companyId;

        $hasUserLimit = $this->checkUserLimit($companyId);

        if ($hasUserLimit) {
            DB::beginTransaction();

            try {
                $user = User::create($data['user']);

                $this->createUserRoles($data['roles'], $user->id);

                DB::commit();

                return response()->json(['message' => 'success']);
            } catch (Exception $e) {
                DB::rollBack();

                return response()->json(['error' => $e->getMessage()]);
            }
        } else {
            return response()->json(['error' => 'user limit reached'], 403);
        }

    }

    public function createUserRoles($data, $userId): void
    {
        foreach ($data as $role) {

            UserRole::create([
                'user_id' => $userId,
                'role_id' => $role,
            ]);
        }
    }

    public function checkUserLimit($companyId): bool
    {
        $hasUserLimit = User::where('company_id', $companyId)->count();
        if ($hasUserLimit >= self::USER_LIMIT) {
            return false;
        } else {
            return true;
        }
    }
}
