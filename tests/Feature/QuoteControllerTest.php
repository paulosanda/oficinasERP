<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Customer;
use App\Models\QuoteNumbering;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            'company_id' => $this->company->id,
        ]);
        $this->customer = Customer::factory()->create([
            'company_id' => $this->company->id,
        ]);

        QuoteNumbering::factory()->create([
            'company_id' => $this->company->id,
            'numbering' => 0,
        ]);

        $this->vehicle = Vehicle::factory()->create([
            'customer_id' => $this->customer->id,
        ]);
    }

    public function testStore(): void
    {
        $lastNumbering = QuoteNumbering::where('company_id', $this->company->id)->first();

        $token = $this->user->createToken('teste', ['master'])->plainTextToken;

        $payload = $this->quoteData();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('quote.store'), $payload);

        $response->assertStatus(200);

        $response->assertJson(['message' => 'success']);

        $this->assertDatabaseCount('quotes', 1);

        $this->assertDatabaseHas('quotes', [
            'company_id' => $this->company->id,
            'customer_id' => $this->customer->id,
            'entry_date' => $payload['entry_date'],
            'exit_date' => null,
            'problem_description' => $payload['problem_description'],
            'report' => $payload['report'],
            'observation' => $payload['observation'],
            'subtotal_service' => $payload['subtotal_service'],
            'subtotal_part' => $payload['subtotal_part'],
            'gross_total' => $payload['gross_total'],
            'discount' => $payload['discount'],
            'net_total' => $payload['net_total'],
            'total' => $payload['total'],
        ]);

        $this->assertDatabaseHas('quote_numberings', [
            'company_id' => $this->company->id,
            'numbering' => $lastNumbering->numbering + 1,
        ]);

        $this->assertDatabaseHas('quote_services', [
            'service_code' => $payload['quote_service'][0]['service_code'],
            'description' => $payload['quote_service'][0]['description'],
            'quantity' => $payload['quote_service'][0]['quantity'],
            'value' => $payload['quote_service'][0]['value'],
            'discount' => $payload['quote_service'][0]['discount'],
            'subtotal' => $payload['quote_service'][0]['subtotal'],
        ]);

        $this->assertDatabaseHas('quote_services', [
            'service_code' => $payload['quote_service'][1]['service_code'],
            'description' => $payload['quote_service'][1]['description'],
            'quantity' => $payload['quote_service'][1]['quantity'],
            'value' => $payload['quote_service'][1]['value'],
            'discount' => $payload['quote_service'][1]['discount'],
            'subtotal' => $payload['quote_service'][1]['subtotal'],
        ]);

        $this->assertDatabaseHas('quote_services', [
            'service_code' => $payload['quote_service'][2]['service_code'],
            'description' => $payload['quote_service'][2]['description'],
            'quantity' => $payload['quote_service'][2]['quantity'],
            'value' => $payload['quote_service'][2]['value'],
            'discount' => $payload['quote_service'][2]['discount'],
            'subtotal' => $payload['quote_service'][2]['subtotal'],
        ]);

        $this->assertDatabaseHas('quote_parts', [
            'part_code' => $payload['quote_part'][0]['part_code'],
            'description' => $payload['quote_part'][0]['description'],
            'quantity' => $payload['quote_part'][0]['quantity'],
            'value' => $payload['quote_part'][0]['value'],
            'discount' => $payload['quote_part'][0]['discount'],
            'subtotal' => $payload['quote_part'][0]['subtotal'],
        ]);

        $this->assertDatabaseHas('quote_parts', [
            'part_code' => $payload['quote_part'][1]['part_code'],
            'description' => $payload['quote_part'][1]['description'],
            'quantity' => $payload['quote_part'][1]['quantity'],
            'value' => $payload['quote_part'][1]['value'],
            'discount' => $payload['quote_part'][1]['discount'],
            'subtotal' => $payload['quote_part'][1]['subtotal'],
        ]);

        $this->assertDatabaseHas('quote_parts', [
            'part_code' => $payload['quote_part'][2]['part_code'],
            'description' => $payload['quote_part'][2]['description'],
            'quantity' => $payload['quote_part'][2]['quantity'],
            'value' => $payload['quote_part'][2]['value'],
            'discount' => $payload['quote_part'][2]['discount'],
            'subtotal' => $payload['quote_part'][2]['subtotal'],
        ]);
    }

    public function testStoreErrorInvalidAbilityProvided(): void
    {
        $token = $this->user->createToken('teste', ['invalido'])->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->postJson(route('quote.store'), $this->quoteData());

        $response->assertStatus(403);

        $response->assertJson([
            'message' => 'Invalid ability provided.',
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
            'entry_date' => fake()->date('Y-m-d'),
            'exit_date' => '',
            'problem_description' => fake()->text,
            'report' => fake()->text,
            'observation' => fake()->text,
            'subtotal_service' => '500',
            'subtotal_part' => '737,64',
            'gross_total' => '1237,64',
            'discount' => '0',
            'net_total' => '1237,64',
            'total' => '1237,64',
            'quote_service' => [
                [
                    'service_code' => fake()->numerify('###'),
                    'description' => fake()->text,
                    'quantity' => '1',
                    'value' => '50',
                    'discount' => '0',
                    'subtotal' => '50',
                ],
                [
                    'service_code' => fake()->numerify('###'),
                    'description' => fake()->text,
                    'quantity' => '4',
                    'value' => '50',
                    'discount' => '0',
                    'subtotal' => '200',
                ],
                [
                    'service_code' => fake()->numerify('###'),
                    'description' => fake()->text,
                    'quantity' => '1',
                    'value' => '300',
                    'discount' => '50',
                    'subtotal' => '250',
                ],
            ],
            'quote_part' => [
                [
                    'part_code' => fake()->numerify('######'),
                    'description' => fake()->text,
                    'quantity' => '1',
                    'value' => '150',
                    'discount' => '0',
                    'subtotal' => '150',
                ],
                [
                    'part_code' => fake()->numerify('#####'),
                    'description' => fake()->text,
                    'quantity' => '2',
                    'value' => '200',
                    'discount' => '0',
                    'subtotal' => '400',
                ],
                [
                    'part_code' => fake()->numerify('#####'),
                    'description' => fake()->text,
                    'quantity' => '3',
                    'value' => '46,91',
                    'discount' => '0',
                    'subtotal' => '187,64',
                ],
            ],
        ];
    }
}
