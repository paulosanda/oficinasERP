<?php

namespace App\Livewire\Company;

use AllowDynamicProperties;
use App\Models\Checkup;
use App\Models\Checkup as ModelsCheckup;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Livewire\WithPagination;

#[AllowDynamicProperties] class CheckupAdmin extends Component
{
    use WithPagination, WithPagination;

    public int $dateInterval = 7;

    public ?string $evaluation = Checkup::EVALUATION_PENDING;

    public Checkup $checkup;

    public string $pending = ModelsCheckup::EVALUATION_PENDING;

    public string $approved = ModelsCheckup::EVALUATION_APPROVED;

    public string $maintenance = ModelsCheckup::EVALUATION_MAINTENANCE;

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $user = auth()->user();

        $this->checkups = Checkup::where('company_id', $user->company_id)
            ->where('evaluation', $this->evaluation)
            ->where('created_at', '>=', now()->subDays($this->dateInterval))->paginate(10);

        return view('livewire.company.checkup-admin')->with([
            'checkups' => $this->checkups,
        ]);
    }

    public function setInterval(): void {}

    public function setEvaluation(): void
    {
        $this->evaluation = $this->pending;
    }

    public function setApproved(): void
    {
        $this->evaluation = $this->approved;
    }

    public function setMaintenance(): void
    {
        $this->evaluation = $this->maintenance;
    }
}
