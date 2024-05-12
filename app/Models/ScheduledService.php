<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ScheduledService extends Model
{
    use HasFactory;

    protected $with = ['company', 'customer', 'vehicle', 'schedulableService'];

    protected $fillable = [
        'vehicle_id',
        'company_id',
        'customer_id',
        'schedulable_service_id',
        'scheduled_date',
        'completion_date',
        'reminder_active',
        'observation',
        'customer_answer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function schedulableService(): BelongsTo
    {
        return $this->belongsTo(SchedulableService::class);
    }
}
