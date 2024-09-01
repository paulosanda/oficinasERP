<?php

namespace App\Http\Controllers\Web\Company;

use App\Http\Controllers\Controller;

class ScheduledServicesController extends Controller
{
    public function create($customerId)
    {
        return view('company.schedulable-service-create')->with(['customerId' => $customerId]);
    }
}
