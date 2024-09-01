<?php

namespace App\Livewire\Company;

use App\Models\Customer;
use App\Models\SchedulableService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SchedulableServiceCreate extends Component
{
    public int $customerId;

    public int $companyId;

    public int $vehicleId;

    public SchedulableService|Collection $schedulableServices;

    public Customer $customer;

    public function mount($customerId): void
    {
        $this->companyId = Auth::user()->company_id;

        $this->customerId = $customerId;

        $this->schedulableServices = SchedulableService::all();

        $this->customer = Customer::findOrFail($customerId);
    }

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.company.schedulable-service-create');
    }
}
