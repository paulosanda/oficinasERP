<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private User|Collection|Model $user;
    private Client|Collection|Model $client;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', [RoleSeeder::class]);
        $this->client = Client::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testUserCreate(): void
    {
        $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('admin.user.create', $this->client->id), [
            'user' => [
                'name' => fake()->name,
                'email' => fake()->email,
                'password' => fake()->password
            ],
            'roles' => [3, 2]
        ]);
        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'success'
        ]);

        $this->assertDatabaseCount('client_users', 1);

        $this->assertDatabaseCount('user_roles', 3);
    }

    public function testCreateUserErrorNoAbility(): void
    {
        $token = $this->user->createToken('teste', ['master'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('admin.user.create', $this->client->id), [
            'user' => [
                'name' => fake()->name,
                'email' => fake()->email,
                'password' => fake()->password
            ],
            'roles' => [3, 2]
        ]);

        $response->assertStatus(403);

        $response->assertJson(['message' => 'Invalid ability provided.']);

        $this->assertDatabaseCount('users', 2);
    }
}
