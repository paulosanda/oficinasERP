<?php

namespace App\Actions;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CustomerCreateAction
{
    protected function rules(): array
    {
        return [
            'tipo' => 'string',
            'company_id' => 'required|integer',
            'name' => 'string|required',
            'email' => 'email',
            'celular' => 'string',
            'telefone' => 'string',
            'cpf' => 'cpf',
            'rg' => 'string',
            'cnpj' => 'string',
            'inscricao_estadual' => 'string',
            'inscricao_municipal' => 'string',
            'nascimento' => 'string',
            'endereco' => 'string',
            'numero' => 'string',
            'cep' => 'string',
            'bairro' => 'string',
            'cidade' => 'string',
            'estado' => 'string'
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $newCustomer = Customer::create($data);

            return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
