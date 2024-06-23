<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {

        parent::setUp();
        $this->user = User::factory()->create();

        Artisan::call('db:seed', [RoleSeeder::class]);

    }

    public function testStore(): void
    {
        $token = $this->user->createToken('teste', ['master'])->plainTextToken;

        $newUser = $this->newUserData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('company_user.store'), $newUser);

        $response->assertStatus(200);

        $response->assertJson(['message' => 'success']);

        $this->assertDatabaseHas('users', [
            'company_id' => $this->user->company_id,
            'name' => $newUser['user']['name'],
            'email' => $newUser['user']['email'],
        ]);
    }

    public function testStoreErrorNoName(): void
    {
        $newUser = $this->newUserData();

        $newUser['user']['name'] = null;

        $token = $this->user->createToken('teste', ['operator'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ', $token,
        ])->postJson(route('company_user.store'), $newUser);

        $response->assertStatus(401);

    }

    public function testDelete(): void
    {
        $newUser = $this->newUserData();

        $user = User::factory()->create([
            'company_id' => $this->user->company_id,
            'name' => $newUser['user']['name'],
        ]);

        $token = $this->user->createToken('teste', ['master'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->delete(route('company_user.delete', $user->id));

        $response->assertStatus(200);

        $this->assertSoftDeleted('Users', [
            'id' => $user->id,
        ]);
    }

    public function testeDeleteErrorInvalidUserBecausaCompanyIdDosentMatch(): void
    {
        $company = Company::factory()->create([
            'id' => 10000,
        ]);
        $user = User::factory()->create([
            'company_id' => $company->id,
        ]);

        $token = $this->user->createToken('teste', ['master'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->delete(route('company_user.delete', $user->id));

        $response->assertStatus(500);

        $response->assertJson(['error' => 'invalid user']);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
        ]);
    }

    private function newUserData(): array
    {
        return [
            'user' => [
                'name' => fake()->name,
                'email' => fake()->email,
                'password' => fake()->password,
                'enable' => 1,
            ],
            'roles' => [3],

        ];
    }
}
