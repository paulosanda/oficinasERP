<?php

namespace App\Actions;

use App\Models\Company;
use App\Trait\EmptyEntity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CompanyUpdateAction
{
    use EmptyEntity;

    protected function rules(): array
    {
        return [
            'company_name' => 'string',
            'cnpj' => 'string',
            'inscricao_estadual' => 'string',
            'inscricao_municipal' => 'string',
            'address' => 'string',
            'number' => 'string',
            'neighborhood' => 'string',
            'postal_code' => 'string',
            'city' => 'string',
            'state' => 'string',
            'cellphone' => 'string',
            'email' => 'email',
        ];
    }

    public function execute(Request $request, $company_id): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $company = Company::findOrFail($company_id);

            $company->update($data);

            return response()->json(['message' => 'success']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }
}
