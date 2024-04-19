<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Customer;
use App\Models\SchedulableService;
use App\Models\User;
use Database\Seeders\SchedulableServiceSeeder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ScheduledServiceControllerTest extends TestCase
{
   use RefreshDatabase;

   private User $user;
   private Company $company;
   private Customer $customer;

   public function setUp(): void
   {
       parent::setUp();
       Artisan::call('db:seed', [SchedulableServiceSeeder::class]);
       $this->company = Company::factory()->create();
       $this->user = User::factory()->create([
           'company_id' => $this->company->id
       ]);
       $this->customer = Customer::factory()->create([
           'company_id' => $this->company->id
       ]);

   }

   public function testListServices(): void
   {
       $token = $this->user->createToken('teste', ['operator'])->plainTextToken;

       $response = $this->withHeaders([
           'Authorization' => 'Bearer ' . $token
       ])->getJson(route('schedulable_services.list'));

       $response->assertStatus(200);

       $response->assertJsonStructure([
           ['service']
       ]);
   }

   public function store(): void
   {
       $token = $this->user->createToken('teste', ['operator'])->plainTextToken;

       $payload = $this->scheduledData();

       $response = $this->withHeaders([
           'Authorization' => 'Bearer ' . $token,
       ])->postJson(route(' '), $payload);

       $response->assertStatus(200);

       $response->assertJson([
           'message' => 'success'
       ]);

       $this->assertDatabaseHas('scheduled_services', [
           'company_id' => $this->company->id,
           'customer_id' => $payload['customer_id'],
           'data_prevista' => $payload['data_prevista'],
           'data_realizado' => null,
           'lembrete_ativo' => $payload['lembrete_ativo'],
           'observacao' => $payload['observacao'],
           'resposta' => null
       ]);


   }

   private function scheduledData(): array
   {
       $services = SchedulableService::all()->toArray();

       return [
           'customer_id' => $this->customer->id,
           'servico' => fake()->randomElement($services),
           'data_prevista' => fake()->date('Y-m-d', 'now'),
           'lembrete_ativo' => true,
           'observacao' => fake()->text
           ];
   }
}