<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $with = ['serviceOrderService', 'serviceOrderPart', 'vehicle', 'customer'];

    protected $fillable = [
        'company_id',
        'company_numbering',
        'customer_id',
        'vehicle_id',
        'status',
        'entry_date',
        'exit_date',
        'problem_description',
        'report',
        'observation',
        'subtotal_service',
        'subtotal_part',
        'gross_total',
        'discount',
        'net_total',
        'total',
    ];

    public function serviceOrderService(): HasMany
    {
        return $this->hasMany(ServiceOrderService::class);
    }

    public function serviceOrderPart(): HasMany
    {
        return $this->hasMany(ServiceOrderPart::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
