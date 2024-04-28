<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = Company::factory()->create();
        return [
            'company_id' => $company->id,
            'type' => 'pf',
            'name' => fake()->name,
            'email' => fake()->email,
            'cellphone' => fake()->phoneNumber,
            'telephone' => fake()->phoneNumber,
            'cpf' => fake()->numerify('###.###.###-##'),
            'birthday' => fake()->date(),
            'profession' => 'ocupação',
            'address' => fake()->streetAddress,
            'number' => fake()->numberBetween(1,100),
            'postal_code' => fake()->postcode,
            'neighborhood' => fake()->name,
            'city' => fake()->city,
            'estate' => 'TO',
        ];
    }
}
