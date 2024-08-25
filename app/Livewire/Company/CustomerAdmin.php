<?php

namespace App\Livewire\Company;

use App\Actions\CustomerUpdateAction;
use App\Models\Customer;
use App\Trait\RequestAddress;
use Illuminate\Http\Request;
use Livewire\Component;

class CustomerAdmin extends Component
{
    use RequestAddress;

    public string $company_id = '';

    public string $customer_id = '';

    public string $name = '';

    public ?string $email = '';

    public ?string $cellphone = '';

    public string $type = '';

    public ?string $cpf = '';

    public ?string $cnpj = '';

    public ?string $inscricao_estadual = '';

    public ?string $inscricao_municipal = '';

    public ?string $birthday = '';

    public ?string $postal_code = '';

    public ?string $address = '';

    public ?string $number = '';

    public ?string $city = '';

    public ?string $neighborhood = '';

    public ?string $state = '';

    public $searchName = '';

    public $searchEmail = '';

    public $searchCellphone = '';

    public bool $modalSuccess = false;

    public bool $editModal = false;

    public bool $modalError = false;

    public string $error_message = '';

    public function render()
    {
        $user = auth()->user();

        $query = Customer::where('company_id', $user->company_id);

        if ($this->searchName) {
            $query->where('name', 'like', '%'.$this->searchName.'%');
        }

        if ($this->searchEmail) {
            $query->where('email', 'like', '%'.$this->searchEmail.'%');
        }

        if ($this->searchCellphone) {
            $query->where('cellphone', 'like', '%'.$this->searchCellphone.'%');
        }

        $customers = $query->orderBy('name')->paginate(10);

        return view('livewire.company.customer-admin')->with(['customers' => $customers]);
    }

    public function editCustomer($customerId)
    {
        $this->editModal = true;
        $customer = Customer::findOrFail($customerId);

        $this->company_id = $customer->company_id;
        $this->customer_id = $customerId;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->cellphone = $customer->cellphone;
        $this->type = $customer->type;
        $this->postal_code = $customer->postal_code;
        $this->address = $customer->address;
        $this->number = $customer->number;
        $this->neighborhood = $customer->neighborhood;
        $this->city = $customer->city;
        $this->state = $customer->state;

        if ($this->type == 'pf') {
            $this->cpf = $customer->cpf;
        } elseif ($this->type == 'pj') {
            $this->cnpj = $customer->cnpj;
            $this->inscricao_estadual = $customer->inscricao_estadual;
            $this->inscricao_municipal = $customer->inscricao_municipal;
        }
        $this->birthday = $customer->birthday;
    }

    public function hideEditModal(): void
    {
        $this->editModal = false;
    }

    public function updateCustomer(): void
    {
        $user = auth()->user();

        $this->editModal = false;

        $request = new Request();
        $request->merge([
            'id' => $this->customer_id,
            'company_id' => $this->company_id,
            'name' => $this->name,
            'email' => $this->email,
            'cellphone' => $this->cellphone,
            'birthday' => $this->birthday,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'neighborhood' => $this->neighborhood,
            'number' => $this->number,
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
            $response = app(CustomerUpdateAction::class)->execute($request);

            if ($response->getStatusCode() == 200) {
                $this->modalSuccess = true;
            } else {
                $this->modalError = true;
            }
        } catch (\Exception $exception) {
            $this->error_message = $exception->getMessage();
            $this->modalError = true;
        }

    }

    public function hideModalSuccess(): void
    {
        $this->modalSuccess = false;
    }

    public function hideModalError(): void
    {
        $this->modalError = false;
    }
}
