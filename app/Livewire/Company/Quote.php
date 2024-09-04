<?php

namespace App\Livewire\Company;

use App\Models\Customer;
use App\Models\Quote as ModelsQuote;
use App\Models\User;
use Livewire\Component;
use PharIo\Manifest\ElementCollectionException;

class Quote extends Component
{
    public int $quoteId;

    public $quote;

    public ?User $user;

    public bool $confirmModal = false;

    public bool $errorModal = false;

    public string $typePj = Customer::TYPE_PJ;

    public string $typePf = Customer::TYPE_PF;

    public string $statusMessage = '';

    public string $errorMessage = '';

    public string $status = '';

    public string $pending = ModelsQuote::PENDING;

    public string $accepted = ModelsQuote::ACCEPTED;

    public string $rejected = ModelsQuote::REJECTED;

    public function mount($quoteId): void
    {
        $this->quoteId = $quoteId;
    }

    public function render()
    {
        $this->user = auth()->user();

        $this->quote = ModelsQuote::find($this->quoteId);

        if ($this->user->company_id == $this->quote->company_id) {
            return view('livewire.company.quote')->with(['quote' => $this->quote]);
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

    }

    public function setAccepted(): void
    {
        $this->statusMessage = ModelsQuote::ACCEPTED;
        $this->status = ModelsQuote::ACCEPTED;

        $this->confirmModal = true;
    }

    public function setRejected(): void
    {
        $this->statusMessage = ModelsQuote::REJECTED;
        $this->status = ModelsQuote::REJECTED;

        $this->confirmModal = true;
    }

    public function setFinalized(): void
    {
        $this->statusMessage = ModelsQuote::FINISH;
        $this->status = ModelsQuote::FINISH;

        $this->confirmModal = true;
    }

    public function hideConfirmModal(): void
    {
        $this->confirmModal = false;
    }

    public function hideErrorModal(): void
    {
        $this->errorModal = false;
    }

    public function save(): void
    {
        $this->confirmModal = false;

        try {
            if ($this->status == $this->accepted) {
                $this->quote->update(['entry_date' => now()->format('Y-m-d')]);
            }
            $this->quote->update(['status' => $this->status]);
            $this->quote->save();

        } catch (ElementCollectionException|\Exception $exception) {
            $this->errorMessage = $exception->getMessage();
            $this->errorModal = true;
        }
    }
}
