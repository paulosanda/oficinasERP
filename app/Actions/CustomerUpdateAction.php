<?php

namespace App\Actions;


use App\Models\Customer;
use App\Trait\EmptyEntity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerUpdateAction
{
    use  EmptyEntity;

    protected string $object = 'Customer model';
    protected function rules(): array
    {
        return [
            'company_id' => 'integer|required',
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
        $data = $request->validate($this->rules());

        try{
            $customer = Customer::where('id', $data['id'])->where('company_id', $data['company_id'])->first();
            $this->isEmpty($customer, $this->object);

            unset($data['id']);
            unset($data['company_id']);

            $customer->update($data);

            return response()->json(['message' => 'success', 'customer created']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
