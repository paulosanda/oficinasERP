<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientUser;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;
    private User $user;
    private Client $client;
    private Role $role;
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->client = Client::factory()->create();
        Artisan::call('db:seed' ,[RoleSeeder::class]);
        $role = Role::where('role', 'master')->first();
        ClientUser::factory()->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id
        ]);
        UserRole::create([
            'user_id' => $this->user->id,
            'role_id' => $role->id
        ]);
    }

    public function testCreateCustomer(): void
    {
        $token = $this->user->createToken('test', ['master', 'operator'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('customer.create'), $this->customerData());

        $response->assertStatus(200);

        $this->assertDatabaseCount('customers', 1);
    }

    public function testCreateCustomerCpfError(): void
    {
        $token = $this->user->createToken('test', ['master', 'operator'])->plainTextToken;

        $data = $this->customerData();
        $data['cpf'] = fake()->numerify('#.###.###.###.##');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('customer.create'), $data);

        $response->assertStatus(422);
    }

    public function testUpdateCustomer(): void
    {
        $customer = $this->customerData();
        $customer['client_id'] = $this->client->id;

        $customerModel = Customer::create($customer);

        $customerUpdate =  $this->customerData();

        $customerUpdate['id'] = $customerModel->id;
        $customerUpdate['client_id'] = $this->client->id;
        $customerUpdate['name'] = 'updated';

        $token = $this->user->createToken('teste', ['master', 'operator'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('customer.update'), $customerUpdate);


        $response->assertStatus(200);

        $this->assertDatabaseHas('customers', [
            'name' => 'updated'
        ]);
    }

    public function testUpdateCustomerErrorClient(): void
    {
        $anotherClient = Client::factory()->create();

        $customer = $this->customerData();
        $customer['client_id'] = $anotherClient->id;

        $customerModel = Customer::create($customer);

        $customerUpdate =  $this->customerData();

        $customerUpdate['id'] = $customerModel->id;
        $customerUpdate['client_id'] = $this->client->id;
        $customerUpdate['name'] = 'updated';

        $anotherClient = Client::factory()->create();


        $token = $this->user->createToken('teste', ['master', 'operator'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('customer.update'), $customerUpdate);

        $response->assertStatus(422);

        $response->assertJson(["error" =>"invalid customer"]);

        $this->assertDatabaseMissing('customers',[
            'name' => 'updated'
        ]);
    }

    private function customerData(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->email,
            'celular' => fake()->phoneNumber,
            'telefone' =>fake()->phoneNumber,
            'cpf' => '912.489.030-80',
            'rg' => fake()->numerify('##.###.###-#'),
            'nascimento' => fake()->date,
            'endereco' => fake()->address,
            'numero' => fake()->numerify('###'),
            'cep' => fake()->postcode,
            'bairro' => fake()->name,
            'cidade' => fake()->city,
            'estado' => 'CE'
        ];
    }
}
