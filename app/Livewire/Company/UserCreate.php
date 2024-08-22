<?php

namespace App\Livewire\Company;

use App\Actions\UserCreateAction;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Livewire\Component;

class UserCreate extends Component
{
    public Company $company;

    public int $company_id;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public int $role_id = 0;

    public bool $errorModal = false;

    public bool $modalSuccess = false;

    public $roles;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $user = auth()->user();

        $this->company = Company::findOrFail($user->company_id);

        $this->company_id = $this->company->id;

        $this->roles = Role::where('type', 'company')->get();

        return view('livewire..company.user-create');
    }

    public function save(): void
    {
        $role = intval($this->role_id);

        $request = new Request();
        $request->merge([
            'user' => [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
            ],
            'roles' => [
                $role,
            ],
        ]);

        $request = app(UserCreateAction::class)->execute($this->company_id, $request);

        if ($request->getStatusCode() == 200) {
            $this->modalSuccess = true;
        } else {
            $this->errorModal = true;
        }

    }

    public function hideModalError()
    {
        $this->errorModal = false;
    }

    public function hideModalSuccess()
    {
        $this->modalSuccess = false;
    }

    public function createAnotherUser()
    {
        $this->user = '';
        $this->email = '';
        $this->password = '';

        $this->modalSuccess = false;
    }
}
