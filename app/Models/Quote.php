<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    use HasFactory;

    protected $with = ['customer'];

    protected $fillable = [
        'company_id',
        'company_numbering',
        'customer_id',
        'vehicle_id',
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

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
