<?php

namespace App\Livewire\Company;

use App\Models\Customer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SchedulableServiceCreate extends Component
{
    public int $customerId;

    public int $companyId;

    public Customer $customer;

    public function mount($customerId): void
    {
        $this->companyId = Auth::user()->company_id;

        $this->customerId = $customerId;

        $this->customer = Customer::findOrFail($customerId);
    }

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.company.schedulable-service-create');
    }
}
