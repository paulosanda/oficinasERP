<?php

namespace Tests\Feature;

use App\Models\Company;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private User|Collection|Model $user;
    private Company|Collection|Model $company;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', [RoleSeeder::class]);
        $this->company = Company::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testUserCreate(): void
    {
        $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('admin.user.create', $this->company->id), [
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

        $this->assertDatabaseCount('user_roles', 3);

    }

    public function testCreateUserErrorNoAbility(): void
    {
        $token = $this->user->createToken('teste', ['master'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('admin.user.create', $this->company->id), [
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
