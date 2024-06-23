<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\SchedulableServiceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SchedulableServiceAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed', [SchedulableServiceSeeder::class]);

        $this->user = User::factory()->create();
    }

    public function testIndex(): void
    {
        $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson(route('schedulable_services.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([['service']]);
    }

    public function testIndexErrorAbility(): void
    {
        $token = $this->user->createToken('teste', ['master'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson(route('schedulable_services.index'));

        $response->assertStatus(403);
    }

    public function store(): void
    {
        $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('schedulable_services.store'), ['service test']);

        $response->assertStatus(200);

        $response->assertJson(['message' => 'success']);

        $this->assertDatabaseHas('schedulable_services', [
            'service' => 'service test',
        ]);
    }

    public function testUpdate(): void
    {
        $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->patchJson(route('schedulable_services.update', 1), ['service' => 'updated']);

        $response->assertStatus(200);

        $response->assertJson(['message' => 'success']);

        $this->assertDatabaseHas('schedulable_services', [
            'service' => 'updated',
        ]);
    }
}
