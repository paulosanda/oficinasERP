<?php

namespace App\Livewire\Company;

use App\Models\Quote as ModelsQuote;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class QuoteAdmin extends Component
{
    use WithoutUrlPagination, WithPagination;

    public int $dateInterval = 7;

    public $quotes;

    public ?User $user;

    public ?string $status = ModelsQuote::PENDING;

    public string $pending = ModelsQuote::PENDING;

    public string $accepted = ModelsQuote::ACCEPTED;

    public string $rejected = ModelsQuote::REJECTED;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $this->user = auth()->user();

        $this->quotes = ModelsQuote::where('company_id', $this->user->company_id)
            ->where('status', $this->status)
            ->where('created_at', '>=', now()->subDays($this->dateInterval))->get();

        return view('livewire.company.quote-admin')->with([
            'quotes' => $this->quotes,
        ]);
    }

    public function setStatus(): void
    {
        $this->status = $this->pending;
    }

    public function setApproved(): void
    {
        $this->status = $this->accepted;
    }

    public function setRejected(): void
    {
        $this->status = $this->rejected;
    }

    public function setInterval(): void {}
}
