<?php

namespace App\Actions;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerCreateAction extends BaseAction
{
    protected function rules(): array
    {
        return [
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

    public function execute(Request $request)
    {

        $data = Validator::make($request->all(), $this->rules());

        $user = Auth::user()->toArray();

        if ($data->fails()) {

            return response()->json(['error' => $data->errors()], 422);
        } else {
            $customer = $data->getData();

            $customer['client_id'] = $user['client']['id'];

            $customer = Customer::create($customer);

            if($customer) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['error' => 'fail'], 500);
            }

        }

    }
}
