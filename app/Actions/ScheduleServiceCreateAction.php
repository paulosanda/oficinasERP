<?php

namespace App\Actions;

use App\Models\ScheduledService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleServiceCreateAction
{
    public function rules(): array
    {
        return [
            'vehicle_id' => 'integer|required',
            'company_id' => 'integer|required',
            'customer_id' => 'integer|required',
            'schedulable_service_id' => 'integer|required',
            'current_mileage' => 'integer|nullable',
            'expected_mileage' => 'integer|nullable',
            'completion_mileage' => 'integer|nullable',
            'scheduled_date' => 'date|required|date_format:Y-m-d',
            'reminder_active' => 'boolean|required',
            'observation' => 'string',
            'customer_answer' => 'string',
        ];
    }

    //todo mudar a documentação swagger pois isto foi alterado
    public function messages(): array
    {
        return [
            'vehicle_id.integer|required' => 'Não foi possível identificar o veículo.',
            'company_id.integer|required' => 'Não foi possível identificar sua empresa.',
            'customer_id.integer|required' => 'Não foi possível identificar o cliente',
            'schedulable_service_id.integer|required' => 'Não foi possível identificar o serviço',
            'scheduled_date.date|required|date_format:Y-m-d' => 'A data não foi informada.',
            'reminder_active.boolean|required' => 'É preciso informar o estado para o lembrete',
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules(), $this->messages());

        try {
            $response = ScheduledService::create($data);

            return response()->json(['message' => 'success']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
