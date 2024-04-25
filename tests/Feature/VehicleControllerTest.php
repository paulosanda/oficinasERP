<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleControllerTest extends TestCase
{
    use RefreshDatabase;

    private User|Collection|Model $user;
    private Company|Collection|Model $company;

    private Customer|Collection|Model $customer;
    public function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->create();
        $this->user = User::factory()->create([
            'company_id' => $this->company->id
        ]);
        $this->customer = Customer::factory()->create([
            'company_id' => $this->company->id
        ]);
    }

    public function testCreateVehicle(): void
    {
        $token = $this->user->createToken('test', ['master', 'operator'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('customer.vehicle.store'), $this->vehicle());

        $response->assertStatus(200);

        $this->assertDatabaseCount('vehicles', 1);
    }

    public function testeCreateVehicleErrorInvalidCredencials(): void
    {
        $token = $this->user->createToken('test', ['error'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('customer.vehicle.store'));

        $response->assertStatus(403);

        $response->assertJson(['message' => 'Invalid ability provided.']);

        $this->assertDatabaseEmpty('vehicles');
    }

    private function vehicle(): array
    {
        $brand = $this->brand();
        $model = $this->model($brand);
        $km = fake()->numberBetween('###');

        return [
            'customer_id' => $this->customer->id,
            'brand' => $brand,
            'model' => $model,
            'color' => fake()->colorName,
            'year' => fake()->date('Y'),
            'plate' => $this->plate(),
            'identification_number' => $this->chassi(),
            'renavam' => $this->renavam(),
            'monthly_mileage' => strval($km),
            'observation' => fake()->text,
        ];
    }

    private function brand(): string
    {
        $brand = [
            'Honda',
            'Toyota',
            'Volkswagen',
            'Fiat'
        ];

        $index = fake()->numberBetween(0, 3);

        return $brand[$index];
    }

    private function model($brand): string
    {
        $model = [
            'Honda' => 'Civic',
            'Toyota' => 'Lexus',
            'Volkswagen' => 'Fox',
            'Fiat' => 'Toro'
        ];

        return $model[$brand];
    }

    private function plate(): string
    {
        $plates = [
            "AAA1A11",
            "BBB2B22",
            "CCC3C33",
            "DDD4D44",
            "EEE5E55",
            "FFF6F66",
            "GGG7G77",
            "HHH8H88",
            "III9I99",
            "JJJ0J00"
        ];

        $index = fake()->numberBetween(0, 9);

        return $plates[$index];
    }

    private function chassi(): string
    {
        $chassi = [
            "1HGCM82633A003569",
            "5NPEB4ACXCH462566",
            "JTEBU14R290153061",
            "WAUZZZ8K3CA090190",
            "1FTFW1CF5EFA02085",
            "JTJBT20X440065783",
            "WDDNG7DB7BA372992",
            "5TFEY5F10BX108057",
            "1GYS3BEF5DR210485",
            "3FA6P0HDXGR288553"
        ];

        $index = fake()->numberBetween(0, 9);

        return $chassi[$index];
    }

    public function renavam(): string
    {
        $renavam = [
            "12345678901",
            "23456789012",
            "34567890123",
            "45678901234",
            "56789012345",
            "67890123456",
            "78901234567",
            "89012345678",
            "90123456789",
            "01234567890"
        ];

        $index = fake()->numberBetween(0, 9);

        return $renavam[$index];
    }
}
