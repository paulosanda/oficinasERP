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
            'telephone' => 'string|nullable',
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

    protected function messages(): array
    {
        return [
            'company_id.integer|required' => 'Algo errado ocorreu, o identificador de sua empresa não foi carregado para este cadastro.',
            'id.integer|required' => 'O cliente não pode ser identificado para alteração do cadastro',
            'name.string' => 'O nome do cliente não foi compreendido para alteração do cadastro',
            'email' => 'O email do cliente não foi compreendido para alteração do cadastro',
            'cellphone' => 'O celular do cliente não foi compreendido para alteração do cadastro',
        ];
    }

    public function execute(Request $request): JsonResponse
    {

        $data = $request->validate($this->rules(), $this->messages());
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
