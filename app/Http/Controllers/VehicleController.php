<?php

namespace App\Http\Controllers;

use App\Actions\VehicleCreateAction;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function store(Request $request)
    {
        return app(VehicleCreateAction::class)->execute($request);
    }
}
