<?php

namespace App\Actions;

use App\Models\Company;
use App\Models\Customer;
use App\Trait\EmptyEntity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CustomerUpdateAction
{
    use EmptyEntity;

    protected function rules(): array
    {
        return [
            'company_id' => 'integer|required',
            'id' => 'integer|required',
            'type' => 'string',
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
            'state' => 'string',
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());
        try {
            $this->isEmpty(Customer::class, Company::COMPANY_INDEX, $data['company_id']);

            $customer = Customer::where('id', $data['id'])->where('company_id', $data['company_id'])->first();

            unset($data['id']);
            unset($data['company_id']);

            $customer->update($data);

            return response()->json(['message' => 'success']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
