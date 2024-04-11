<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ClientAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Client|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $client;
    public function setUp(): void
    {
        parent::setUp();

        $this->client = Client::factory()->count(10)->create();

        Artisan::call('db:seed' ,[RoleSeeder::class]);

        $this->user = User::factory()->create();

        $role = Role::findOrFail(1);

        UserRole::factory()->create([
            'user_id' => $this->user->id,
            'role_id' => $role->id
        ]);

    }

    public function testCreateClient(): void
    {
        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->postJson(route('admin.create.client'),[
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

        $this->assertDatabaseCount('clients', 11);
    }

    public function testCreateClientError422()
    {
        $token = $this->user->createToken('test', ['client'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
                ])->postJson(route('admin.create.client'),[
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

    public function testCreateClientErrorMissRazaoSocial(): void
    {
        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
                ])->postJson(route('admin.create.client'),[
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
            "error" => [
                "razao_social" => ["validation.required"]
            ]
        ]);

        $this->assertDatabaseCount('clients', 10);
    }

    public function testCreateClientWithoutInscricaoEstadual(): void
    {
        $token = $this->user->createToken('teste', ['root'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->postJson(route('admin.create.client'),[
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

        $this->assertDatabaseCount('clients', 11);
    }

    public function testIndex(): void
    {
        $token = $this->user->createToken('token', ['admin'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson(route('admin.index.client'));

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


}
