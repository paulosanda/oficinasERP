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
            'active' => 'boolean',
            'max_users' => 'integer',
        ];
    }

    protected function messages(): array
    {
        return [
            'company_name.required' => 'O nome da empresa é obrigatório.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'address.required' => 'O endereço é obrigatório.',
            'number.required' => 'O número é obrigatório.',
            'neighborhood.required' => 'O bairro é obrigatório.',
            'postal_code.required' => 'O CEP é obrigatório.',
            'city.required' => 'A cidade é obrigatória.',
            'state.required' => 'O estado é obrigatório.',
            'cellphone.required' => 'O celular é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'logo.image' => 'O arquivo de logo deve ser uma imagem.',
            'logo.mimes' => 'A logo deve ser um arquivo do tipo: jpeg, png, jpg, gif, svg.',
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules(), $this->messages());

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
