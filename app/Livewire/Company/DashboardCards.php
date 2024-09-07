<?php

namespace App\Livewire\Company;

use App\Models\ScheduledService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class DashboardCards extends Component
{
    public int $companyId;

    public $scheduledServices;

    public $checkups;

    public function mount(): void
    {
        $this->companyId = auth()->user()->company_id;

    }

    public function render(): View|Factory|Application
    {
        $this->scheduledServices = ScheduledService::where('company_id', $this->companyId)
            ->whereMonth('scheduled_date', now()->month)
            ->orderBy('scheduled_date', 'asc')
            ->take(10)
            ->get();

        $this->checkups = \App\Models\Checkup::where('company_id', $this->companyId)
            ->where('evaluation', 'pending')
            ->take(10)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.company.dashboard-cards')->with([
            'scheduledServices' => $this->scheduledServices,
            'checkups' => $this->checkups,
        ]);
    }
}
