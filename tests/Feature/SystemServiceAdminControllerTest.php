<?php

namespace Tests\Feature;

use App\Models\SystemService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SystemServiceAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private array $service = [
        'service_name' => 'system service',
        'service_price' => '100'
        ];

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testIndex(): void
    {
        SystemService::factory()->create($this->service);

        $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(route('system_service.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([[
            'service_name',
            'service_price'
        ]]);
    }

    public function testStore(): void
    {
        $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('system_service.store'),$this->service);

        $response->assertStatus(200);

        $response->assertJson(['message' => 'success']);

        $this->assertDatabaseHas('system_services', [
            'service_name' => $this->service['service_name']
        ]);
    }

    public function testStoreErrorDuplicatedServiceName(): void
    {
        SystemService::factory()->create($this->service);

        $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('system_service.store'),$this->service);

        $response->assertStatus(500);
    }

}
