<?php

namespace App\Livewire\Company;

use App\Models\Customer;
use Livewire\Component;

class CustomerAdmin extends Component
{
    public bool $editModal = false;

    public function render()
    {
        $user = auth()->user();

        $customers = Customer::where('company_id', $user->company_id)->paginate(10);

        return view('livewire.company.customer-admin')->with(['customers' => $customers]);
    }

    public function editCustomer($customerId)
    {
        dd($customerId);
    }
}
