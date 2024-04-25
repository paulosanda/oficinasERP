<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => fake()->name,
            'cnpj' => fake()->numerify('###.###.###/0001-##'),
            'inscricao_estadual' => fake()->numerify('###.###.###-##'),
            'inscricao_municipal' => fake()->numerify('###.###.###'),
            'address' => fake()->streetAddress,
            'number' => fake()->numerify,
            'neighborhood' =>fake()->name,
            'postal_code' => fake()->postcode,
            'city' => fake()->city,
            'estate' => 'SP',
            'cellphone' => fake()->numerify('##-##### ###'),
            'email' => fake()->email
        ];
    }
}
