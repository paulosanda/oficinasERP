<?php

namespace App\Actions;

use App\Models\Vehicle;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleCreateAction
{
    public function rules(): array
    {
        return [
            'customer_id' => 'integer|required',
            'brand' => 'string',
            'model' => 'string',
            'color' => 'string',
            'year'  => 'string',
            'plate' => 'string|required',
            'identification_number' => 'string',
            'renavam' => 'string',
            'monthly_mileage' => 'string',
            'observation' => 'string',
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $vehicle = Vehicle::create($data);

            return response()->json(['message' => 'success'], 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }
}
