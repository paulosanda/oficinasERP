<?php

namespace App\Actions;


use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientCreateAction extends BaseAction
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

    public function execute(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = Validator::make($request->all(), $this->rules());

        if ($data->fails()) {
            return response()->json(['error' => $data->errors()], 422);
        }

        try {
            $newClient = Client::create($data->getData());

            $data = $newClient->toArray();

            return response()->json($data, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

}
