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
            'email' => 'email|nullable',
            'cellphone' => 'string|nullable',
            'telephone' => 'string|nullable',
            'cpf' => 'cpf|nullable',
            'rg' => 'string|nullable',
            'cnpj' => 'string|nullable',
            'inscricao_estadual' => 'string|nullable',
            'inscricao_municipal' => 'string|nullable',
            'birthday' => 'string|nullable',
            'address' => 'string|nullable',
            'number' => 'string|nullable',
            'postal_code' => 'string|nullable',
            'neighborhood' => 'string|nullable',
            'city' => 'string|nullable',
            'state' => 'string|nullable',
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
