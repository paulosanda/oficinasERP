<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Customer;
use App\Models\SchedulableService;
use App\Models\ScheduledService;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScheduledService>
 */
class ScheduledServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = Company::factory()->create();
        $customer = Customer::factory()->create(['company_id' => $company->id]);
        $vehicle = Vehicle::factory()->create(['customer_id' => $customer->id]);
        $schedulableService = SchedulableService::inRandomOrder()->first();

        return [
            'vehicle_id' => $vehicle->id,
            'company_id' => $company->id,
            'customer_id' => $customer->id,
            'schedulable_service_id' => $schedulableService->id,
            'scheduled_date' => $this->faker->date(),
            'reminder_active' => $this->faker->boolean(),
            'observation' => $this->faker->text(),
            'current_mileage' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
