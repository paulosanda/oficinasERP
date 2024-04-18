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
            'company_id' => $this->company->id
        ]);
        $this->customer = Customer::factory()->create([
           'company_id' => $this->company->id
        ]);

        $this->vehicle = Vehicle::factory()->create([
            'customer_id' => $this->customer->id
        ]);

        $this->checkup = Checkup::factory()->create([
            'vehicle_id' => $this->vehicle->id
        ]);

        $this->checkupObservationType = CheckupObservationType::all();

    }

    public function testCreateCheckup(): void
    {
        $token = $this->user->createToken('teste', ['operator'])->plainTextToken;

        $payload = $this->checkUpData();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('customer.checkup.store'),
            $payload
        );

        $response->assertStatus(200);

        $response->assertJson(['message' => 'success']);

        $this->assertDatabaseCount('checkups', 2);

        $this->assertDatabaseHas('checkups',[
            'vehicle_id' => $this->vehicle->id,
            'avarias_frente' => $payload['avarias_frente'],
            'av_frente_foto' => $payload['av_frente_foto'],
            'avarias_traseiro' => $payload['avarias_traseiro'],
            'av_traseira_foto' => $payload['av_traseira_foto'],
            'avarias_direito' => $payload['avarias_direito'],
            'av_direito_foto' => $payload['av_direito_foto'],
            'avarias_esquerdo' => $payload['avarias_esquerdo'],
            'av_esquerdo_foto' => $payload['av_esquerdo_foto'],
            'avarias_teto' => $payload['avarias_teto'],
            'av_teto_foto' => $payload['av_teto_foto'],
            'combustivel' => $payload['combustivel'],
            'combustivel_foto' => $payload['combustivel_foto'],
            'avaliacao' => $payload['avaliacao']
        ]);

        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][0]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][0]['observation']
        ]);
        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][1]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][1]['observation']
        ]);
        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][2]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][2]['observation']
        ]);
        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][3]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][3]['observation']
        ]);
        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][4]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][4]['observation']
        ]);
        $this->assertDatabaseHas('checkup_observations', [
            'checkup_observation_type_id' => $payload['checkup_observation'][5]['checkup_observation_type_id'],
            'observation' => $payload['checkup_observation'][5]['observation']
        ]);
    }

    public function testcreateCheckupErrorAbility(): void
    {
        $token = $this->user->createToken('teste', ['noAbility'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' , $token,
        ])->postJson(route('customer.checkup.store'), $this->checkUpData());

        $response->assertStatus(401);

        $response->assertJson(['message'=>'Unauthenticated.']);
    }

   public function checkUpData(): array
   {
       $combustivel = ['vazio', '1/4','1/2','3/4', 'cheio'];

       $avaliacao = ['aprovado para uso', 'manutenção recomendada'];

       return [
           'vehicle_id' => $this->vehicle->id,
           'avarias_frente' => fake()->text,
           'av_frente_foto' => fake()->url,
           'avarias_traseiro' => fake()->text,
           'av_traseira_foto' => fake()->url,
           'avarias_direito' => fake()->text,
           'av_direito_foto' => fake()->url,
           'avarias_esquerdo' => fake()->text,
           'av_esquerdo_foto' => fake()->url,
           'avarias_teto' => fake()->text,
           'av_teto_foto' => fake()->url,
           'combustivel' => fake()->randomElement($combustivel),
           'combustivel_foto' => fake()->url,
           'avaliacao' => fake()->randomElement($avaliacao),
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
           ]
       ];
   }
}
