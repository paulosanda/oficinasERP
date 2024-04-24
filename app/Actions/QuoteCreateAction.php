<?php

namespace App\Actions;


use App\Models\Quote;
use App\Models\QuoteNumbering;
use App\Models\QuotePart;
use App\Models\QuoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use function Symfony\Component\Translation\t;

class QuoteCreateAction
{
    public function rules():array
    {
        return [
            'company_id' => 'integer|required',
            'customer_id' => 'integer|required',
            'vehicle_id' => 'integer|required',
            'data_de_entrada' => 'string|required',
            'data_de_saida' => 'string|nullable',
            'descricao_do_problema' => 'string|nullable',
            'laudo' => 'string|nullable',
            'observacao' => 'string|nullable',
            'sub_total_servico' => 'string|required',
            'sub_total_produto' => 'string|required',
            'total_bruto' => 'string|required',
            'desconto' => 'string|nullable',
            'total_liquido' => 'string|required',
            'total' => 'string|required',
            'quote_service.*.codigo_do_servico' => 'string|nullable',
            'quote_service.*.descricao' => 'string|nullable',
            'quote_service.*.quantidade'  => 'integer|nullable',
            'quote_service.*.valor'  => 'string|nullable',
            'quote_service.*.desconto' => 'string|nullable',
            'quote_service.*.sub_total' => 'string|nullable',
            'quote_part.*.codigo_do_produto' => 'string|nullable',
            'quote_part.*.descricao' => 'string|nullable',
            'quote_part.*.quantidade' => 'string|nullable',
            'quote_part.*.valor' => 'string|nullable',
            'quote_part.*.desconto' => 'string|nullable',
            'quote_part.*.sub_total' => 'string|nullable',
        ];
    }

    public function execute(Request $request): JsonResponse
    {

        $data = $request->validate($this->rules());

        $numbering = $this->getCompanyNumbering($data);
        $data['company_numbering'] = $numbering;

        try{
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
        foreach($data['quote_service'] as $service) {
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
        $numbering->numbering += 1;

        $numbering->save();

        return $numbering->numbering;
    }

}
