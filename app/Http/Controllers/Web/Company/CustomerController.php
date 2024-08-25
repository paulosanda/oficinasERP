<?php

namespace App\Http\Controllers\Web\Company;

use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        return view('company.customer');
    }

    public function create()
    {
        return view('company.customer-create');
    }
}
