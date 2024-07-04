<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
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
            'logo' => fake()->word,
            'company_name' => fake()->name,
            'cnpj' => fake()->numerify('###.###.###/0001-##'),
            'inscricao_estadual' => fake()->numerify('###.###.###-##'),
            'inscricao_municipal' => fake()->numerify('###.###.###'),
            'address' => fake()->streetAddress,
            'number' => fake()->numerify,
            'neighborhood' => fake()->name,
            'postal_code' => fake()->postcode,
            'city' => fake()->city,
            'state' => 'SP',
            'cellphone' => fake()->numerify('##-##### ###'),
            'email' => fake()->email,
        ];
    }
}
