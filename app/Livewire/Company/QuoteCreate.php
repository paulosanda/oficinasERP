<?php

namespace App\Livewire\Company;

use App\Actions\QuoteCreateAction;
use App\Models\Checkup;
use App\Models\Quote;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuoteCreate extends Component
{
    public $user;

    public int $user_id = 0;

    public int $checkupId;

    public Checkup $checkup;

    public int $quoteId = 0;

    public string $problemDescription = '';

    public string $report = '';

    public string $observation = '';

    public float $partsSubtotal = 0;

    public float $serviceSubtotal = 0;

    public array $quoteServices = [];

    public array $quoteParts = [];

    public float $quoteTotal = 0;

    public float $quoteDiscount = 0;

    public float $quoteNetTotal = 0;

    public bool $confirmModal = false;

    public bool $successModal = false;

    public string $successMessage = '';

    public bool $errorModal = false;

    public string $errorMessage = '';

    public array $services = [];

    public array $parts = [];

    public string $total = '';

    public string $discount = '';

    public string $netTotal = '';

    public int $mileage;

    public function mount($checkupId): void
    {
        $this->user = Auth::user();

        $this->checkupId = $checkupId;

        $this->checkup = Checkup::find($checkupId);

        $this->quoteParts[] = [
            'part_code' => '',
            'description' => '',
            'quantity' => 1,
            'value' => 0,
            'grossTotal' => 0,
            'discount' => 0,
            'discount_value' => 0,
            'subtotal' => 0,
        ];

        $this->quoteServices[] = [
            'service_code' => '',
            'description' => '',
            'quantity' => 1,
            'value' => 0,
            'grossTotal' => 0,
            'discount' => 0,
            'discount_value' => 0,
            'subtotal' => 0,
        ];

    }

    public function addQuoteService(): void
    {
        $this->quoteServices[] = [
            'service_code' => '',
            'description' => '',
            'quantity' => 1,
            'value' => 0,
            'grossTotal' => 0,
            'discount' => 0,
            'discount_value' => 0,
            'subtotal' => 0,
        ];
    }

    public function addQuotePart(): void
    {
        $this->quoteParts[] = [
            'part_code' => '',
            'description' => '',
            'quantity' => 1,
            'value' => 0,
            'grossTotal' => 0,
            'discount' => 0,
            'discount_value' => 0,
            'subtotal' => 0,
        ];
    }

    public function updatePartSubtotal($index): void
    {
        $quantity = (int) $this->quoteParts[$index]['quantity'];
        $value = (float) $this->quoteParts[$index]['value'];
        $discount = (float) $this->quoteParts[$index]['discount'];

        $partSubtotalGross = max(0, ($quantity * $value));
        $this->quoteParts[$index]['grossTotal'] = $partSubtotalGross;

        $this->quoteParts[$index]['discount_value'] = round($partSubtotalGross * ($discount / 100), 2);

        $partSubtotalNet = $partSubtotalGross - $this->quoteParts[$index]['discount_value'];

        $this->quoteParts[$index]['subtotal'] = round($partSubtotalNet, 2);

        $this->partsSubtotal = 0;
        foreach ($this->quoteParts as $part) {
            $this->partsSubtotal += $part['subtotal'];
        }

        $this->setTotals();
    }

    public function removeQuotePart($index): void
    {
        $this->partsSubtotal = $this->partsSubtotal - $this->quoteParts[$index]['subtotal'];
        unset($this->quoteParts[$index]);
        $this->quoteParts = array_values($this->quoteParts);

        $this->setTotals();
    }

    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.company.quote-create');
    }

    public function updateServiceSubtotal($index): void
    {
        $quantity = (int) $this->quoteServices[$index]['quantity'];
        $value = (float) $this->quoteServices[$index]['value'];
        $discount = (float) $this->quoteServices[$index]['discount'];

        $serviceSubtotalGross = max(0, ($quantity * $value));
        $this->quoteServices[$index]['discount_value'] = round($serviceSubtotalGross * ($discount / 100), 2);
        $this->quoteServices[$index]['grossTotal'] = $serviceSubtotalGross;
        $serviceSubtotalNet = $serviceSubtotalGross - $this->quoteServices[$index]['discount_value'];

        $this->quoteServices[$index]['subtotal'] = round($serviceSubtotalNet, 2);

        $this->serviceSubtotal = 0;
        foreach ($this->quoteServices as $service) {
            $this->serviceSubtotal += $service['subtotal'];
        }

        $this->setTotals();
    }

    public function removeQuoteService($index): void
    {
        $this->serviceSubtotal = $this->serviceSubtotal - $this->quoteServices[$index]['subtotal'];
        unset($this->quoteServices[$index]);
        $this->quoteServices = array_values($this->quoteServices);

        $this->setTotals();
    }

    public function setTotals(): void
    {

        $this->quoteDiscount = 0;
        foreach ($this->quoteServices as $service) {
            $this->quoteDiscount += $service['discount_value'];
        }
        foreach ($this->quoteParts as $part) {
            $this->quoteDiscount += $part['discount_value'];
        }

        $this->quoteTotal = 0;
        foreach ($this->quoteServices as $service) {
            $this->quoteTotal += $service['grossTotal'];
        }
        foreach ($this->quoteParts as $part) {
            $this->quoteTotal += $part['grossTotal'];
        }

        $this->quoteNetTotal = 0;

        if ($this->quoteDiscount > 0) {
            $this->quoteNetTotal = round($this->quoteTotal - $this->quoteDiscount, 2);
        } else {
            $this->quoteNetTotal = round($this->quoteTotal, 2);
        }

    }

    public function showConfirmModal(): void
    {
        $this->user_id = $this->user->id;

        $this->services = [];
        $this->parts = [];
        $this->total = '';
        $this->discount = '';
        $this->netTotal = '';

        foreach ($this->quoteServices as $key => $item) {
            foreach ($item as $field => $value) {
                if ($field == 'quantity' || $field == 'service_code') {
                    $this->services[$key][$field] = (string) $value;
                } elseif (is_numeric($value)) {
                    $this->services[$key][$field] = number_format((float) $value, 2, ',', '.');
                } else {
                    $this->services[$key][$field] = (string) $value;
                }
            }
        }

        foreach ($this->quoteParts as $key => $item) {
            foreach ($item as $field => $value) {
                if ($field == 'quantity' || $field == 'service_code') {
                    $this->parts[$key][$field] = (string) $value;
                } elseif (is_numeric($value)) {
                    $this->parts[$key][$field] = number_format((float) $value, 2, ',', '.');
                } else {
                    $this->parts[$key][$field] = (string) $value;
                }
            }
        }
        $this->total = number_format((float) $this->quoteTotal, 2, ',', '.');
        $this->discount = number_format((float) $this->quoteDiscount, 2, ',', '.');
        $this->netTotal = number_format((float) $this->quoteNetTotal, 2, ',', '.');

        $this->confirmModal = true;
    }

    public function save(): void
    {
        $request = new Request();

        $request->merge([
            'company_id' => $this->user->company_id,
            'user_id' => $this->user->id,
            'customer_id' => $this->checkup->customer->id,
            'vehicle_id' => $this->checkup->vehicle_id,
            'status' => Quote::PENDING,
            'problem_description' => $this->problemDescription,
            'report' => $this->report,
            'observation' => $this->observation,
            'subtotal_service' => number_format($this->serviceSubtotal, 2, ',', '.'),
            'subtotal_part' => number_format($this->partsSubtotal, 2, ',', '.'),
            'gross_total' => $this->total,
            'discount' => $this->discount,
            'net_total' => $this->netTotal,
            'mileage' => $this->mileage,
        ]);

        $request->merge(['quote_service' => []]);

        foreach ($this->quoteServices as $service) {
            $request->merge([
                'quote_service' => array_merge($request->input('quote_service'), [
                    [
                        'service_code' => $service['service_code'],
                        'description' => (string) $service['description'],
                        'quantity' => (string) $service['quantity'],
                        'value' => number_format($service['value'], 2, ',', '.'),
                        'discount' => number_format($service['discount_value'], 2, ',', '.'),
                        'subtotal' => number_format($service['subtotal'], 2, ',', '.'),
                    ],
                ]),
            ]);
        }

        $request->merge(['quote_part' => []]);

        foreach ($this->quoteParts as $part) {
            $request->merge([
                'quote_part' => array_merge($request->input('quote_part'), [
                    [
                        'part_code' => $part['part_code'],
                        'description' => (string) $part['description'],
                        'quantity' => (string) $part['quantity'],
                        'value' => number_format($part['value'], 2, ',', '.'),
                        'discount' => number_format($part['discount_value'], 2, ',', '.'),
                        'subtotal' => number_format($part['subtotal'], 2, ',', '.'),
                    ],
                ]),
            ]);
        }

        try {
            $response = app(QuoteCreateAction::class)->execute($request);

            $this->quoteId = $response->getData(true)['quote_id'];

            $this->successMessage = 'Orçamento cadastrado com sucesso!';

            $this->successModal = true;

        } catch (\Exception $exception) {
            $this->confirmModal = false;

            $this->errorMessage = $exception->getMessage();

            $this->errorModal = true;

        }
    }

    public function hideConfirmModal(): void
    {
        $this->confirmModal = false;
    }

    public function hideSuccessModal(): void
    {
        $this->successModal = false;
        $this->confirmModal = false;
    }

    public function hideErrorModal(): void
    {
        $this->errorModal = false;
        $this->confirmModal = false;
    }
}
