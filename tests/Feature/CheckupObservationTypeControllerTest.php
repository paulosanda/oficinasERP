<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Database\Seeders\CheckupObservationTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CheckupObservationTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    private Company $company;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', [CheckupObservationTypeSeeder::class]);
        $this->company = Company::factory()->create();
        $this->user = User::factory()->create([
            'company_id' => $this->company->id,
        ]);

    }

    public function testIndex(): void
    {
        $token = $this->user->createToken('teste', ['master', 'operator'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson(route('checkup_observation.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            ['id',
                'type'],
        ]);
    }

    public function testStore(): void
    {
        $token = $this->user->createToken('teste', ['root', 'admin'])->plainTextToken;

        $newObservationType = ['type' => 'teste de cadastro de nova observação'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('checkup_observation_type.store'), $newObservationType);

        $response->assertStatus(201);

        $this->assertDatabaseHas('checkup_observation_types', $newObservationType);
    }

    public function testStoreErrorInvalidAbility(): void
    {
        $token = $this->user->createToken('teste', ['master', 'operator'])->plainTextToken;

        $newObservationType = ['type' => 'teste de cadastro de nova observação'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('checkup_observation_type.store'), $newObservationType);

        $response->assertStatus(403);
    }
}
