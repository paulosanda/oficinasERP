<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'razao_social' => fake()->name,
            'cnpj' => fake()->numerify('###.###.###/0001-##'),
            'inscricao_estadual' => fake()->numerify('###.###.###-##'),
            'inscricao_municipal' => fake()->numerify('###.###.###'),
            'endereco' => fake()->streetAddress,
            'numero' => fake()->numerify,
            'bairro' =>fake()->name,
            'cep' => fake()->postcode,
            'cidade' => fake()->city,
            'estado' => 'SP',
            'celular' => fake()->numerify('##-##### ###'),
            'email' => fake()->email
        ];
    }
}
