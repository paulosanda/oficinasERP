<?php

namespace App\Actions;


use App\Models\Customer;
use App\Trait\CustomerBelongToClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerUpdateAction extends BaseAction
{
    use CustomerBelongToClient;
    protected function rules(): array
    {
        return [
            'id' => 'integer|required',
            'name' => 'string|required',
            'email' => 'email',
            'celular' => 'string',
            'telefone' => 'string',
            'cpf' => 'cpf',
            'rg' => 'string',
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
        $data = Validator::make($request->all(), $this->rules());

        if($data->fails()) {
            return response()->json(['error' => $data->errors()], 422);
        } else {
            try {
                $customerUpdate = $data->getData();

                $customer = Customer::find($customerUpdate['id']);

                if ($this->checkCustomerClient($customer->client_id)) {
                    $customer->update($customerUpdate);

                    return response()->json(['message' => 'success'], 200);
                } else {
                    return response()->json(['error' => 'invalid customer'], 422);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }
}
