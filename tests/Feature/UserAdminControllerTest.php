<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private User|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $user;
    private Client|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $client;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed' ,[RoleSeeder::class]);
        $this->client = Client::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testUserCreate(): void
    {
        $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('admin.user.create', $this->client->id),[
            'user' => [
                'name' => fake()->name,
                'email' => fake()->email,
                'password' => fake()->password
            ],
            'roles' => [3, 2]
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'usuário criado com sucesso'
        ]);

        $this->assertDatabaseCount('client_users', 1);

        $this->assertDatabaseCount('user_roles', 3);
    }

}
