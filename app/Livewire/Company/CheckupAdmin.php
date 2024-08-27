<?php

namespace App\Livewire\Company;

use App\Models\Checkup;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class CheckupAdmin extends Component
{
    public int $dateInterval = 7;

    public ?string $evaluation = null;

    public Checkup $checkup;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $user = auth()->user();

        $this->checkups = Checkup::where('company_id', $user->company_id)
            ->where('evaluation', $this->evaluation)
            ->where('created_at', '>=', now()->subDays($this->dateInterval))->get();

        return view('livewire.company.checkup-admin')->with([
            'checkups' => $this->checkups,
        ]);
    }

    public function setInterval(): void {}

    public function setEvaluation(): void
    {
        $this->evaluation = null;
    }

    public function setApproved(): void
    {
        $this->evaluation = 'aprovado para uso';
    }

    public function setMaintenance(): void
    {
        $this->evaluation = 'manutenção recomendada';
    }
}
