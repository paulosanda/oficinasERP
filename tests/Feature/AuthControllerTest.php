<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private string $password = '123';

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => $this->password,
        ]);

        Artisan::call('db:seed', [RoleSeeder::class]);

        UserRole::factory()->create([
            'user_id' => $this->user->id,
            'role_id' => 1,
        ]);

    }

    public function testLogin(): void
    {
        $response = $this->postJson(route('api.login'), [
            'email' => $this->user->email,
            'password' => $this->password,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'token',
        ]);
    }

    public function testLoginErrorWrongPassword(): void
    {
        $password = 'anotherOne';

        $response = $this->postJson(route('api.login'), [
            'email' => $this->user->email,
            'password' => $password,
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'error' => 'credenciais inválidas',
        ]);
    }

    public function testLoginErrorWrongEmail(): void
    {
        $email = 'another@mis.c';

        $response = $this->postJson(route('api.login'), [
            'email' => $email,
            'password' => $this->password,
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'error' => 'credenciais inválidas',
        ]);
    }

    public function testLogingDisabled()
    {
        $this->user->update(['enable' => 0]);

        $response = $this->postJson(route('api.login'), [
            'email' => $this->user->email,
            'password' => $this->password,
        ]);

        $response->assertStatus(403);

    }
}
