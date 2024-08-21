<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class CompanyController extends Controller
{
    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.company-create');
    }

    public function createUser($companyId): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.user-create')->with('companyId', $companyId);
    }

    public function admin(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.companies-admin');
    }
}
