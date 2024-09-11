<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Actions\CompanyUpdateAction;
use App\Actions\UserUpdateAction;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Trait\RequestAddress;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[AllowDynamicProperties] class CompaniesAdmin extends Component
{
    use RequestAddress, WithFileUploads;

    #[Validate('int|required')]
    public int $company_id;

    #[Validate('image|nullable')]
    public $logo = null;

    #[Validate('string|required')]
    public string $company_name = '';

    #[Validate('string|required')]
    public string $cnpj = '';

    #[Validate('string|required')]
    public string $inscricao_estadual = '';

    #[Validate('string|required')]
    public string $inscricao_municipal = '';

    #[Validate('string|required')]
    public string $postal_code = '';

    #[Validate('string|required')]
    public string $address = '';

    #[Validate('string|required')]
    public string $number = '';

    #[Validate('string|nullable')]
    public string $neighborhood = '';

    #[Validate('string|required')]
    public string $city = '';

    #[Validate('string|required')]
    public string $state = '';

    #[Validate('email|required')]
    public string $email = '';

    #[Validate('string|required')]
    public string $cellphone = '';

    public string $name = '';

    public $roles;

    public string $password = '';

    public int $user_id = 0;

    public User $userToEdit;

    public ?Company $selectedCompany = null;

    public ?User $user;

    public array $selectedRoles;

    public bool $showModalEditCompany = false;

    public bool $showModelEditCompanySuccess = false;

    public bool $modalEditUser = false;

    public bool $modalEditUserSuccess = false;

    public function hideCompanyEditSuccess(): void
    {
        $this->showModelEditCompanySuccess = false;
    }

    public function showCompanyToEdit(): void
    {
        if ($this->selectedCompany) {
            $this->company_id = $this->selectedCompany->id;
            $this->company_name = $this->selectedCompany->company_name;
            $this->cnpj = $this->selectedCompany->cnpj;
            $this->inscricao_estadual = $this->selectedCompany->inscricao_estadual;
            $this->inscricao_municipal = $this->selectedCompany->inscricao_municipal;
            $this->postal_code = $this->selectedCompany->postal_code;
            $this->address = $this->selectedCompany->address;
            $this->number = $this->selectedCompany->number;
            $this->neighborhood = $this->selectedCompany->neighborhood;
            $this->city = $this->selectedCompany->city;
            $this->state = $this->selectedCompany->state;
            $this->email = $this->selectedCompany->email;
            $this->cellphone = $this->selectedCompany->cellphone;
        }

        $this->showModalEditCompany = true;
    }

    public function hideCompanyToEdit(): void
    {
        $this->showModalEditCompany = false;
    }

    public function hideConfirmationModal(): void
    {
        $this->showModelEditCompanySuccess = false;

        $this->selectedCompany = null;

    }

    public function showModalEditUser($userId): void
    {
        $this->userToEdit = User::find($userId);

        $this->modalEditUser = true;

        $this->user_id = $this->userToEdit->id;

        $this->name = $this->userToEdit->name;

        $this->email = $this->userToEdit->email;

        $this->roles = Role::where('type', 'company')->get();

        $this->selectedRoles = $this->userToEdit->roles->pluck('id')->toArray();

    }

    public function hideModalEditUser(): void
    {
        $this->modalEditUser = false;
    }

    public function updateCompany(): void
    {
        $request = new Request;
        $request->merge([
            'company_name' => $this->company_name,
            'cnpj' => $this->cnpj,
            'inscricao_estadual' => $this->inscricao_estadual,
            'inscricao_municipal' => $this->inscricao_municipal,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'number' => $this->number,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'email' => $this->email,
            'cellphone' => $this->cellphone,
            //            'logo' => $this->logo, Ainda não implementado
        ]);

        $updateCompany = app(CompanyUpdateAction::class)->execute($request, $this->company_id);

        if ($updateCompany->getStatusCode() == 200) {
            $this->showModalEditCompany = false;

            $this->showModelEditCompanySuccess = true;

        }

        $this->companies = Company::orderBy('company_name', 'asc')->paginate(10);

    }

    public function selectCompanyMethod($companyId): void
    {
        $this->selectedCompany = Company::find($companyId);
        $this->companies = null;
    }

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {

        $this->companies = Company::orderBy('company_name', 'asc')->paginate(10);

        return view('livewire.companies-admin')->with([
            'companies' => $this->companies,
        ]);
    }

    public function updateUser(): void
    {
        $rolesToInteger = array_map('intval', $this->selectedRoles);

        $roles = array_map(function ($id) {
            return ['id' => $id];
        }, $rolesToInteger);

        $request = new Request;
        $request->merge([
            'id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $roles,
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

        $this->selectedCompany = null;

    }

    public function alterActiveState(): void
    {
        $newActiveState = $this->selectedCompany->active ? 0 : 1;

        $this->selectedCompany->update(['active' => $newActiveState]);
    }
}
