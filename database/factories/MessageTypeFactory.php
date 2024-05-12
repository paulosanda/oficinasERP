<?php

namespace Database\Factories;

use App\Models\MessageType;
use App\Models\SchedulableService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MessageType>
 */
class MessageTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $schedulableService = SchedulableService::factory()->create();

        return [
            'schedulable_service_id' => $schedulableService->id,
            'model_name' => fake()->word(),
            'title' => fake()->title(),
            'message' => fake()->text
        ];
    }
}
