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
            'scheduled_date' => 'date|required|date_format:Y-m-d',
            'completion_date' => 'date|date_format:Y-m-d',
            'reminder_active' => 'boolean|required',
            'observation' => 'string',
            'customer_answer' => 'string',
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $response = ScheduledService::create($data);

            return response()->json(['message' => 'success']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
