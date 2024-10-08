<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Company $company;

    private Role $role;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->company = Company::factory()->create();
        Artisan::call('db:seed', [RoleSeeder::class]);

        $role = Role::where('role', 'master')->first();

        UserRole::create([
            'user_id' => $this->user->id,
            'role_id' => $role->id,
        ]);
    }

    public function testCreateCustomer(): void
    {
        $token = $this->user->createToken('test', ['master', 'operator'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('customer.create'), $this->customerData());

        $response->assertStatus(200);

        $this->assertDatabaseCount('customers', 1);
    }

    public function testCreateCustomerPj(): void
    {
        $token = $this->user->createToken('test', ['master', 'operator'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('customer.create'), $this->customerPjData());

        $response->assertStatus(200);

        $this->assertDatabaseCount('customers', 1);
    }

    public function testCreateCustomerCpfError(): void
    {
        $token = $this->user->createToken('test', ['master', 'operator'])->plainTextToken;

        $data = $this->customerData();
        $data['cpf'] = fake()->numerify('#.###.###.###.##');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('customer.create'), $data);

        $response->assertStatus(422);
    }

    public function testUpdateCustomer(): void
    {
        $customer = $this->customerData();

        $customer['company_id'] = $this->company->id;

        $customerModel = Customer::create($customer);
        $customerModel->update(['company_id' => $this->company->id]);
        $customerModel->refresh();

        $customerUpdate = $this->customerData();

        $customerUpdate['id'] = $customerModel->id;
        $customerUpdate['company_id'] = $this->company->id;
        $customerUpdate['name'] = 'updated';

        $this->user->update(['company_id' => $this->company->id]);
        $this->user->refresh();

        $token = $this->user->createToken('teste', ['master', 'operator'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->putJson(route('customer.update'), $customerUpdate);

        $response->assertStatus(200);

    }

    public function testIndexCustomer(): void
    {
        $token = $this->user->createToken('test', ['master'])->plainTextToken;

        $anotherCompany = Company::factory()->create();
        Customer::factory()->count(20)->create(['company_id' => $anotherCompany->id]);

        Customer::factory()->count(10)->create(['company_id' => $this->user->company_id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson(route('customer.index'));

        $response->assertStatus(200);

        $response->assertJsonCount(10);

        $response->assertJsonStructure([
            '*' => [
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
                'state',
                'created_at',
                'updated_at',
                'vehicle',
            ],
        ]);

        $data = $response->json();
        foreach ($data as $customer) {
            $this->assertEquals($this->user->company_id, $customer['company_id']);
        }
    }

    public function testSearchCustomerByName(): void
    {
        $token = $this->user->createToken('test', ['master'])->plainTextToken;

        $anotherCompany = Company::factory()->create();
        Customer::factory()->count(20)->create(['company_id' => $anotherCompany->id]);

        Customer::factory()->count(10)->create(['company_id' => $this->user->company_id]);

        Customer::factory()->create([
            'company_id' => $this->user->company_id,
            'name' => 'unique_name']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson(route('customer.index').'?customer_name=unique_name');

        $response->assertStatus(200);

        $response->assertJsonCount(1);
    }

    public function testGetCustomerById(): void
    {
        $token = $this->user->createToken('test', ['master'])->plainTextToken;

        $anotherCompany = Company::factory()->create();
        Customer::factory()->count(20)->create(['company_id' => $anotherCompany->id]);

        Customer::factory()->count(10)->create(['company_id' => $this->user->company_id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson(route('customer.index').'?customer_id=25');

        $response->assertStatus(200);

        $response->assertJson([
            'id' => 25,
            'company_id' => 1,
        ]);
    }

    public function testUpdateCustomerErrorCompany(): void
    {
        $anotherCompany = Company::factory()->create();

        $customer = $this->customerData();
        $customer['company_id'] = $anotherCompany->id;

        $customerModel = Customer::create($customer);

        $customerUpdate = $this->customerData();

        $customerUpdate['id'] = $customerModel->id;
        $customerUpdate['company_id'] = $this->company->id;
        $customerUpdate['name'] = 'updated';

        $anotherCompany = Company::factory()->create();

        $token = $this->user->createToken('teste', ['master', 'operator'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->putJson(route('customer.update'), $customerUpdate);

        $response->assertStatus(500);

        $response->assertJson(['error' => 'Attempt to read property "id" on null']);

        $this->assertDatabaseMissing('customers', [
            'name' => 'updated',
        ]);
    }

    private function customerData(): array
    {
        return [
            'company_id' => $this->company->id,
            'type' => 'pf',
            'name' => fake()->name,
            'email' => fake()->email,
            'cellphone' => fake()->phoneNumber,
            'telephone' => fake()->phoneNumber,
            'cpf' => '912.489.030-80',
            'rg' => fake()->numerify('##.###.###-#'),
            'birthday' => fake()->date,
            'address' => fake()->address,
            'number' => fake()->numerify('###'),
            'postal_code' => fake()->postcode,
            'neighborhood' => fake()->name,
            'city' => fake()->city,
            'state' => 'CE',
        ];
    }

    private function customerPjData(): array
    {
        return [
            'company_id' => $this->company->id,
            'type' => 'pj',
            'name' => fake()->name,
            'email' => fake()->email,
            'cellphone' => fake()->phoneNumber,
            'telephone' => fake()->phoneNumber,
            'cnpj' => fake()->numerify('###.###.###/###1-##'),
            'inscricao_estadual' => fake()->numerify('###########'),
            'inscricao_municipal' => fake()->numerify('#####'),
            'address' => fake()->address,
            'number' => fake()->numerify('###'),
            'postal_code' => fake()->postcode,
            'neighborhood' => fake()->name,
            'city' => fake()->city,
            'state' => 'CE',
        ];
    }
}
