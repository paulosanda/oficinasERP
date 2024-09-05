<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
    use HasFactory;

    const PENDING = 'pending';

    const ACCEPTED = 'accepted';

    const REJECTED = 'rejected';

    const FINISH = 'finish';

    protected $with = ['customer', 'vehicle', 'quoteService', 'quoteParts'];

    protected $fillable = [
        'user_id',
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
        'mileage',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function quoteService(): HasMany
    {
        return $this->hasMany(QuoteService::class);
    }

    public function quoteParts(): HasMany
    {
        return $this->hasMany(QuotePart::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
