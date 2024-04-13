<?php

namespace App\Actions;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompanyCreateAction
{
    protected function rules(): array
    {
        return [
            'razao_social' => 'string|required',
            'cnpj' => 'string|required',
            'inscricao_estadual' => 'string',
            'inscricao_municipal' => 'string',
            'endereco' => 'string|required',
            'numero' => 'string|required',
            'bairro' => 'string|required',
            'cep' => 'string|required',
            'cidade' => 'string|required',
            'estado' => 'string|required',
            'celular' => 'string|required',
            'email' => 'email|required'
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $newCompany = Company::create($data);

            return response()->json($newCompany, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
