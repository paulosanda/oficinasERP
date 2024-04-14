<?php

namespace App\Actions;

use App\Models\Company;
use App\Trait\EmptyEntity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CompanyUpdateAction
{
    use EmptyEntity;

    protected string $object = 'Company model';
    protected function rules(): array
    {
        return [
            'id' => 'integer|required',
            'razao_social' => 'string',
            'cnpj' => 'string',
            'inscricao_estadual' => 'string',
            'inscricao_municipal' => 'string',
            'endereco' => 'string',
            'numero' => 'string',
            'bairro' => 'string',
            'cep' => 'string',
            'cidade' => 'string',
            'estado' => 'string',
            'celular' => 'string',
            'email' => 'email'
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $company = Company::find($data['id']);
            $this->isEmpty($company, $this->object);
            unset($data['id']);
            $company->update($data);

            return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }  catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }
}
