<?php

namespace Database\Factories;

use App\Models\Checkup;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Checkup>
 */
class CheckupFactory extends Factory
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

        $fuel = ['vazio', '1/4', '1/2', '3/4', 'cheio'];

        $evaluation = ['aprovado para uso', 'manutenção recomendada'];

        return [
            'company_id' => $company->id,
            'customer_id' => $customer->id,
            'vehicle_id' => $vehicle->id,
            'front_damage' => fake()->text,
            'front_photo' => fake()->url,
            'back_damage' => fake()->text,
            'back_photo' => fake()->url,
            'right_side_damage' => fake()->text,
            'right_side_photo' => fake()->url,
            'left_side_damage' => fake()->text,
            'left_side_photo' => fake()->url,
            'roof_damage' => fake()->text,
            'roof_photo' => fake()->url,
            'fuel_gauge' => fake()->randomElement($fuel),
            'fuel_gauge_photo' => fake()->url,
            'evaluation' => fake()->randomElement($evaluation),
        ];
    }
}
