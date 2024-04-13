<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
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
            "company_id" => $company->id,
            'name' => fake()->name,
            'email' => fake()->email,
            'celular' => fake()->phoneNumber,
            'telefone' => fake()->phoneNumber,
            'cpf' => fake()->numerify('###.###.###-##'),
            'nascimento' => fake()->date(),
            'profissao' => 'ocupação',
            'endereco' => fake()->streetAddress,
            'numero' => fake()->numberBetween(1,100),
            'cep' => fake()->postcode,
            'bairro' => fake()->name,
            'cidade' => fake()->city,
            'estado' => 'TO',
        ];
    }
}
