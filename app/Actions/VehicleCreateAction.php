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
            'brand' => 'string|nullable',
            'model' => 'string|nullable',
            'color' => 'string|nullable',
            'year' => 'string|nullable',
            'plate' => 'string|required',
            'identification_number' => 'string|nullable',
            'renavam' => 'string|nullable',
            'monthly_mileage' => 'string|nullable',
            'observation' => 'string|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.integer|required' => 'Algo deu errado, o cliente para este cadastro não foi encontrado',
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $vehicle = Vehicle::create($data);

            return response()->json([
                'message' => 'success',
                'vehicle_id' => $vehicle->id,
            ], 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }
}
