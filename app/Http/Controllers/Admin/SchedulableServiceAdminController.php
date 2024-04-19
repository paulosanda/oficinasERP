<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchedulableService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchedulableServiceAdminController extends Controller
{
    // todo documentação
    public function index(): JsonResponse
    {
        $schedulableServices = SchedulableService::all();

        return response()->json($schedulableServices->toArray(), 200);
    }

    //todo documentação
    public function store(Request $request): JsonResponse
    {
        $rules = ['service' => 'string|required'];

        $data = $request->validate($rules);

        $newService = SchedulableService::create([$data['service']]);

        return response()->json(['message' => 'success']);
    }

    //todo documentação
    public function update($schedulableServiceId, Request $request)
    {
        $rules = ['service' => 'required|string'];

        $data = $request->validate($rules);

        $updateService = SchedulableService::findOrFail($schedulableServiceId);
        $updateService->update(['service' => $data['service']]);

        return response()->json(['message'=> 'success']);
    }
}
