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
            'vehicle_id' => 'integer|required',
            'front_damage' => 'string',
            'front_photo' => 'string',
            'back_damage' => 'string',
            'back_photo' => 'string',
            'right_side_damage' => 'string',
            'right_side_photo' => 'string',
            'left_side_damage' => 'string',
            'left_side_photo' => 'string',
            'roof_damage' => 'string',
            'roof_photo' => 'string',
            'fuel_gauge' => 'string',
            'fuel_gauge_photo' => 'string',
            'evaluation' => 'string',
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
