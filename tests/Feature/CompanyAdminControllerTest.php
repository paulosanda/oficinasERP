<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\CompanyUser;
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
    private Company|Collection|Model $company;
    public function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->count(10)->create();

        Artisan::call('db:seed' ,[RoleSeeder::class]);

        $this->user = User::factory()->create();

        $role = Role::findOrFail(1);

        UserRole::factory()->create([
            'user_id' => $this->user->id,
            'role_id' => $role->id
        ]);

    }

    public function testCreateCompany(): void
    {
        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->postJson(route('admin.create.company'),[
            'razao_social' => fake()->company,
            'cnpj' => fake()->numerify('###.###.###/0001-##'),
            'inscricao_estadual' => fake()->numerify('###.###.###-##'),
            'inscricao_municipal' => fake()->numerify('###.###.###'),
            'endereco' => fake()->streetName,
            'numero' => '5',
            'bairro' => fake()->name,
            'cep' => fake()->postcode,
            'cidade' => fake()->city,
            'estado' => 'SP',
            'celular' => fake()->phoneNumber,
            'email' => fake()->email
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'razao_social',
            'cnpj',
            'inscricao_estadual',
            'inscricao_municipal',
            'endereco',
            'numero',
            'bairro',
            'cep',
            'cidade',
            'estado',
            'celular',
            'email'
        ]);

        $this->assertDatabaseCount('companies', 11);
    }

    public function testCreateCompanyError422()
    {
        $token = $this->user->createToken('test', ['company'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
                ])->postJson(route('admin.create.company'),[
                    'razao_social' => fake()->company,
                    'cnpj' => fake()->numerify('###.###.###/0001-##'),
                    'inscricao_estadual' => fake()->numerify('###.###.###-##'),
                    'inscricao_municipal' => fake()->numerify('###.###.###'),
                    'endereco' => fake()->streetName,
                    'numero' => fake()->numberBetween(1, 1000),
                    'bairro' => fake()->name,
                    'cep' => fake()->postcode,
                    'cidade' => fake()->city,
                    'estado' => 'SP',
                    'celular' => fake()->phoneNumber,
                    'email' => fake()->email
            ]);

        $response->assertStatus(403);

        $response->assertJson([
            "message" => "Invalid ability provided."
        ]);
    }

    public function testCreateCompanyErrorMissRazaoSocial(): void
    {
        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
                ])->postJson(route('admin.create.company'),[
                    'cnpj' => fake()->numerify('###.###.###/0001-##'),
                    'inscricao_estadual' => fake()->numerify('###.###.###-##'),
                    'inscricao_municipal' => fake()->numerify('###.###.###'),
                    'endereco' => fake()->streetName,
                    'numero' => '50',
                    'bairro' => fake()->name,
                    'cep' => fake()->postcode,
                    'cidade' => fake()->city,
                    'estado' => 'SP',
                    'celular' => fake()->phoneNumber,
                    'email' => fake()->email
             ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'validation.required',
            'errors' => [
                'razao_social' => ['validation.required'],
            ],
        ]);

        $this->assertDatabaseCount('companies', 10);
    }

    public function testCreateCompanyWithoutInscricaoEstadual(): void
    {
        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->postJson(route('admin.create.company'),[
            'razao_social' => fake()->company,
            'cnpj' => fake()->numerify('###.###.###/0001-##'),
            'inscricao_municipal' => fake()->numerify('###.###.###'),
            'endereco' => fake()->streetName,
            'numero' => '5',
            'bairro' => fake()->name,
            'cep' => fake()->postcode,
            'cidade' => fake()->city,
            'estado' => 'SP',
            'celular' => fake()->phoneNumber,
            'email' => fake()->email
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'razao_social',
            'cnpj',
            'inscricao_municipal',
            'endereco',
            'numero',
            'bairro',
            'cep',
            'cidade',
            'estado',
            'celular',
            'email'
        ]);

        $this->assertDatabaseCount('companies', 11);
    }

    public function testIndex(): void
    {
        $token = $this->user->createToken('token', ['admin'])->plainTextToken;

        $users =User::factory()->count(5)->create();

        foreach ($users as $user){
            CompanyUser::factory()->create([
                'company_id' => 2,
                'user_id' => $user->id
            ]);
        }


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(route('admin.index.company'));

        $response->assertStatus(200);

        $response->assertJsonStructure([[
            'razao_social',
            'cnpj',
            'inscricao_estadual',
            'inscricao_municipal',
            'endereco',
            'numero',
            'bairro',
            'cep',
            'cidade',
            'estado',
            'celular',
            'email'
        ]]);
    }

    public function testUpdate(): void
    {
        $token = $this->user->createToken('teste', ['admin'])->plainTextToken;

        $company = $this->companyData();
        $company['id'] = 1;
        $company['razao_social'] = 'updated';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson(route('admin.company.update'), $company);

        $response->assertStatus(200);

        $this->assertDatabaseHas('companies', [
            'razao_social' => 'updated'
        ]);
    }

    public function companyData(): array
    {
        return [
            'razao_social' => fake()->company,
            'cnpj' => fake()->numerify('###.###.###/0001-##'),
            'inscricao_estadual' => fake()->numerify('###.###.###-##'),
            'inscricao_municipal' => fake()->numerify('###.###.###'),
            'endereco' => fake()->streetName,
            'numero' => '5',
            'bairro' => fake()->name,
            'cep' => fake()->postcode,
            'cidade' => fake()->city,
            'estado' => 'SP',
            'celular' => fake()->phoneNumber,
            'email' => fake()->email
        ];
    }

}
