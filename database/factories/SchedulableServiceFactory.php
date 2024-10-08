<?php

namespace Database\Factories;

use App\Models\MessageType;
use App\Models\SchedulableService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SchedulableService>
 */
class SchedulableServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $messageType = MessageType::factory()->create();

        return [
            'service' => fake()->word,
        ];
    }
}
