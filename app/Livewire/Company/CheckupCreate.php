<?php

namespace App\Livewire\Company;

use App\Actions\CheckupCreateAction;
use App\Actions\VehicleCreateAction;
use App\Models\Checkup;
use App\Models\CheckupObservationType;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;

class CheckupCreate extends Component
{
    #[Url]
    public ?int $customer_id;

    public string $brand = '';

    public string $model = '';

    public string $color = '';

    public string $year = '';

    public string $plate = '';

    public string $renavam = '';

    public string $observation = '';

    public string $front_damage = '';

    public string $back_damage = '';

    public string $right_side_damage = '';

    public string $left_side_damage = '';

    public string $roof_damage = '';

    public string $fuel_gauge = '';

    public Collection $vehicles;

    public Vehicle $vehicle;

    public array $checkup_observations = [];

    public $checkupObservations;

    public bool $modalConfirm = false;

    public bool $vehicleSelected = false;

    public bool $confirmVehicleModal = false;

    public bool $errorModal = false;

    public string $errorMessage = '';

    public bool $successModal = false;

    public bool $newVehicle = false;

    public int $vehicle_id;

    public int $checkup_id;

    public string $vehicleObservation = '';

    public string $successMessage = '';

    public string $pending = Checkup::EVALUATION_PENDING;

    public string $op = '';

    public function mount($customerId): void
    {
        if (request()->get('op')) {
            $this->op = request()->get('op');
        }

        $this->customer_id = $customerId;
    }

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $customer = Customer::find($this->customer_id);
        $this->customer_id = $customer->id;

        $this->vehicles = Vehicle::where('customer_id', $customer->id)->get();

        $this->checkupObservations = CheckupObservationType::all();

        return view('livewire.company.checkup-create')->with([
            'customer' => $customer,
            'vehicles' => $this->vehicles,
            'customer_id' => $this->customer_id,
            'checkupObservations' => $this->checkupObservations,
        ]);
    }

    public function confirm(): void
    {
        $this->modalConfirm = true;
    }

    public function hideModalConfirm(): void
    {
        $this->modalConfirm = false;
    }

    public function confirmVehicle(): void
    {
        $this->confirmVehicleModal = true;
    }

    public function hideConfirmVehicleModal(): void
    {
        $this->confirmVehicleModal = false;
    }

    public function saveVehicle()
    {
        $request = new Request;
        $request->merge([
            'customer_id' => $this->customer_id,
            'brand' => $this->brand,
            'model' => $this->model,
            'color' => $this->color,
            'year' => $this->year,
            'plate' => $this->plate,
            'renavam' => $this->renavam,
            'observation' => $this->observation,
        ]);

        try {
            $response = app(VehicleCreateAction::class)->execute($request);

            $this->vehicle_id = $response->getData()->vehicle_id;

            $this->setVehicle();

            $this->confirmVehicleModal = false;

            $this->newVehicle = true;

            if ($this->op == 'schedule') {
                return redirect()->route('web.schedule.create', $this->customer_id);
            }

        } catch (\Exception $exception) {
            $this->errorMessage = $exception->getMessage();

            $this->errorModal = true;
        }

    }

    public function setVehicle(): void
    {
        $vehicle = Vehicle::find($this->vehicle_id);

        $this->brand = $vehicle->brand;
        $this->model = $vehicle->model;
        $this->color = $vehicle->color;
        $this->year = $vehicle->year;
        $this->plate = $vehicle->plate;
        $this->renavam = $vehicle->renavam;
        $this->vehicleObservation = $vehicle->observation;

        $this->vehicleSelected = true;

    }

    public function hideModalError(): void
    {
        $this->errorModal = false;
    }

    public function hideModalSuccess(): void
    {
        $this->successModal = false;
        $this->modalConfirm = false;
    }

    public function save(): void
    {
        $request = new Request;
        $request->merge([
            'vehicle_id' => $this->vehicle_id,
            'customer_id' => $this->customer_id,
            'company_id' => Auth::user()->company_id,
            'front_damage' => $this->front_damage,
            'back_damage' => $this->back_damage,
            'right_side_damage' => $this->right_side_damage,
            'left_side_damage' => $this->left_side_damage,
            'roof_damage' => $this->roof_damage,
            'fuel_gauge' => $this->fuel_gauge,
            'evaluation' => $this->pending,
        ]);

        $checkupObservationsFormatted = [];
        foreach ($this->checkup_observations as $id => $observation) {
            $checkupObservationsFormatted[] = [
                'checkup_observation_type_id' => $id,
                'observation' => $observation,
            ];
        }

        $request->merge([
            'checkup_observation' => $checkupObservationsFormatted,
        ]);

        try {
            $response = app(CheckupCreateAction::class)->execute($request);

            $this->checkup_id = $response->getData()->checkupId;

            $this->successMessage = 'Checkup registrado com sucesso.';

            $this->successModal = true;

        } catch (\Exception $exception) {
            $this->errorMessage = $exception->getMessage();
            $this->errorModal = true;
        }
    }
}
