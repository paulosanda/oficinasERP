<?php

namespace App\Actions;

use App\Models\Company;
use App\Models\QuoteNumbering;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyCreateAction
{
    protected function rules(): array
    {
        return [
            'company_name' => 'string|required',
            'cnpj' => 'string|required',
            'inscricao_estadual' => 'string',
            'inscricao_municipal' => 'string',
            'address' => 'string|required',
            'number' => 'string|required',
            'neighborhood' => 'string|required',
            'postal_code' => 'string|required',
            'city' => 'string|required',
            'state' => 'string|required',
            'cellphone' => 'string|required',
            'email' => 'email|required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|nullable',
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        DB::beginTransaction();

        try {
            if (isset($data['logo'])) {
                $logoName = time().'_'.$data['logo']->getClientOriginalName();
                $path = $data['logo']->storeAs('public/logos', $logoName, 'public');
                $data['logo'] = $logoName;
            }
            $newCompany = Company::create($data);

            QuoteNumbering::create([
                'company_id' => $newCompany->id,
                'numbering' => 0,
            ]);

            DB::commit();

            return response()->json($newCompany, 200);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
