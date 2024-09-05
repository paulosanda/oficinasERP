<?php

namespace App\Livewire\Company;

use App\Models\ScheduledService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ScheduleAdmin extends Component
{
    public Carbon $currentMonth;

    public string $currentMonthName;

    public int $companyId;

    public function mount(): void
    {
        $this->companyId = Auth::user()->company_id;
        $this->currentMonth = Carbon::now()->startOfMonth();
        $this->updateCurrentMonthName();
    }

    private function updateCurrentMonthName(): void
    {
        $this->currentMonthName = $this->currentMonth->translatedFormat('F');
    }

    public function previousMonth(): void
    {
        $this->currentMonth = $this->currentMonth->copy()->subMonth()->startOfMonth();
        $this->updateCurrentMonthName();
    }

    public function nextMonth(): void
    {
        $this->currentMonth = $this->currentMonth->copy()->addMonth()->startOfMonth();
        $this->updateCurrentMonthName();
    }

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $startOfMonth = $this->currentMonth->copy()->startOfMonth();
        $endOfMonth = $this->currentMonth->copy()->endOfMonth();

        $scheduledServices = ScheduledService::whereBetween('scheduled_date', [$startOfMonth, $endOfMonth])
            ->where('company_id', $this->companyId)
            ->get();

        return view('livewire.company.schedule-admin')->with(['scheduledServices' => $scheduledServices]);
    }
}
