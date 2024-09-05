<?php

namespace App\Http\Controllers\Web\Company;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ScheduledServicesController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('company.schedule-admin');
    }

    public function show($scheduleId): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('company.schedule', compact('scheduleId'));
        //        return view('company.schedule')->with(['scheduleId' => $scheduleId]);
    }

    public function create($customerId): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('company.schedulable-create')->with(['customerId' => $customerId]);
    }
}
