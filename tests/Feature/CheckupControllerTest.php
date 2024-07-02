<?php

namespace Tests\Feature;

use App\Models\Checkup;
use App\Models\CheckupObservationType;
use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use App\Models\Vehicle;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CheckupControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Company $company;

    private Customer $customer;

    private Vehicle $vehicle;

    private Checkup $checkup;

    private Collection|CheckupObservationType $checkupObservationType;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed', [DatabaseSeeder::class]);

        $this->company = Company::factory()->create();
        $this->user = User::factory()->create([
            'company_id' => $this->company->id,
        ]);
        $this->customer = Customer::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $this->vehicle = Vehicle::factory()->create([
            'customer_id' => $this->customer->id,
        ]);

        $this->checkup = Checkup::factory()->create([
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
            'vehicle_id' => $this->vehicle->id,
        ]);

        $this->checkupObservationType = CheckupObservationType::all();

    }

    public function testIndex(): void
    {
        $token = $this->user->createToken('teste', ['operator'])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->get(route('company.checkups.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'company_id',
                    'customer_id',
                    'vehicle_id',
                    'front_damage',
                    'front_photo',
                    'back_damage',
                    'back_photo',
                    'right_side_damage',
                    'right_side_photo',
                    'left_side_damage',
                    'left_side_photo',
                    'roof_damage',
                    'roof_photo',
                    'fuel_gauge',
                    'fuel_gauge_photo',
                    'evaluation',
                    'created_at',
                    'updated_at',
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links' => [
                '*' => [
                    'url',
                    'label',
                    'active',
                ],
            ],
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);

    }

    public function testCreateCheckup(): void
    {
        $token = $this->user->createToken('teste', ['operator'])->plainTextToken;

        $payload = $this->checkUpData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('customer.checkup.store'),
            $payload
        );

        $response->assertStatus(200);

        $response->assertJson(['message' => 'success']);

        $this->assertDatabaseCount('checkups', 2);

        $this->assertDatabaseHas('checkups', [
            'company_id' => $this->company->id,
            'vehicle_id' => $this->vehicle->id,
            'front_damage' => $payload['front_damage'],
            'front_photo' => $payload['front_photo'],
            'back_damage' => $payload['back_damage'],
            'back_photo' => $payload['back_photo'],
            'right_side_damage' => $payload['right_side_damage'],
            'right_side_photo' => $payload['right_side_photo'],
            'left_side_damage' => $payload['left_side_damage'],
            'left_side_photo' => $payload['left_side_photo'],
            'roof_damage' => $payload['roof_damage'],
            'roof_photo' => $payload['roof_photo'],
            'fuel_gauge' => $payload['fuel_gauge'],
            'fuel_gauge_photo' => $payload['fuel_gauge_photo'],
            'evaluation' => $payload['evaluation'],
        ]);

        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][0]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][0]['observation'],
        ]);
        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][1]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][1]['observation'],
        ]);
        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][2]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][2]['observation'],
        ]);
        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][3]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][3]['observation'],
        ]);
        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][4]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][4]['observation'],
        ]);
        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][5]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][5]['observation'],
        ]);
    }

    public function testcreateCheckupErrorAbility(): void
    {
        $token = $this->user->createToken('teste', ['noAbility'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ', $token,
        ])->postJson(route('customer.checkup.store'), $this->checkUpData());

        $response->assertStatus(401);

        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    //    public function testGetCheckup(): void
    //    {
    //        $token = $this->user->createToken('teste', ['master','operator'])->plainTextToken;
    //
    //    }

    public function checkUpData(): array
    {
        $fuel_gauge = ['vazio', '1/4', '1/2', '3/4', 'cheio'];

        $evaluation = ['aprovado para uso', 'manutenção recomendada'];

        return [
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
            'vehicle_id' => $this->vehicle->id,
            'front_damage' => fake()->text,
            'front_photo' => fake()->url,
            'back_damage' => fake()->text,
            'back_photo' => fake()->url,
            'right_side_damage' => fake()->text,
            'right_side_photo' => fake()->url,
            'left_side_damage' => fake()->text,
            'left_side_photo' => fake()->url,
            'roof_damage' => fake()->text,
            'roof_photo' => fake()->url,
            'fuel_gauge' => fake()->randomElement($fuel_gauge),
            'fuel_gauge_photo' => fake()->url,
            'evaluation' => fake()->randomElement($evaluation),
            'checkup_observation' => [
                ['checkup_observation_type_id' => 1,
                    'observation' => fake()->text],
                ['checkup_observation_type_id' => 2,
                    'observation' => fake()->text],
                ['checkup_observation_type_id' => 3,
                    'observation' => fake()->text],
                ['checkup_observation_type_id' => 4,
                    'observation' => fake()->text],
                ['checkup_observation_type_id' => 5,
                    'observation' => fake()->text],
                ['checkup_observation_type_id' => 6,
                    'observation' => fake()->text],
            ],
        ];
    }
}
