<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed', [RoleSeeder::class]);

        $this->user = User::factory()->create();
    }

    public function testCompanyRulesIndex(): void
    {
        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(route('admin.company.rules.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'roles' => [[
                'id',
                'role'
            ]]
        ]);
    }


    public function testAdminRolesIndex(): void
    {
        $token = $this->user->createToken('teste', ['root', 'admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(route('admin.roles.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'roles' => [[
                'id',
                'role'
            ]]
        ]);
    }
}
