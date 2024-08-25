<?php

namespace App\Livewire\Company;

use App\Actions\CustomerCreateAction;
use App\Models\Company;
use App\Trait\RequestAddress;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CustomerCreate extends Component
{
    use RequestAddress;

    #[Validate('string|required')]
    public string $type = '';

    public int $company_id;

    public string $name = '';

    public string $email = '';

    public string $cellphone = '';

    public string $telephone = '';

    public string $cpf = '';

    public string $rg = '';

    public string $cnpj = '';

    public string $inscricao_estadual = '';

    public string $inscricao_municipal = '';

    public string $birthday = '';

    public string $address = '';

    public string $number = '';

    public string $neighborhood = '';

    public string $postal_code = '';

    public string $city = '';

    public string $state = '';

    public $company;

    public bool $modalError = false;

    public bool $modalConfirm = false;

    public bool $modalSuccess = false;

    public string $errorMessage = '';

    private bool $pointer = false;

    public function render()
    {
        $user = auth()->user();
        $this->company_id = $user->company_id;
        $this->company = Company::find($this->company_id);

        return view('livewire.company.customer-create');
    }

    public function updatedType($value): void
    {
        $this->type = $value;
    }

    public function confirm(): void
    {
        $this->checkIsNull($this->type, 'tipo de pessoa é obrigatório');
        $this->checkIsNull($this->name, 'nome é obrigatório');
        $this->modalConfirm = $this->pointer;
    }

    public function hideModalConfirm(): void
    {
        $this->modalConfirm = false;
    }

    public function hideModalError()
    {
        $this->modalError = false;
    }

    private function checkIsNull($value, string $message): void
    {
        if ($value == null) {
            $this->errorMessage = $message;
            $this->modalError = true;
            $this->pointer = false;
        } else {
            $this->pointer = true;
        }
    }

    public function hideModalSuccess(): void
    {
        $this->modalSuccess = false;
    }

    public function save(): void
    {
        $request = new Request();
        $request->merge([
            'type' => $this->type,
            'company_id' => $this->company_id,
            'name' => $this->name,
            'email' => $this->email,
            'cellphone' => $this->cellphone,
            'birthday' => $this->birthday,
            'address' => $this->address,
            'number' => $this->number,
            'neighborhood' => $this->neighborhood,
            'postal_code' => $this->postal_code,
            'city' => $this->city,
            'state' => $this->state,

        ]);

        if ($this->type == 'pf') {
            $request->merge([
                'cpf' => $this->cpf,
            ]);
        } elseif ($this->type == 'pj') {
            $request->merge([
                'cnpj' => $this->cnpj,
                'inscricao_estadual' => $this->inscricao_estadual,
                'inscricao_municipal' => $this->inscricao_municipal,
            ]);
        }

        try {
            $customer = app(CustomerCreateAction::class)->execute($request);

            $this->modalSuccess = true;
        } catch (\Exception $exception) {
            $this->errorMessage = $exception->getMessage();
            $this->modalError = true;
        }

    }
}
