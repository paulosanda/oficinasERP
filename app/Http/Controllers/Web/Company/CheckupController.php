<?php

namespace App\Http\Controllers\Web\Company;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class CheckupController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('company.checkup-admin');
    }

    public function create($customerId): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('company.checkup-create')->with('customerId', $customerId);
    }

    public function show($checkupId): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('company.checkup')->with('checkupId', $checkupId);

    }
}
