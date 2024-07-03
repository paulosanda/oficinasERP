<?php

namespace App\Actions;

use App\Models\Quote;
use App\Models\QuoteNumbering;
use App\Models\QuotePart;
use App\Models\QuoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class QuoteCreateAction
{
    public function rules(): array
    {
        return [
            'company_id' => 'integer|required',
            'customer_id' => 'integer|required',
            'vehicle_id' => 'integer|required',
            'entry_date' => 'string|required',
            'exit_date' => 'string|nullable',
            'problem_description' => 'string|nullable',
            'report' => 'string|nullable',
            'observation' => 'string|nullable',
            'subtotal_service' => 'string|required',
            'subtotal_part' => 'string|required',
            'gross_total' => 'string|required',
            'discount' => 'string|nullable',
            'net_total' => 'string|required',
            'total' => 'string|required',
            'quote_service.*.service_code' => 'string|nullable',
            'quote_service.*.description' => 'string|nullable',
            'quote_service.*.quantity' => 'integer|nullable',
            'quote_service.*.value' => 'string|nullable',
            'quote_service.*.discount' => 'string|nullable',
            'quote_service.*.subtotal' => 'string|nullable',
            'quote_part.*.part_code' => 'string|nullable',
            'quote_part.*.description' => 'string|nullable',
            'quote_part.*.quantity' => 'integer|nullable',
            'quote_part.*.value' => 'string|nullable',
            'quote_part.*.discount' => 'string|nullable',
            'quote_part.*.subtotal' => 'string|nullable',
        ];
    }

    public function execute(Request $request): JsonResponse
    {

        $data = $request->validate($this->rules());

        $numbering = $this->getCompanyNumbering($data);
        $data['company_numbering'] = $numbering;

        try {
            $quote = Quote::create($data);

            $this->createServices($data, $quote->id);

            $this->createParts($data, $quote->id);

            return response()->json(['message' => 'success']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    private function createServices($data, $quoteId): void
    {
        foreach ($data['quote_service'] as $service) {
            $service['quote_id'] = $quoteId;
            QuoteService::create($service);
        }
    }

    private function createParts($data, $quoteId): void
    {
        foreach ($data['quote_part'] as $part) {
            $part['quote_id'] = $quoteId;
            QuotePart::create($part);
        }
    }

    private function getCompanyNumbering($data): int
    {
        $numbering = QuoteNumbering::where('company_id', $data['company_id'])->first();
        if (! $numbering) {
            $numbering = QuoteNumbering::create([
                'company_id' => $data['company_id'],
                'numbering' => 1,
            ]);
        } else {
            $numbering->numbering += 1;
        }

        $numbering->save();

        return $numbering->numbering;
    }
}
