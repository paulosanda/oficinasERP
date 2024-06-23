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
}
