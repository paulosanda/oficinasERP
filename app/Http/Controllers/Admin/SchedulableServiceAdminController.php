<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchedulableService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchedulableServiceAdminController extends Controller
{
    public function index(): JsonResponse
    {
        $schedulableServices = SchedulableService::all();

        return response()->json($schedulableServices->toArray(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $rules = ['service' => 'string|required'];

        $data = $request->validate($rules);

        $newService = SchedulableService::create([$data['service']]);

        return response()->json(['message' => 'success']);
    }

    public function update($schedulableServiceId, Request $request)
    {
        $rules = ['service' => 'required|string'];

        $data = $request->validate($rules);

        $updateService = SchedulableService::findOrFail($schedulableServiceId);
        $updateService->update(['service' => $data['service']]);

        return response()->json(['message'=> 'success']);
    }
}
