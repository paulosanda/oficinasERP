<?php

namespace App\Http\Controllers\Web\Company;

use App\Http\Controllers\Controller;
use App\Models\Checkup;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class CheckupController extends Controller
{
    public function index()
    {
        return view('company.checkup-admin');
    }

    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('company.checkup-create');
    }

    public function show($checkupId)
    {
        $user = auth()->user();

        $checkup = Checkup::findOrFail($checkupId);

        if ($checkup->company_id == $user->company_id) {
            return view('company.checkup')->with(['checkup' => $checkup]);
        } else {
            abort(404);
        }

    }
}
