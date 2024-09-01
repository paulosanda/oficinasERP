<?php

namespace App\Http\Controllers\Web\Company;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class QuoteController extends Controller
{
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('company.quote-admin');
    }

    public function show($quoteId)
    {
        return view('company.quote')->with('quoteId', $quoteId);
    }

    public function create($checkupId): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('company.quote-create')->with(['checkupId' => $checkupId]);
    }
}
