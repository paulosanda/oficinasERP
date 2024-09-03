<?php

namespace App\Livewire\Company;

use App\Actions\ScheduleServiceCreateAction;
use App\Models\Customer;
use App\Models\SchedulableService;
use App\Models\Vehicle;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SchedulableServiceCreate extends Component
{
    public int $customerId;

    public int $companyId;

    public int $vehicleId = 0;

    public array $scheduleService = [];

    public bool $confirmModal = false;

    public bool $errorModal = false;

    public string $successMessage = '';

    public string $errorMessage = '';

    public bool $successModal = false;

    public SchedulableService|Collection $schedulableServices;

    public Customer $customer;

    public Vehicle $vehicle;

    public array $selectedServices = [];

    public function mount($customerId): void
    {
        $this->companyId = Auth::user()->company_id;

        $this->customerId = $customerId;

        $this->schedulableServices = SchedulableService::all();

        $this->customer = Customer::findOrFail($customerId);

        $this->scheduleService[] = [
            'schedulable_service_id' => '',
            'scheduled_date' => '',
            'reminder_active' => 0,
            'observation' => '',
            'current_mileage' => 0,
            'expected_mileage' => 0,
        ];

        if ($this->customer->vehicle->count() == 1) {
            $this->vehicleId = $this->customer->vehicle->first()->id;
        }
    }

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.company.schedulable-service-create');
    }

    public function addScheduleService(): void
    {

        $this->scheduleService[] = [
            'schedulable_service_id' => '',
            'scheduled_date' => '',
            'reminder_active' => 0,
            'observation' => '',
            'current_mileage' => 0,
            'expected_mileage' => 0,
        ];
    }

    public function removeScheduleService($index): void
    {
        $remove = $this->scheduleService[$index]['schedulable_service_id'];
        $this->selectedServices = array_filter($this->selectedServices, function ($value) use ($remove) {
            return $value !== $remove;
        });

        unset($this->scheduleService[$index]);
    }

    public function updatedScheduleService($value, $key): void
    {
        $this->selectedServices = array_filter(array_column($this->scheduleService, 'schedulable_service_id'));
    }

    public function save(): void
    {
        foreach ($this->scheduleService as $schedule) {
            try {
                $request = new Request();
                $request->merge([
                    'vehicle_id' => $this->vehicleId,
                    'company_id' => $this->companyId,
                    'customer_id' => $this->customerId,
                    'schedulable_service_id' => intval($schedule['schedulable_service_id']),
                    'scheduled_date' => $schedule['scheduled_date'],
                    'reminder_active' => $schedule['reminder_active'],
                    'observation' => $schedule['observation'],
                    'current_mileage' => intval($schedule['current_mileage']),
                    'expected_mileage' => intval($schedule['expected_mileage']),
                ]);

                app(ScheduleServiceCreateAction::class)->execute($request);

                $this->successMessage = 'Serviços agendados com sucesso';

                $this->successModal = true;
                //fazer na blade view o botão para mostrar todas os agendamentos do cliente
            } catch (\Exception $exception) {
                $this->errorMessage = $exception->getMessage();
                $this->errorModal = true;
            }
        }
    }

    public function showConfirmModal(): void
    {
        $this->vehicle = Vehicle::findOrFail($this->vehicleId);

        $this->confirmModal = true;
    }

    public function hideConfirmModal(): void
    {
        $this->confirmModal = false;
    }

    public function hideSuccessModal(): void
    {
        $this->successModal = false;
        $this->confirmModal = false;
    }

    public function hideErrorModal(): void
    {
        $this->errorModal = false;
    }
}
