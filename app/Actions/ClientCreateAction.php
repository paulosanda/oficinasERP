<?php

namespace App\Actions;


use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClientCreateAction
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

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $newClient = Client::create($data);

            return response()->json($newClient, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
