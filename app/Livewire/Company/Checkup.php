<?php

namespace App\Livewire\Company;

use App\Models\Checkup as ModelsCheckup;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Livewire\Component;

class Checkup extends Component
{
    public int $checkup_id;

    public int $checkupId;

    public ?string $evaluation = '';

    public bool $confirmModal = false;

    public string $evaluationMessage = '';

    public bool $errorModal = false;

    public string $errorMessage = '';

    public string $pending = ModelsCheckup::EVALUATION_PENDING;

    public string $approved = ModelsCheckup::EVALUATION_APPROVED;

    public string $maintenance = ModelsCheckup::EVALUATION_MAINTENANCE;

    public function mount($checkupId): void
    {
        $this->checkupId = $checkupId;
    }

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application|JsonResponse
    {
        $user = auth()->user();
        $checkup = ModelsCheckup::findOrfail($this->checkupId);

        if ($user->company_id == $checkup->company_id) {
            return view('livewire.company.checkup')->with(['checkup' => $checkup]);
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }

    public function setEvaluation(): void
    {
        $this->evaluationMessage = 'Pendente aprovação';
        $this->evaluation = $this->pending;
        $this->confirmModal = true;
    }

    public function setApproved(): void
    {
        $this->evaluationMessage = 'Aprovar para uso';
        $this->evaluation = $this->approved;
        $this->confirmModal = true;
    }

    public function setMaintenance(): void
    {
        $this->evaluationMessage = 'Recomendar manutenção';
        $this->evaluation = $this->maintenance;
        $this->confirmModal = true;
    }

    public function showConfirm(): void
    {
        $this->confirmModal = true;
    }

    public function hideConfirmModal(): void
    {
        $this->confirmModal = false;
    }

    public function hideErrorModal(): void
    {
        $this->confirmModal = false;
        $this->errorModal = false;
    }

    public function save(): void
    {
        try {
            $checkup = ModelsCheckup::findOrFail($this->checkupId);

            $evaluation = $this->evaluation ?: null;
            $checkup->update(['evaluation' => $this->evaluation]);

            $this->confirmModal = false;

        } catch (\Exception $exception) {
            $this->errorModal = true;
            $this->errorMessage = $exception->getMessage();

        }

    }
}
