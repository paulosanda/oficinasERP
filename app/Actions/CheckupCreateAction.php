<?php

namespace App\Actions;

use App\Models\Checkup;
use App\Models\CheckupObservation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckupCreateAction
{
    public function rules(): array
    {
        $rules = [
            'company_id' => 'integer|required',
            'customer_id' => 'integer|required',
            'vehicle_id' => 'integer|required',
            'front_damage' => 'string|nullable',
            'front_photo' => 'string|nullable',
            'back_damage' => 'string|nullable',
            'back_photo' => 'string|nullable',
            'right_side_damage' => 'string|nullable',
            'right_side_photo' => 'string|nullable',
            'left_side_damage' => 'string|nullable',
            'left_side_photo' => 'string|nullable',
            'roof_damage' => 'string|nullable',
            'roof_photo' => 'string|nullable',
            'fuel_gauge' => 'string|nullable',
            'fuel_gauge_photo' => 'string|nullable',
            'evaluation' => 'string|nullable',
        ];

        if (request()->has('checkup_observation') && is_array(request('checkup_observation'))) {
            $rules['checkup_observation.*.checkup_observation_type_id'] = 'required|integer';
            $rules['checkup_observation.*.observation'] = 'string';
        }

        return $rules;
    }

    public function execute(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules());

        try {
            $checkUpId = $this->createCheckUp($data);

            $this->createCheckUpObservation($checkUpId, $data);

            return response()->json(['message' => 'success'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    private function createCheckUp(array $data): int
    {
        unset($data['checkup_observation']);

        $checkUp = Checkup::create($data);

        return $checkUp->id;
    }

    private function createCheckUpObservation($checkUpId, $data): void
    {
        if ($data['checkup_observation']) {
            foreach ($data['checkup_observation'] as $observation) {
                CheckupObservation::create([
                    'checkup_id' => $checkUpId,
                    'checkup_observation_type_id' => $observation['checkup_observation_type_id'],
                    'observation' => $observation['observation'],
                ]);
            }
        }
    }
}
