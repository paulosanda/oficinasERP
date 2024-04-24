<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Customer;
use App\Models\QuoteNumbering;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuoteControllerTest extends TestCase
{
    use RefreshDatabase;

    private Company $company;
    private User $user;
    private Customer $customer;
    private Vehicle $vehicle;
    public function setUp(): void
    {
        parent::setUp();

        $this->company = Company::factory()->create();
        $this->user = User::factory()->create([
            'company_id' => $this->company->id
        ]);
        $this->customer = Customer::factory()->create([
           'company_id' => $this->company->id
        ]);

        QuoteNumbering::factory()->create([
            'company_id' => $this->company->id,
            'numbering' => 0
        ]);

        $this->vehicle = Vehicle::factory()->create([
            'customer_id' => $this->customer->id
        ]);
    }

    public function testStore(): void
    {
        $lastNumbering = QuoteNumbering::where('company_id', $this->company->id)->first();

        $token = $this->user->createToken('teste', ['master'])->plainTextToken;

        $payload = $this->quoteData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('quote.store'),$payload);

        $response->assertStatus(200);

        $response->assertJson(['message' => 'success']);

        $this->assertDatabaseCount('quotes', 1);

        $this->assertDatabaseHas('quotes', [
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
            'data_de_entrada' => $payload['data_de_entrada'],
            'data_de_saida' => null,
            'descricao_do_problema' => $payload['descricao_do_problema'],
            'laudo' => $payload['laudo'],
            'observacao' => $payload['observacao'],
            'sub_total_servico' => $payload['sub_total_servico'],
            'sub_total_produto' => $payload['sub_total_produto'],
            'total_bruto' => $payload['total_bruto'],
            'desconto' => $payload['desconto'],
            'total_liquido'=> $payload['total_liquido'],
            'total' => $payload['total'],
        ]);

        $this->assertDatabaseHas('quote_numberings',[
           'company_id' => $this->company->id,
           'numbering' => $lastNumbering->numbering + 1
        ]);

        $this->assertDatabaseHas('quote_services', [
            'codigo_do_servico' => $payload['quote_service'][0]['codigo_do_servico'],
            'descricao' => $payload['quote_service'][0]['descricao'],
            'quantidade' => $payload['quote_service'][0]['quantidade'],
            'valor' => $payload['quote_service'][0]['valor'],
            'desconto' => $payload['quote_service'][0]['desconto'],
            'sub_total' => $payload['quote_service'][0]['sub_total']
        ]);

        $this->assertDatabaseHas('quote_services', [
            'codigo_do_servico' => $payload['quote_service'][1]['codigo_do_servico'],
            'descricao' => $payload['quote_service'][1]['descricao'],
            'quantidade' => $payload['quote_service'][1]['quantidade'],
            'valor' => $payload['quote_service'][1]['valor'],
            'desconto' => $payload['quote_service'][1]['desconto'],
            'sub_total' => $payload['quote_service'][1]['sub_total']
        ]);

        $this->assertDatabaseHas('quote_services', [
            'codigo_do_servico' => $payload['quote_service'][2]['codigo_do_servico'],
            'descricao' => $payload['quote_service'][2]['descricao'],
            'quantidade' => $payload['quote_service'][2]['quantidade'],
            'valor' => $payload['quote_service'][2]['valor'],
            'desconto' => $payload['quote_service'][2]['desconto'],
            'sub_total' => $payload['quote_service'][2]['sub_total']
        ]);

        $this->assertDatabaseHas('quote_parts',[
            'codigo_do_produto' => $payload['quote_part'][0]['codigo_do_produto'],
            'descricao' => $payload['quote_part'][0]['descricao'],
            'quantidade' => $payload['quote_part'][0]['quantidade'],
            'valor' => $payload['quote_part'][0]['valor'],
            'desconto' => $payload['quote_part'][0]['desconto'],
            'sub_total' => $payload['quote_part'][0]['sub_total']
        ]);

        $this->assertDatabaseHas('quote_parts',[
            'codigo_do_produto' => $payload['quote_part'][1]['codigo_do_produto'],
            'descricao' => $payload['quote_part'][1]['descricao'],
            'quantidade' => $payload['quote_part'][1]['quantidade'],
            'valor' => $payload['quote_part'][1]['valor'],
            'desconto' => $payload['quote_part'][1]['desconto'],
            'sub_total' => $payload['quote_part'][1]['sub_total']
        ]);

        $this->assertDatabaseHas('quote_parts',[
            'codigo_do_produto' => $payload['quote_part'][2]['codigo_do_produto'],
            'descricao' => $payload['quote_part'][2]['descricao'],
            'quantidade' => $payload['quote_part'][2]['quantidade'],
            'valor' => $payload['quote_part'][2]['valor'],
            'desconto' => $payload['quote_part'][2]['desconto'],
            'sub_total' => $payload['quote_part'][2]['sub_total']
        ]);
    }

    public function testStoreErrorInvalidAbilityProvided(): void
    {
        $token = $this->user->createToken('teste', ['invalido'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson(route('quote.store'), $this->quoteData());

        $response->assertStatus(403);

        $response->assertJson([
            'message' => 'Invalid ability provided.'
        ]);
    }

    private function incrementValueInIndexOfQuoteData($key): int
    {
        $payload = $this->quoteData();

        return $payload[$key]++;
    }

    public function quoteData(): array
    {
        return [
            'customer_id' => $this->customer->id,
            'vehicle_id' => $this->vehicle->id,
            'data_de_entrada' => fake()->date('Y-m-d'),
            'data_de_saida' => '',
            'descricao_do_problema' => fake()->text,
            'laudo' => fake()->text,
            'observacao' => fake()->text,
            'sub_total_servico' => '500',
            'sub_total_produto' => '737,64',
            'total_bruto' => '1237,64',
            'desconto' => '0',
            'total_liquido' => '1237,64',
            'total' => '1237,64',
            'quote_service' => [
                [
                    'codigo_do_servico' => fake()->numerify('###'),
                    'descricao' => fake()->text,
                    'quantidade' => '1',
                    'valor' => '50',
                    'desconto' => '0',
                    'sub_total' => '50'
                ],
                [
                    'codigo_do_servico' => fake()->numerify('###'),
                    'descricao' => fake()->text,
                    'quantidade' => '4',
                    'valor' => '50',
                    'desconto' => '0',
                    'sub_total' => '200'
                ],
                [
                    'codigo_do_servico' => fake()->numerify('###'),
                    'descricao' => fake()->text,
                    'quantidade' => '1',
                    'valor' => '300',
                    'desconto' => '50',
                    'sub_total' => '250'
                ],
            ],
            'quote_part' => [
                [
                    'codigo_do_produto' => fake()->numerify('######'),
                    'descricao' => fake()->text,
                    'quantidade' => '1',
                    'valor' => '150',
                    'desconto' => '0',
                    'sub_total' => '150'
                ],
                [
                    'codigo_do_produto' => fake()->numerify('#####'),
                    'descricao' => fake()->text,
                    'quantidade' => '2',
                    'valor' => '200',
                    'desconto' => '0',
                    'sub_total' => '400'
                ],
                [
                    'codigo_do_produto' => fake()->numerify('#####'),
                    'descricao' => fake()->text,
                    'quantidade' => '3',
                    'valor' => '46,91',
                    'desconto' => '0',
                    'sub_total' => '187,64'
                ]
            ]
        ];
    }
}
