<?php

namespace App\Actions;


use App\Models\Company;
use App\Models\Customer;
use App\Trait\EmptyEntity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerUpdateAction
{
    use  EmptyEntity;

    protected function rules(): array
    {
        return [
            'company_id' => 'integer|required',
            'id' => 'integer|required',
            'tipo' => 'string',
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
        try{
            $this->isEmpty(Customer::class, Company::COMPANY_INDEX, $data['company_id']);

            $customer = Customer::where('id', $data['id'])->where('company_id', $data['company_id'])->first();

            unset($data['id']);
            unset($data['company_id']);

            $customer->update($data);

            return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
