<?php

namespace App\Actions;

use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleCreateAction
{
    public function rules(): array
    {
        return [
            'customer_id' => 'integer|required',
            'marca' => 'string',
            'modelo'=> 'string',
            'cor' => 'string',
            'ano' => 'string',
            'placa' => 'string|required',
            'numero_chassi' => 'string',
            'renavam' => 'string',
            'media_mensal_km_rodado' => 'string',
            'observacoes' => 'string',
        ];
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $vehicle = Vehicle::create($data);

            return response()->json(['message' => 'success'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }
}
