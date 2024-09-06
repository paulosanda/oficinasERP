<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Actions\UserCreateAction;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[AllowDynamicProperties] class CreateUser extends Component
{
    #[Validate('string|required')]
    public string $name = '';

    #[Validate('email|required')]
    public string $email = '';

    #[Validate('string|required')]
    public string $password = '';

    #[Validate('string|required')]
    public string $role_id = '';

    #[Validate('int|required')]
    public int $company_id = 0;

    private bool $returned = false;

    public bool $userCreateError = false;

    public bool $userCreateSuccess = false;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $roles = Role::where('type', 'company')->get();

        $company = Company::find($this->company_id);

        if (! $this->userCreateError && ! $this->returned) {
            $this->company_id = request()->route('company_id');
        }

        return view('livewire.create-user')->with([
            'roles' => $roles,
            'company' => $company]);
    }

    public function save(): ?RedirectResponse
    {

        $role = intval($this->role_id);

        $request = new Request;
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
            //            return redirect()->route('company.admin');
            $this->returned = true;
            $this->userCreateSuccess = true;
        } else {
            $this->userCreateError = true;
        }

        return null;
    }

    public function hideModalError(): void
    {
        $this->userCreateError = false;

        $this->returned = true;
    }

    public function createAnotherUser()
    {
        $this->userCreateSuccess = false;
        $this->returned = true;
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }
}
