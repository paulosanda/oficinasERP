<?php

namespace App\Actions;

use App\Models\Customer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerCreateAction
{
    protected function rules(): array
    {
        return [
            'type' => 'string',
            'company_id' => 'required|integer',
            'name' => 'string|required',
            'email' => 'email',
            'cellphone' => 'string',
            'telephone' => 'string',
            'cpf' => 'cpf',
            'rg' => 'string',
            'cnpj' => 'string',
            'inscricao_estadual' => 'string',
            'inscricao_municipal' => 'string',
            'birthday' => 'string',
            'address' => 'string',
            'number' => 'string',
            'postal_code' => 'string',
            'neighborhood' => 'string',
            'city' => 'string',
            'estate' => 'string',
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $newCustomer = Customer::create($data);

            return response()->json(['message' => 'success']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
