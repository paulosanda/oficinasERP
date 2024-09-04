<?php

namespace App\Livewire\Company;

use App\Actions\UserUpdateAction;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserAdmin extends Component
{
    public $users = null;

    public $userDelete = null;

    public int $user_id;

    public string $name = '';

    public string $email = '';

    public $roles;

    public string $password = '';

    public bool $modalEditUserSuccess = false;

    public array $selectedRoles = [];

    public bool $enable = false;

    public bool $modalEditUser = false;

    public bool $confirmDeleteUser = false;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();

        $companyId = $user->company_id;

        $this->users = User::where('company_id', $companyId)->get();

        return view('livewire.company.user-admin')->with(['users', $this->users]);
    }

    public function showModalEditUser($userId): void
    {
        $user = User::find($userId);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->enable = $user->enable;

        $this->roles = Role::where('type', 'company')->get();

        $this->selectedRoles = $user->roles->pluck('id')->toArray();

        $this->modalEditUser = true;
    }

    public function hideModalEditUser(): void
    {
        $this->modalEditUser = false;
    }

    public function updateUser(): void
    {
        $rolesToInteger = array_map('intval', $this->selectedRoles);

        $roles = array_map(function ($id) {
            return ['id' => $id];
        }, $rolesToInteger);

        $request = new Request();
        $request->merge([
            'id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $roles,
            'enable' => $this->enable,
        ]);

        if ($this->password) {
            $request->merge([
                'password' => $this->password,
            ]);
        }

        $updateUser = app(UserUpdateAction::class)->execute($this->user_id, $request);

        if ($updateUser->getStatusCode() == 200) {
            $this->modalEditUserSuccess = true;
        }
    }

    public function hideModalEditUserSuccess(): void
    {
        $this->modalEditUserSuccess = false;
        $this->modalEditUser = false;
    }

    public function showConfirmDeleteUser($userId): void
    {
        $this->userDelete = User::findOrFail($userId);

        $this->confirmDeleteUser = true;

    }

    public function hideConfirmDeleteUser(): void
    {
        $this->confirmDeleteUser = false;
    }

    public function deleteUser(): void
    {
        $this->userDelete->delete();

        $this->confirmDeleteUser = false;
    }
}
