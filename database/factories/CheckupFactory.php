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

        $fuel = ['vazio', '1/4','1/2','3/4', 'cheio'];

        $evaluation = ['aprovado para uso', 'manutenção recomendada'];

        return [
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
            'evaluation' => fake()->randomElement($evaluation)
        ];
    }
}
