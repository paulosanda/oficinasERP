<?php

namespace App\Livewire;

use App\Actions\CompanyCreateAction;
use App\Trait\RequestAddress;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateCompany extends Component
{
    use RequestAddress, WithFileUploads;

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

    #[Validate('image|nullable')]
    public $logo = null;

    #[Validate('string|required')]
    public string $name = '';

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.create-company');
    }

    public function save()
    {
        $request = new Request();
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
            'logo' => $this->logo,
        ]);

        $newCompany = app(CompanyCreateAction::class)->execute($request);

        $company = $newCompany->original;

        return redirect()->route('company.create.user', $company->id);

    }
}
