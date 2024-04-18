<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Checkup>
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
        $vehicle = Vehicle::factory()->create();

        $combustivel = ['vazio', '1/4','1/2','3/4', 'cheio'];

        $avaliacao = ['aprovado para uso', 'manutenção recomendada'];

        return [
            'vehicle_id' => $vehicle->id,
            'avarias_frente' => fake()->text,
            'av_frente_foto' => fake()->url,
            'avarias_traseiro' => fake()->text,
            'av_traseira_foto' => fake()->url,
            'avarias_direito' => fake()->text,
            'av_direito_foto' => fake()->url,
            'avarias_esquerdo' => fake()->text,
            'av_esquerdo_foto' => fake()->url,
            'avarias_teto' => fake()->text,
            'av_teto_foto' => fake()->url,
            'combustivel' => fake()->randomElement($combustivel),
            'combustivel_foto' => fake()->url,
            'avaliacao' => fake()->randomElement($avaliacao)
        ];
    }
}
