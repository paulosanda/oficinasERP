<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\UserRole;
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

    public function testIndexIfAdminUser(): void
    {
        User::factory()->count(50)->create();
        $totalUser = User::count();

        $this->user->update(['company_id' => Company::SYSTEM_ADMIN]);

        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(route('user.index'));

        $response->assertStatus(200);

        $response->assertJsonCount($totalUser);
    }

    public function testIndexifCompanyUser(): void
    {
        $company = Company::factory()->count(2)->create();

        User::factory()->count(100)->create();

        $companyUsers = User::factory()->count(10)->create(['company_id' => $company[1]->id]);

        $this->user->update(['company_id' => $company[1]->id]);

        $totalCompanyUser = User::where('company_id', $company[1]->id)->count();

        $token = $this->user->createToken('teste', ['master'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(route('user.index'));

        $response->assertStatus(200);

        $response->assertJsonCount($totalCompanyUser);

        $this->assertNotEquals(User::all()->count(), $totalCompanyUser);
    }

    public function testUpdateToDisableIfRootUser(): void
    {
        $user = $this->createUserAndRoles();

        $payload = $user->findOrFail($user->id)->toArray();

        $payload['enable'] = false;
        $payload['password'] = null;

        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('user.update', $payload['id']), $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'enable' => false
        ]);

        $this->assertDatabaseHas('Users', [
           'name' => $payload['name'],
           'company_id' => $payload['company_id'],
           'email' => $payload['email'],
           'enable' => $payload['enable']
        ]);

    }

    public function testUpdateWithoutRoles(): void
    {
        $user = $this->createUserAndRoles()->toArray();

        $token = $this->user->createToken('teste', ['master'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('user.update', $user['id']), $user);

        $response->assertStatus(200);

    }

    private function createUserAndRoles(): User
    {
        $user = User::factory()->create();
        UserRole::factory()->create(['user_id' => $user->id, 'role_id' => 3]);
        UserRole::factory()->create(['user_id' => $user->id, 'role_id' => 4]);

        return $user;
    }

}
