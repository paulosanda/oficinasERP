<?php

namespace App\Actions;

use App\Models\Company;
use App\Models\QuoteNumbering;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $logo = $request->file('logo');
                $logoName = time().'_'.$logo->getClientOriginalName();
                $path = $logo->storeAs('public/logos', $logoName, 'public');
                $data['logo'] = basename($path);
            }
            $newCompany = Company::create($data);

            QuoteNumbering::create([
                'company_id' => $newCompany->id,
                'numbering' => 0,
            ]);

            return response()->json($newCompany, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
