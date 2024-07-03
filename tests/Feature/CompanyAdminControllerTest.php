<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\QuoteNumbering;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CompanyAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Company|Model|Collection $company;

    public function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->count(10)->create();

        Artisan::call('db:seed', [RoleSeeder::class]);

        $this->user = User::factory()->create([
            'company_id' => 2,
        ]);

        $role = Role::findOrFail(1);

        UserRole::factory()->create([
            'user_id' => $this->user->id,
            'role_id' => $role->id,
        ]);

    }

    public function testCreateCompany(): void
    {
        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $companiesQtity = Company::all()->count();

        $quoteNumberingQtity = QuoteNumbering::all()->count();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('admin.create.company'), [
            'company_name' => fake()->company,
            'cnpj' => fake()->numerify('###.###.###/0001-##'),
            'inscricao_estadual' => fake()->numerify('###.###.###-##'),
            'inscricao_municipal' => fake()->numerify('###.###.###'),
            'address' => fake()->streetName,
            'number' => '5',
            'neighborhood' => fake()->name,
            'postal_code' => fake()->postcode,
            'city' => fake()->city,
            'state' => 'SP',
            'cellphone' => fake()->phoneNumber,
            'email' => fake()->email,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'company_name',
            'cnpj',
            'inscricao_estadual',
            'inscricao_municipal',
            'address',
            'number',
            'neighborhood',
            'postal_code',
            'city',
            'state',
            'cellphone',
            'email',
        ]);

        $this->assertDatabaseCount('companies', $companiesQtity + 1);

        $this->assertDatabaseCount('quote_numberings', $quoteNumberingQtity + 1);
    }

    public function testCreateCompanyError422()
    {
        $token = $this->user->createToken('test', ['company'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('admin.create.company'), [
            'company_name' => fake()->company,
            'cnpj' => fake()->numerify('###.###.###/0001-##'),
            'inscricao_estadual' => fake()->numerify('###.###.###-##'),
            'inscricao_municipal' => fake()->numerify('###.###.###'),
            'address' => fake()->streetName,
            'number' => fake()->numberBetween(1, 1000),
            'neighborhood' => fake()->name,
            'postal_code' => fake()->postcode,
            'city' => fake()->city,
            'state' => 'SP',
            'cellphone' => fake()->phoneNumber,
            'email' => fake()->email,
        ]);

        $response->assertStatus(403);

        $response->assertJson([
            'message' => 'Invalid ability provided.',
        ]);
    }

    public function testCreateCompanyErrorMissRazaoSocial(): void
    {
        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('admin.create.company'), [
            'cnpj' => fake()->numerify('###.###.###/0001-##'),
            'inscricao_estadual' => fake()->numerify('###.###.###-##'),
            'inscricao_municipal' => fake()->numerify('###.###.###'),
            'address' => fake()->streetName,
            'number' => '50',
            'neighborhood' => fake()->name,
            'postal_code' => fake()->postcode,
            'city' => fake()->city,
            'state' => 'SP',
            'cellphone' => fake()->phoneNumber,
            'email' => fake()->email,
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'The company name field is required.',
            'errors' => [
                'company_name' => ['The company name field is required.'],
            ],
        ]);

        $this->assertDatabaseCount('companies', 12);
    }

    public function testCreateCompanyWithoutInscricaoEstadual(): void
    {
        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('admin.create.company'), [
            'company_name' => fake()->company,
            'cnpj' => fake()->numerify('###.###.###/0001-##'),
            'inscricao_municipal' => fake()->numerify('###.###.###'),
            'address' => fake()->streetName,
            'number' => '5',
            'neighborhood' => fake()->name,
            'postal_code' => fake()->postcode,
            'city' => fake()->city,
            'state' => 'SP',
            'cellphone' => fake()->phoneNumber,
            'email' => fake()->email,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'company_name',
            'cnpj',
            'inscricao_municipal',
            'address',
            'number',
            'neighborhood',
            'postal_code',
            'city',
            'state',
            'cellphone',
            'email',
        ]);

        $this->assertDatabaseCount('companies', 13);
    }

    public function testIndex(): void
    {

        $token = $this->user->createToken('token', ['admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->getJson(route('admin.index.company'));

        $response->assertStatus(200);

        $response->assertJsonStructure([[
            'company_name',
            'cnpj',
            'inscricao_estadual',
            'inscricao_municipal',
            'address',
            'number',
            'neighborhood',
            'postal_code',
            'city',
            'state',
            'cellphone',
            'email',
        ]]);
    }

    public function testUpdate(): void
    {
        $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

        $company = $this->companyData();
        $company['id'] = 1;
        $company['company_name'] = 'updated';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->putJson(route('admin.company.update', $company['id']), $company);

        $response->assertStatus(200);

        $this->assertDatabaseHas('companies', [
            'company_name' => 'updated',
        ]);
    }

    public function companyData(): array
    {
        return [
            'company_name' => fake()->company,
            'cnpj' => fake()->numerify('###.###.###/0001-##'),
            'inscricao_estadual' => fake()->numerify('###.###.###-##'),
            'inscricao_municipal' => fake()->numerify('###.###.###'),
            'address' => fake()->streetName,
            'number' => '5',
            'neighborhood' => fake()->name,
            'postal_code' => fake()->postcode,
            'city' => fake()->city,
            'state' => 'SP',
            'cellphone' => fake()->phoneNumber,
            'email' => fake()->email,
        ];
    }
}
