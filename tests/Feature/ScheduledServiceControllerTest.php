<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Customer;
use App\Models\SchedulableService;
use App\Models\ScheduledService;
use App\Models\User;
use App\Models\Vehicle;
use Database\Seeders\SchedulableServiceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ScheduledServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Company $company;

    private Customer $customer;

    private Vehicle $vehicle;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', [SchedulableServiceSeeder::class]);
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

    }

    public function testListServices(): void
    {
        $token = $this->user->createToken('teste', ['operator'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson(route('schedulable_services.list'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            ['service'],
        ]);
    }

    public function teststore(): void
    {
        $token = $this->user->createToken('teste', ['operator'])->plainTextToken;

        $payload = $this->scheduledData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('schedule_service.store'), $payload);

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'success',
        ]);

        $this->assertDatabaseHas('scheduled_services', [
            'vehicle_id' => $this->vehicle->id,
            'company_id' => $this->company->id,
            'customer_id' => $payload['customer_id'],
            'schedulable_service_id' => $payload['schedulable_service_id'],
            'scheduled_date' => $payload['scheduled_date'],
            'completion_date' => null,
            'reminder_active' => $payload['reminder_active'],
            'observation' => $payload['observation'],
            'customer_answer' => null,
        ]);

    }

    public function testIndex(): void
    {
        $payload = $this->scheduledData();
        $payload['company_id'] = $this->user->company_id;

        $scheduledService = ScheduledService::factory()->create($payload);

        $token = $this->user->createToken('teste', ['master'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson(route('schedule_service.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([[
            'id',
            'vehicle_id',
            'company_id',
            'customer_id',
            'schedulable_service_id',
            'scheduled_date',
            'completion_date',
            'reminder_active',
            'observation',
            'customer_answer',
            'deleted_at',
            'company' => [
                'id',
                'company_name',
                'cnpj',
                'inscricao_estadual',
                'inscricao_municipal',
                'address',
                'number',
                'neighborhood',
                'postal_code',
                'city',
                'estate',
                'cellphone',
                'email',
            ],
            'customer' => [
                'id',
                'company_id',
                'type',
                'name',
                'email',
                'cellphone',
                'telephone',
                'cpf',
                'rg',
                'cnpj',
                'inscricao_estadual',
                'inscricao_municipal',
                'birthday',
                'profession',
                'address',
                'number',
                'postal_code',
                'neighborhood',
                'city',
                'estate',
            ],
            'schedulable_service' => [
                'id',
                'service',
            ],
        ]]);
    }

    private function scheduledData(): array
    {
        $services = SchedulableService::all()->toArray();

        return [
            'vehicle_id' => $this->vehicle->id,
            'customer_id' => $this->customer->id,
            'schedulable_service_id' => $services[0]['id'],
            'scheduled_date' => fake()->date('Y-m-d', 'now'),
            'reminder_active' => true,
            'observation' => fake()->text,
        ];
    }
}
