<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customer::factory()->create();

        $marca = [
            'Honda',
            'Toyota',
            'Volkswagen',
            'Fiat',
        ];

        $modelo = [
            'Honda' => 'Civic',
            'Toyota' => 'Lexus',
            'Volkswagen' => 'Fox',
            'Fiat' => 'Toro',
        ];

        $placas = [
            'AAA1A11',
            'BBB2B22',
            'CCC3C33',
            'DDD4D44',
            'EEE5E55',
            'FFF6F66',
            'GGG7G77',
            'HHH8H88',
            'III9I99',
            'JJJ0J00',
        ];

        $chassi = [
            '1HGCM82633A003569',
            '5NPEB4ACXCH462566',
            'JTEBU14R290153061',
            'WAUZZZ8K3CA090190',
            '1FTFW1CF5EFA02085',
            'JTJBT20X440065783',
            'WDDNG7DB7BA372992',
            '5TFEY5F10BX108057',
            '1GYS3BEF5DR210485',
            '3FA6P0HDXGR288553',
        ];

        $renavam = [
            '12345678901',
            '23456789012',
            '34567890123',
            '45678901234',
            '56789012345',
            '67890123456',
            '78901234567',
            '89012345678',
            '90123456789',
            '01234567890',
        ];

        $km = fake()->numberBetween('###');

        return [
            'customer_id' => $customer->id,
            'brand' => fake()->randomElement($marca),
            'model' => $modelo[fake()->randomElement($marca)],
            'color' => fake()->colorName,
            'year' => fake()->date('Y'),
            'plate' => fake()->randomElement($placas),
            'identification_number' => fake()->randomElement($chassi),
            'renavam' => fake()->randomElement($renavam),
            'monthly_mileage' => strval($km),
            'observation' => fake()->text,
        ];
    }
}
