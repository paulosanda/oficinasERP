<?php

namespace App\Actions;


use App\Models\ScheduledService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleServiceCreateAction
{
    public function rules(): array
    {
        return [
            'company_id' => 'integer|required',
            'customer_id' => 'integer|required',
            'servico' => 'string|required',
            'data_prevista' => 'date|required|date_format:Y-m-d',
            'data_realizado' => 'date|date_format:Y-m-d',
            'lembrete_ativo' => 'boolean|required',
            'observacao' => 'string',
            'resposta' => 'string',
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $response = ScheduledService::create($data);

            return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
