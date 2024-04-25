<?php

namespace App\Actions;

use App\Models\Company;
use App\Models\QuoteNumbering;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompanyCreateAction
{
    protected function rules(): array
    {
        return [
            'company_name' => 'string|required',
            'cnpj' => 'string|required',
            'inscricao_estadual' => 'string',
            'inscricao_municipal' => 'string',
            'address' => 'string|required',
            'number' => 'string|required',
            'neighborhood' => 'string|required',
            'postal_code' => 'string|required',
            'city' => 'string|required',
            'estate' => 'string|required',
            'cellphone' => 'string|required',
            'email' => 'email|required'
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $newCompany = Company::create($data);

            QuoteNumbering::create([
               'company_id' => $newCompany->id,
               'numbering' => 0
            ]);

            return response()->json($newCompany, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
