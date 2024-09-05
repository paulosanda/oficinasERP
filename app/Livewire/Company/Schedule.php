<?php

namespace App\Livewire\Company;

use App\Models\ScheduledService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Livewire\Component;

class Schedule extends Component
{
    public int $scheduleId;

    public ScheduledService $scheduledService;

    public function mount($scheduleId): void
    {
        $this->scheduleId = $scheduleId;
    }

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|null|JsonResponse
    {
        $this->scheduledService = ScheduledService::findOrFail($this->scheduleId);

        $user = auth()->user();

        if ($user->company_id == $this->scheduledService->company_id) {
            return view('livewire.company.schedule')->with(['scheduleId' => $this->scheduleId]);

        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);

        }

    }
}
